<?php

namespace inWidget;

use inWidget\API\apiModel;
use inWidget\Exception\inWidgetException;

/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        Core.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 *
 * @link http://inwidget.ru
 * @copyright 2014-2018 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.2.0
 * @package inWidget
 *
 */

class Core
{
	public $config = [];
	public $data = [];
	public $api = false;
	private $account = false;
	private $medias = false;
	private $banned = [];
	public $width = 260;
	public $inline = 4;
	public $view = 12;
	public $toolbar = true;
	public $adaptive = false;
	public $preview = 'large';
	public $imgWidth = 0;
	public $skipGET = false;
	public $lang = [];
	public $langName = '';
	public $langAvailable = ['ru','en'];
	private $langPath = 'langs/';
	private $cachePath = 'cache/';
	private $cacheFile = '{$fileName}.txt';
	public $skinName = 'default';
	public $skinPath = 'skins/';
	public $skinAvailable = [
		'default',
		'modern-blue',
		'modern-green',
		'modern-red',
		'modern-orange',
		'modern-grey',
		'modern-black',
		'modern-violet',
		'modern-yellow',
	];
	/**
	 * @param array $config [optional] - like config.php
	 * @return null
	 */
	public function __construct($config = []) 
	{
		if(!empty($config)) {
			$this->config = $config;
		}
		else {
			require_once 'config.php';
			$this->config = $CONFIG;
		}
		$this->checkConfig();
		$this->checkCacheRights();
		$this->setLang();
		$this->setSkin();
		$this->setOptions();
		if(!empty($this->config['ACCESS_TOKEN'])) {
			$this->api = apiModel::getInstance('official');
		}
		else {
			$this->api = apiModel::getInstance();
		}
	}
	/**
	 * Send request to Instagram
	 *
	 * @return null
	 * @throws inWidgetException
	 */
	private function apiQuery() 
	{
		try {
			$this->account = $this->api->getAccountByLogin($this->config['LOGIN'], $this->config['ACCESS_TOKEN']);
			// by hashtag
			if(!empty($this->config['HASHTAG'])) {
				$mediaArray = [];
				$tags = explode(',', $this->config['HASHTAG']);
				if(!empty($tags)) {
					foreach ($tags as $key=>$item) {
						if(!empty($item)) {
							if($this->config['tagsFromAccountOnly'] === true) {
								$mediaArray[] = $this->api->getMediasByTagFromAccount($item, $this->config['LOGIN'], $this->config['ACCESS_TOKEN'], $this->config['imgCount']);
							}
							else {
								$mediaArray[] = $this->api->getMediasByTag($item, $this->config['ACCESS_TOKEN'], $this->config['imgCount']);
							}
						}
					}
				}
				$medias = [];
				if(!empty($mediaArray)) {
					foreach ($mediaArray as $key=>$item){
						$medias = array_merge($medias, $item);
					}
				}
				$this->medias = $medias;
				unset($mediaArray,$medias);
			}
			// by profile
			else {
				$this->medias = $this->api->getMediasByLogin($this->config['LOGIN'], $this->config['ACCESS_TOKEN'], $this->config['imgCount']);
			}
		} catch (\Exception $e) {
			throw new inWidgetException($e->getMessage(), 500, $this->getCacheFilePath());
		}
		// Get banned ids. Ignore any errors
		if(!empty($this->config['tagsBannedLogins'])) {
			foreach ($this->config['tagsBannedLogins'] as $key=>$item) {
				try {
					$banned = $this->api->getAccountByLogin($item['login'], $this->config['ACCESS_TOKEN']);
					$this->config['tagsBannedLogins'][$key]['id'] = $banned['userid'];
				} catch (\Exception $e) {}
			}
			$this->banned = $this->config['tagsBannedLogins'];
		}
	}
	/**
	 * Get data from Instagram (or actual cache)
	 *
	 * @return object
	 * @throws Exception
	 * @throws inWidgetException
	 */
	public function getData() 
	{
		$this->data = $this->getCache();
		if(empty($this->data)) {
			$this->apiQuery();
			$this->createCache();
			$this->data = json_decode(file_get_contents($this->getCacheFilePath()));
		}
		if(!is_object($this->data)) {
			throw new \Exception('<b style="color:red;">Cache file contains plain text:</b><br />'.$this->data);
		}
		return $this->data;
	}
	/**
	 * Get data independent of API names policy
	 * @return array
	 */
	private function prepareData() 
	{
		$data = $this->account;
		$data['banned'] = $this->banned;
		$data['tags']	= $this->config['HASHTAG'];
		$data['images']	= $this->medias;
		return $data;
	}
	/**
	 * @return mixed
	 * @throws inWidgetException
	 */
	private function getCache() 
	{
		if($this->config['cacheSkip'] === true) {
			return false;
		}
		$mtime = @filemtime($this->getCacheFilePath());
		if($mtime<=0) {
			throw new inWidgetException('Can\'t get modification time of <b>{$cacheFile}</b>. Cache always be expired.', 102, $this->getCacheFilePath());
		}
		$cacheExpTime = $mtime + ($this->config['cacheExpiration']*60*60);
		if(time() > $cacheExpTime) return false;
		else {
			$rawData = file_get_contents($this->getCacheFilePath());
			$cacheData = json_decode($rawData);
			if(!is_object($cacheData)) return $rawData;
			unset($rawData);
		}
		return $cacheData;
	}
	/**
	 * @return null
	 */
	private function createCache() 
	{
		$data = json_encode($this->prepareData());
		file_put_contents($this->getCacheFilePath(), $data, LOCK_EX);
	}
	/**
	 * @return string
	 */
	public function getCacheFilePath() 
	{
		return $this->cachePath.''.$this->cacheFile;
	}
	/**
	 * Check important values and prepare to work
	 * 
	 * @return null
	 * @throws Exception
	 */
	private function checkConfig() 
	{
		if(empty($this->config['LOGIN'])) {
			throw new \Exception(__CLASS__.': LOGIN required in config.php');
		}
		if(!in_array($this->config['langDefault'], $this->langAvailable, true)){
			throw new \Exception(__CLASS__.': default language does not present in "langAvailable" class property');
		}
		if(!in_array($this->config['skinDefault'], $this->skinAvailable, true)){
			throw new \Exception(__CLASS__.': default skin does not present in "skinAvailable" class property');
		}
		$this->langPath = __DIR__.'/'.$this->langPath; // PHP < 5.6 fix
		$this->cachePath = __DIR__.'/'.$this->cachePath; // PHP < 5.6 fix
		$this->config['LOGIN'] = strtolower(trim($this->config['LOGIN']));
		$cacheFileName = md5($this->config['LOGIN']);
		if(!empty($this->config['HASHTAG'])) {
			$this->config['HASHTAG'] = trim($this->config['HASHTAG']);
			$this->config['HASHTAG'] = str_replace('#', '', $this->config['HASHTAG']);
			$cacheFileName = md5($this->config['HASHTAG'].'_tags');
		}
		if(!empty($this->config['skinPath'])) {
			$this->skinPath = $this->config['skinPath'];
		}
		if(!empty($this->config['cachePath'])) {
			$this->cachePath = $this->config['cachePath'];
		}
		if(!empty($this->config['langPath'])) {
			$this->langPath = $this->config['langPath'];
		}
		$this->cacheFile = str_replace('{$fileName}', $cacheFileName, $this->cacheFile);
		if(!empty($this->config['tagsBannedLogins'])) {
			$logins = explode(',', $this->config['tagsBannedLogins']);
			if(!empty($logins)) {
				$this->config['tagsBannedLogins'] = [];
				foreach ($logins as $key=>$item) {
					$item = strtolower(trim($item));
					$this->config['tagsBannedLogins'][$key]['login'] = $item;
				}
			}
		}
		else $this->config['tagsBannedLogins'] = [];
	}
	/**
	 * Let me know if cache file not writable
	 * 
	 * @return null
	 * @throws inWidgetException
	 */
	private function checkCacheRights() 
	{
		$cacheFile = @fopen($this->getCacheFilePath(), 'a+b');
		if(!is_resource($cacheFile)) {
			throw new inWidgetException('Can\'t get access to file <b>{$cacheFile}</b>. Check file path or permissions.', 101, $this->getCacheFilePath());
		}
		fclose($cacheFile);
	}
	/**
	 * Set widget lang
	 * New value must be present in langAvailable property necessary
	 * 
	 * @param string $name [optional]
	 * @return null
	 */
	public function setLang($name = '') 
	{
		if(empty($name) AND $this->config['langAuto'] === true AND !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			$name = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if(!empty($name) AND in_array($name, $this->langAvailable, true)){
			$name = strtolower($name);
			if(file_exists($this->langPath.$name.'.php')) {
				$this->langName = $name;
				require $this->langPath.$name.'.php';
			}
		}
		if(empty($LANG)) {
			$this->langName = $this->config['langDefault'];
			require $this->langPath.$this->config['langDefault'].'.php';
		}
		$this->lang = $LANG;
	}
	/**
	 * Set widget skin
	 * New value must be present in skinAvailable property necessary
	 * 
	 * @param string $name [optional]
	 * @return null
	 */
	public function setSkin($name = '') 
	{
		if(!empty($name) AND in_array($name, $this->skinAvailable, true)){
			$this->skinName = $name;
		}
		else $this->skinName = $this->config['skinDefault'];
	}
	/**
	 * Set new values of properties through the $_GET 
	 * 
	 * @return null
	 */
	public function setOptions() 
	{
		$this->width -= 2;
		if($this->skipGET === false) {
			if(isset($_GET['width']) AND (int)$_GET['width']>0)
				$this->width = $_GET['width']-2;
			if(isset($_GET['inline']) AND (int)$_GET['inline']>0)
				$this->inline = $_GET['inline'];
			if(isset($_GET['view']) AND (int)$_GET['view']>0)
				$this->view = $_GET['view'];
			if(isset($_GET['toolbar']) AND $_GET['toolbar'] == 'false' OR !empty($this->config['HASHTAG']))
				$this->toolbar = false;
			if(isset($_GET['adaptive']) AND $_GET['adaptive'] == 'true')
				$this->adaptive = true;
			if(isset($_GET['preview']))
				$this->preview = $_GET['preview'];
			if(isset($_GET['lang']))
				$this->setLang($_GET['lang']);
			if(isset($_GET['skin']))
				$this->setSkin($_GET['skin']);
		}
		if($this->width>0) 
			$this->imgWidth = round(($this->width-(17+(9*$this->inline)))/$this->inline);
	}
	/**
	 * Let me know if this user was banned
	 * 
	 * @param int $id
	 * @return bool
	 */
	public function isBannedUserId($id) 
	{
		if(!empty($this->data->banned)) {
			foreach ($this->data->banned as $key1=>$cacheValue) {
				if(!empty($cacheValue->id) AND $cacheValue->id === $id) {
					if(!empty($this->config['tagsBannedLogins'])) {
						foreach ($this->config['tagsBannedLogins'] as $key2=>$configValue) {
							if($configValue['login'] === $cacheValue->login)
								return true;
						}
					}
				}
			}
		}
		return false;
	}
	/**
	 * Get number of images without images of banned users
	 * 
	 * @param object $images
	 * @return int
	 */
	public function countAvailableImages($images) 
	{
		$count = 0;
		if(!empty($images)){
			foreach ($images as $key=>$item){
				if($this->isBannedUserId($item->authorId) == true) continue;
				$count++;
			}
		}
		return $count;
	}
}