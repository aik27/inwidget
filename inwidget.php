<?php

/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        inwidget.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 *
 * @link http://inwidget.ru
 * @copyright 2014-2017 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.1.0
 * @package inWidget
 *
 */

use InstagramScraper\Instagram;

class inWidget {
	public $config = array();
	public $data = array();
	public $width = 260;
	public $inline = 4;
	public $view = 12;
	public $toolbar = true;
	public $preview = 'small';
	public $imgWidth = 0;
	public $cacheFile = 'cache/{$LOGIN}.txt';
	public $lang = array();
	public $langName = '';
	public $langPath = 'lang/';
	public $answer = '';
	public $errors = array(
		101=>'Can\'t get access to file <b>{$cacheFile}</b>. Check permissions.',
		102=>'Can\'t get modification time of <b>{$cacheFile}</b>. Cache always be expired.',
		// 103 error depricated
		// 401 error depricated
		// 402 error depricated
		// 403 error depricated
		// 404 error depricated
		// 405 error depricated
		// 406 error depricated
		// 407 error depricated
		500=>'{$answer}',
	);
	public function __construct() {
		require_once 'config.php';
		$this->config = $CONFIG;
		$this->checkConfig();
		$this->checkCacheRights();
		$this->setLang();
		$this->setOptions();
	}
	public function apiQuery() {
		try {
			$account = Instagram::getAccount($this->config['LOGIN']);
			if($account->isPrivate) {
				throw new Exception('Requested profile is private');
			}
			$this->data['userid'] 		= $account->id;
			$this->data['username'] 	= $account->username;
			$this->data['avatar'] 		= $account->profilePicUrl;
			$this->data['posts']	 	= $account->mediaCount;
			$this->data['followers'] 	= $account->followedByCount;
			$this->data['following'] 	= $account->followsCount;
			// by hashtag
			if(!empty($this->config['HASHTAG'])) {
				$mediaArray = array();
				$tags = explode(',', $this->config['HASHTAG']);
				if(!empty($tags)) {
					foreach ($tags as $key=>$item){
						$item = strtolower(trim($item));
						if(!empty($item)) {
							$mediaArray[] = Instagram::getMediasByTag($item, $this->config['imgCount']);
						}
					}
				}
				$medias = new ArrayObject();
				if(!empty($mediaArray)) {
					foreach ($mediaArray as $key=>$item){
						$medias = (object) array_merge((array) $medias, (array) $item);
					}
				}
				unset($mediaArray);
				//$medias = Instagram::getMediasByTag($this->config['HASHTAG'], $this->config['imgCount']);
			}
			// by profile
			else {
				$medias = Instagram::getMedias($this->config['LOGIN'], $this->config['imgCount']);
			}
			$images = array();
			if(!empty($medias)) {
				foreach ($medias as $key=>$item) {
					$images[$key]['id'] 			= $item->id;
					$images[$key]['code'] 			= $item->code;
					$images[$key]['created'] 		= $item->createdTime;
					$images[$key]['text'] 			= $item->caption;
					$images[$key]['link'] 			= $item->link;
					$images[$key]['fullsize'] 		= $item->imageHighResolutionUrl;
					$images[$key]['large'] 			= $item->imageStandardResolutionUrl;
					$images[$key]['small'] 			= $item->imageLowResolutionUrl;
					$images[$key]['likesCount'] 	= $item->likesCount;
					$images[$key]['commentsCount'] 	= $item->commentsCount;
					if(!empty($this->config['HASHTAG'])) {
						$images[$key]['authorId'] = $item->ownerId;
					}
					else {
						$images[$key]['authorId'] = $account->id;
					}
				}
			}
			$this->data['images'] = $images;
		} catch (Exception $e) {
			$this->data = array();
			$this->answer = $e->getMessage();
			die($this->getError(500));
		}
		// -------------------------------------------------
		// Get banned ids. Ignore any errors
		// -------------------------------------------------
		if(!empty($this->config['bannedLogins'])) {
			foreach ($this->config['bannedLogins'] as $key=>$item){
				try {
					$banned = Instagram::getAccount($item['login']);
					$this->config['bannedLogins'][$key]['id'] = $banned->id;
				} catch (Exception $e) {}
			}
			$this->data['banned'] = $this->config['bannedLogins'];
		}
	}
	public function getData() {
		$this->data = $this->getCache();
		if(empty($this->data)) {
			$this->apiQuery();
			$this->createCache();
			$this->data = json_decode(file_get_contents($this->cacheFile));
		}
	}
	public function getCache() {
		$mtime = @filemtime($this->cacheFile);
		if($mtime<=0) die($this->getError(102));
		$cacheExpTime = $mtime + ($this->config['cacheExpiration']*60*60);
		if(time() > $cacheExpTime) return false;
		else {
			$rawData = file_get_contents($this->cacheFile);
			$cacheData = json_decode($rawData);
			if(!is_object($cacheData)) return $rawData;
			unset($rawData);
		}
		return $cacheData;
	}
	public function createCache() {
		$data = json_encode($this->data);
		file_put_contents($this->cacheFile,$data,LOCK_EX);
	}
	public function checkConfig() {
		if(!empty($this->config['LOGIN'])) {
			$this->config['LOGIN'] = strtolower(trim($this->config['LOGIN']));
		}
		else die('LOGIN required in config.php');
		if(!empty($this->config['langDefault'])) {
			$this->config['langDefault'] = strtolower(trim($this->config['langDefault']));
		}
		else die('langDefault required in config.php');
		if(!empty($this->config['HASHTAG'])) {
			$this->config['HASHTAG'] = trim($this->config['HASHTAG']);
			$this->config['HASHTAG'] = str_replace('#','',$this->config['HASHTAG']);
		}
		$this->cacheFile = str_replace('{$LOGIN}', $this->config['LOGIN'], $this->cacheFile);
		if(!empty($this->config['bannedLogins'])) {
			$logins = explode(',', $this->config['bannedLogins']);
			if(!empty($logins)) {
				$this->config['bannedLogins'] = array();
				foreach ($logins as $key=>$item) {
					$item = strtolower(trim($item));
					$this->config['bannedLogins'][$key]['login'] = $item;
				}
			}
		}
		else $this->config['bannedLogins'] = array();
	}
	public function checkCacheRights() {
		$cacheFile = @fopen($this->cacheFile,'a+b');
		if(!is_resource($cacheFile)) die($this->getError(101));
		fclose($cacheFile);
	}
	public function setLang($name = '') {
		if(empty($name) AND $this->config['langAuto'] === true AND !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			$name = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if(!empty($name)){
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
	public function setOptions() {
		$this->width -= 2;
		if(isset($_GET['width']) AND (int)$_GET['width']>0)
			$this->width = $_GET['width']-2;
		if(isset($_GET['inline']) AND (int)$_GET['inline']>0)
			$this->inline = $_GET['inline'];
		if(isset($_GET['view']) AND (int)$_GET['view']>0)
			$this->view = $_GET['view'];
		if(isset($_GET['toolbar']) AND $_GET['toolbar'] == 'false' OR !empty($this->config['HASHTAG']))
			$this->toolbar = false;
		if(isset($_GET['preview']))
			$this->preview = $_GET['preview'];
		if($this->width>0)
			$this->imgWidth = round(($this->width-(17+(9*$this->inline)))/$this->inline);
		if(isset($_GET['lang']))
			$this->setLang($_GET['lang']);
	}
	public function isBannedUserId($id) {
		if(!empty($this->data->banned)) {
			foreach ($this->data->banned as $key1=>$cacheValue) {
				if(!empty($cacheValue->id) AND $cacheValue->id === $id) {
					if(!empty($this->config['bannedLogins'])) {
						foreach ($this->config['bannedLogins'] as $key2=>$configValue) {
							if($configValue['login'] === $cacheValue->login)
								return true;
						}
					}
				}
			}
		}
		return false;
	}
	public function countAvailableImages($images) {
		$count = 0;
		if(!empty($images)){
			foreach ($images as $key=>$item){
				if($this->isBannedUserId($item->authorId) == true) continue;
				$count++;
			}
		}
		return $count;
	}
	public function getError($code) {
		$this->errors[$code] = str_replace('{$cacheFile}',$this->cacheFile,$this->errors[$code]);
		$this->errors[$code] = str_replace('{$answer}',strip_tags($this->answer),$this->errors[$code]);
		$result = '<b>ERROR <a href="http://inwidget.ru/#error'.$code.'" target="_blank">#'.$code.'</a>:</b> '.$this->errors[$code];
		if($code >= 401) {
			file_put_contents($this->cacheFile,$result,LOCK_EX);
		}
		return $result;
	}
}