<?php
/**
 * Project:     InWidget: show pictures from instagram.com on your site!
 * File:        inwidget.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 * 
 * @link http://inwidget.ru
 * @copyright 2014 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.0.1
 * @package Inwidget
 *
 */
class inWidget {
	public $config = array();
	public $data = array();
	public $width = 260;
	public $inline = 4;
	public $view = 12;
	public $toolbar = true;
	public $preview = 'small';
	public $imgWidth = 0;
	public $cacheFile = 'cache/db.txt';
	public $answer = '';
	public $errors = array(
		101=>'Can\'t get access to file <b>{$cacheFile}</b>. Check permissions.',
		102=>'Can\'t get modification time of <b>{$cacheFile}</b>. Cache always be expired.',
		103=>'Can\'t send request. You need the cURL extension OR set allow_url_fopen to "true" in php.ini and openssl extension',
		401=>'Can\'t connect to Instagram API server. <br />If you want send request again, delete cache file or wait cache expiration. API server answer: <br /><br />{$answer}',
		402=>'Can\'t get data from Instagram API server. User OR CLIENT_ID not found.<br />If you want send request again, delete cache file or wait cache expiration.',
		403=>'Instagram account doesn\'t have any photo. <br />If you want send request again, delete cache file or wait cache expiration.',
	);
	public function __construct(){
		require_once 'config.php';
		$this->config = $CONFIG;
		$this->setOptions();
		$cacheFile = @fopen($this->cacheFile,'a+b');
		if(!is_resource($cacheFile)) die($this->getError(101));
		fclose($cacheFile);
	}
	public function apiQuery(){
		// -------------------------------------------------
		// Query #1. Try to get user ID and profile picture
		// -------------------------------------------------
		$this->answer = $this->send('https://api.instagram.com/v1/users/search?q='.$this->config['LOGIN'].'&client_id='.$this->config['CLIENT_ID']);
		$answer = json_decode($this->answer);
		if(is_object($answer)){
			if($answer->meta->code == 200 AND !empty($answer->data)){
				$this->data['userid'] 	= $answer->data[0]->id;
				$this->data['username'] = $answer->data[0]->username;
				$this->data['avatar'] 	= $answer->data[0]->profile_picture;
			}
			else die($this->getError(402));
		}
		else die($this->getError(401));
		// -------------------------------------------------
		// Query #2. Try to get profile statistic
		// -------------------------------------------------
		$this->answer = $this->send('https://api.instagram.com/v1/users/'.$this->data['userid'].'/?client_id='.$this->config['CLIENT_ID'].'');
		$answer = json_decode($this->answer);
		if(is_object($answer)){
			if($answer->meta->code == 200 AND !empty($answer->data)){
				$this->data['posts']	 = $answer->data->counts->media;
				$this->data['followers'] = $answer->data->counts->followed_by;
				$this->data['following'] = $answer->data->counts->follows;
			}
			else die($this->getError(402));
		}
		else die($this->getError(401));
		// -------------------------------------------------
		// Query #3. Try to get photo
		// -------------------------------------------------
		$this->answer = $this->send('https://api.instagram.com/v1/users/'.$this->data['userid'].'/media/recent/?client_id='.$this->config['CLIENT_ID'].'&count='.$this->config['imgCount']);
		$answer = json_decode($this->answer);
		if(is_object($answer)){
			if($answer->meta->code == 200){
				if(!empty($answer->data)){
					$images = array();
					foreach ($answer->data as $key=>$item){
						$images[$key]['link'] 		= $item->link;
						$images[$key]['large'] 		= $item->images->low_resolution->url;
						$images[$key]['fullsize'] 	= $item->images->standard_resolution->url;
						$images[$key]['small'] 		= $item->images->thumbnail->url;
					}
					$this->data['images'] = $images;
				}
				else die($this->getError(403));
			}
			else die($this->getError(402));
		}
		else die($this->getError(401));
	}
	public function getData(){
		$this->data = $this->getCache();
		if(empty($this->data)){
			$this->apiQuery();
			$this->createCache();
			$this->data = json_decode(file_get_contents($this->cacheFile));
		}
	}
	public function getCache(){
		if(filemtime($this->cacheFile)<=0) die($this->getError(102));
		$cacheExpTime = filemtime($this->cacheFile) + ($this->config['expiration']*60*60);
		if(time() > $cacheExpTime) return false;
		else {
			$rawData = file_get_contents($this->cacheFile);
			$cacheData = json_decode($rawData);
			if(!is_object($cacheData)) return $rawData;
			unset($rawData);
		}
		return $cacheData;
	}
	public function createCache(){
		$data = json_encode($this->data);
		file_put_contents($this->cacheFile,$data,LOCK_EX);
	}
	public function send($url){
		if(extension_loaded('curl')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, $url);
			$answer = curl_exec($ch);
			curl_close($ch);
			return $answer;
		}
		elseif(ini_get('allow_url_fopen') AND extension_loaded('openssl')){
			$answer = file_get_contents($url);
			return $answer;
		}
		else die($this->getError(103));
	}
	public function setOptions(){
		$this->width -= 2; 
		if(isset($_GET['width'])) 
			$this->width = (int)$_GET['width']-2;
		if(isset($_GET['inline'])) 
			$this->inline = (int)$_GET['inline'];
		if(isset($_GET['view']))  
			$this->view = (int)$_GET['view'];
		if(isset($_GET['toolbar']) AND $_GET['toolbar'] == 'false')  
			$this->toolbar = false;
		if(isset($_GET['preview'])) 
			$this->preview = $_GET['preview'];
		if($this->width>0) 
			$this->imgWidth = round(($this->width-(17+(9*$this->inline)))/$this->inline);
	}
	public function getError($code){
		$this->errors[$code] = str_replace('{$cacheFile}',$this->cacheFile,$this->errors[$code]);
		$this->errors[$code] = str_replace('{$answer}',strip_tags($this->answer),$this->errors[$code]);
		$result = '<b>ERROR <a href="http://inwidget.ru/#error'.$code.'" target="_blank">#'.$code.'</a>:</b> '.$this->errors[$code];
		if($code == 401 OR $code == 402 OR $code == 403){
			file_put_contents($this->cacheFile,$result,LOCK_EX);
		}
		return $result;
	}
}