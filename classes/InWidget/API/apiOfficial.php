<?php

namespace inWidget\API;

use Unirest\Request;

/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        apiOfficial.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 *
 * @link http://inwidget.ru
 * @copyright 2014-2018 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @package inWidget\API
 *
 */

class apiOfficial extends apiModel 
{
	private $account = [];
	/**
	 * Get account data by login
	 *
	 * @param string $login
	 * @param string $token - access token
	 * @return array
	 * @throws Exception
	 */
	public function getAccountByLogin($login, $token) 
	{
		// save limit if data received early
		if(!empty($this->account) && $this->account['username'] === $login) {
			return $this->account;
		}
		$account = '';
		$answer = Request::get('https://api.instagram.com/v1/users/self/?access_token='.$token);
		$this->checkAnswer($answer,'getAccountByLogin');
		$this->account = $this->prepareAccountData($answer->body->data);
		return $this->account;
	}
	
	/**
	 * Get media data by login
	 *
	 * @param string $login
	 * @param string $token - access token
	 * @param int $count - maximum medias per page [optional]
	 * @param int $maxId - return media earlier than this max_id [optional]
	 * @return array
	 * @throws Exception
	 */
	public function getMediasByLogin($login, $token, $count = 30, $maxId = '') 
	{
		$index = 0;
		$medias = [];
		$isMoreAvailable = true;
		while ($index < $count && $isMoreAvailable) {
			$answer = Request::get('https://api.instagram.com/v1/users/self/media/recent/?access_token='.$token.'&max_id='.$maxId);
			$this->checkAnswer($answer);
			$nodes = $answer->body->data;
			if (empty($nodes)) {
				return [];
			}
			foreach ($nodes as $item) {
				if ($index === $count) {
					return $this->prepareMediasData($medias);
				}
				$medias[] = $item;
				$index++;
			}
			$maxId = $nodes[count($nodes) - 1]->id;
			if(!isset($answer->body->pagination->next_url)) $isMoreAvailable = false;
		}
		return $this->prepareMediasData($medias);
	}
	
	/**
	 * Get tagged media
	 *
	 * @param string $tag
	 * @param string $token - access token
	 * @param int $count - maximum medias per page [optional]
	 * @param string $maxId - return media earlier than this max_tag_id [optional]
	 * @return array
	 * @throws Exception
	 */
	public function getMediasByTag($tag, $token, $count = 30, $maxId = '') 
	{
		$index = 0;
		$medias = [];
		$isMoreAvailable = true;
		$tag = parent::prepareTag($tag);
		while ($index < $count && $isMoreAvailable) {
			$answer = Request::get('https://api.instagram.com/v1/tags/'.urlencode($tag).'/media/recent/?access_token='.$token.'&max_tag_id='.$maxId);
			$this->checkAnswer($answer);
			$nodes = $answer->body->data;
			if (empty($nodes)) {
				return $this->prepareMediasData($medias);
			}
			foreach ($nodes as $item) {
				if ($index === $count) {
					return $this->prepareMediasData($medias);
				}
				$medias[] = $item;
				$index++;
			}
			$maxId = $answer->body->pagination->next_max_tag_id;
			if(!isset($answer->body->pagination->next_url)) $isMoreAvailable = false;
		}
		return $this->prepareMediasData($medias);
	}
	
	/**
	 * Get tagged media from account
	 *
	 * @param string $tag
	 * @param string $login
	 * @param string $token - access token
	 * @param int $count - maximum medias per page [optional]
	 * @param string $maxId - return media earlier than this max_tag_id [optional]
	 * @return array
	 * @throws Exception
	 */
	public function getMediasByTagFromAccount($tag, $login, $token = '', $count = 30, $maxId = '')
	{
		$tag = parent::prepareTag($tag);
		$medias = $this->getMediasByLogin($login, $token, $count, $maxId);
		$result = [];
		foreach ($medias as $key=>$item) {
			if(preg_match("/#".$tag."/is", $item['text'])) {
				$result[] = $item;
			}
		}
		return $result;
	}
	
	/**
	 * Get account data independent of API names policy
	 *
	 * @param object $account
	 * @return array
	 */
	protected function prepareAccountData($account)
	{
		$data = [];
		$data['userid'] 	= $account->id;
		$data['username'] 	= $account->username;
		$data['avatar'] 	= $account->profile_picture;
		$data['full_name']	= $account->full_name;
		$data['bio']		= $account->bio;
		$data['website']	= $account->website;
		$data['posts']	 	= $account->counts->media;
		$data['followers'] 	= $account->counts->followed_by;
		$data['following'] 	= $account->counts->follows;
		return $data;
	}
	
	/**
	 * Get media data independent of API names policy
	 *
	 * @param object $medias
	 * @return array
	 */
	protected function prepareMediasData($medias)
	{
		$data = [];
		foreach ($medias as $key=>$item) {
			$data[$key]['id'] 				= $this->ejectMediaId($item->id);
			$data[$key]['code'] 			= $this->getCodeFromUrl($item->link);
			$data[$key]['created'] 			= $item->created_time;
			$data[$key]['text'] 			= $item->caption->text;
			$data[$key]['link'] 			= $item->link;
			$data[$key]['fullsize'] 		= $item->images->standard_resolution->url;
			$data[$key]['large'] 			= $item->images->low_resolution->url;
			$data[$key]['small'] 			= $item->images->thumbnail->url;
			$data[$key]['likesCount'] 		= $item->likes->count;
			$data[$key]['commentsCount'] 	= $item->comments->count;
			$data[$key]['authorId'] 		= $item->user->id;
		}
		return $data;
	}
	
	/**
	 * Get media ID from combinated data returned by API
	 *
	 * @param string $id
	 * @return string
	 */
	private function ejectMediaId($id) 
	{
		$id = explode('_', $id);
		return $id[0];
	}
	
	/**
	 * Get media code from URL
	 *
	 * @param string $url
	 * @return string
	 */
	private function getCodeFromUrl($url)
	{
		preg_match('#.*\/p\/(.*)/#i', $url, $matches);
		return $matches[1];
	}
	
	/**
	 * Check server response
	 *
	 * @param object $answer - returned by unirest-php library
	 * @param string $from - expected content type [to specify check]
	 * @return null
	 * @throws Exception
	 */
	public function checkAnswer($answer, $from = '') 
	{
		if(!is_object($answer)) {
			throw new \Exception('Unknown error. Server answer: '.$answer);
		}
		if($answer->code == 400) {
			throw new \Exception('Invalid ACCESS TOKEN. Server answer: '.$answer->raw_body);
		}
		if($answer->code == 429) {
			throw new \Exception('The maximum number of requests per hour has been exceeded.');
		}
		if($answer->code !== 200) {
			throw new \Exception('Unknown error. Server answer: '.$answer->raw_body);
		}
		if($from === 'getAccountByLogin') {
			if(empty($answer->body->data)) {
				throw new \Exception('Account with given username does not exist or not available in sandbox mode.');
			}
		}
	}
	
}