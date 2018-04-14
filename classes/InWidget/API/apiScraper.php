<?php

namespace inWidget\API;

/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        apiScraper.php
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

class apiScraper extends apiModel 
{
	public $api = '';
	
	public function __construct($login = '', $password = '') 
	{
		$this->api = new \InstagramScraper\Instagram();
		if(!empty($login) AND !empty($password)) {
			$api = $this->api->withCredentials($login, $password);
			$api->login();
			$this->api = $api;
		}
	}
	
	/**
	 * Get account data by login
	 *
	 * @param string $login
	 * @param string $token - fake param, not needed to this API driver
	 * @return array
	 * @throws Exception
	 */
	public function getAccountByLogin($login, $token='') 
	{
		$account = $this->api->getAccount($login);
		if($account->isPrivate()) {
			throw new \Exception('Requested profile is private');
		}
		return $this->prepareAccountData($account);
	}
	
	/**
	 * Get media data by login
	 *
	 * @param string $login
	 * @param string $token - fake param, not needed to this API driver
	 * @param int $count - maximum medias per page [optional]
	 * @param int $maxId - return media earlier than this max_id [optional]
	 * @return array
	 * @throws Exception
	 */
	public function getMediasByLogin($login, $token = '', $count = 30, $maxId = '') 
	{
		$medias = $this->api->getMedias($login, $count, $maxId);
		return $this->prepareMediasData($medias);
	}
	
	/**
	 * Get tagged media
	 *
	 * @param string $tag
	 * @param string $token - fake param, not needed to this API driver
	 * @param int $count - maximum medias per page [optional]
	 * @param string $maxId - return media earlier than this max_tag_id [optional]
	 * @return array
	 * @throws Exception
	 */
	public function getMediasByTag($tag, $token = '', $count = 30, $maxId = '') 
	{
		$tag = parent::prepareTag($tag);
		$medias = $this->api->getMediasByTag($tag, $count, $maxId);
		return $this->prepareMediasData($medias);
	}
	
	/**
	 * Get tagged media from account
	 *
	 * @param string $tag
	 * @param string $login
	 * @param string $token - fake param, not needed to this API driver
	 * @param int $count - maximum medias per page [optional]
	 * @param string $maxId - return media earlier than this max_id [optional]
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
		$data['userid'] 	= $account->getId();
		$data['username'] 	= $account->getUsername();
		$data['avatar'] 	= $account->getProfilePicUrl();
		$data['full_name']	= $account->getFullName();
		$data['bio']		= $account->getBiography();
		$data['website']	= $account->getExternalUrl();
		$data['posts']	 	= $account->getMediaCount();
		$data['followers'] 	= $account->getFollowedByCount();
		$data['following'] 	= $account->getFollowsCount();
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
			$data[$key]['id'] 				= $item->getId();
			$data[$key]['code'] 			= $item->getShortCode();
			$data[$key]['created'] 			= $item->getCreatedTime();
			$data[$key]['text'] 			= $item->getCaption();
			$data[$key]['link'] 			= $item->getLink();
			$data[$key]['fullsize'] 		= $item->getImageHighResolutionUrl();
			$data[$key]['large'] 			= $item->getImageStandardResolutionUrl();
			$data[$key]['small'] 			= $item->getImageLowResolutionUrl();
			$data[$key]['likesCount'] 		= $item->getLikesCount();
			$data[$key]['commentsCount'] 	= $item->getCommentsCount();
			$data[$key]['authorId'] 		= $item->getOwnerId();
		}
		return $data;
	}
	
}