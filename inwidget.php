<?php
/**
 * Project:     Inwidget: A PHP class showing images from Instagram.com
 * File:        inwidget.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 * 
 * @link http://inwidget.ru
 * @copyright 2014 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.0 (January 2014)
 * @package Inwidget
 *
 */
class inWidget {
	public $config = array();
	public $profile = array();
	public $data = array();
	public $width = 260;
	public $inline = 4;
	public $view = 12;
	public $toolbar = true;
	public $preview = 'small';
	public $imgWidth = 0;
	protected $cacheId;
	public function __construct(){
		require_once 'config.php';
		$this->config = $CONFIG;
		@mysql_connect($this->config['dbHost'], $this->config['dbUser'], $this->config['dbPassword']) OR die('Can\'t connect to the database. Check settings.');
		@mysql_select_db($this->config['dbName']) OR die('Database doesn\'t exist.');
		mysql_query('SET NAMES utf8');
		mysql_query('SET time_zone = "Europe/Moscow"');
		$this->setOptions();
	}
	public function getData(){
		$cacheData = $this->getCache();
		if(empty($cacheData)){
			mysql_query('LOCK TABLES `inwidget` WRITE');
			$this->deleteCache();
			$this->createCache();
			$this->makeQuery();
			$this->updateCache();
			mysql_query('UNLOCK TABLES');
		}
		else {
			$this->data = json_decode($cacheData['data']);
			$this->profile = $cacheData;
			unset($this->profile['data']);
		}
	}
	public function makeQuery(){
		$user = $this->send('https://api.instagram.com/v1/users/search?q='.$this->config['LOGIN'].'&client_id='.$this->config['CLIENT_ID']);
		$user = json_decode($user);
		if(!empty($user)){
			if($user->meta->code == 200){
				$this->profile['userid'] = $user->data[0]->id;
				$this->profile['username'] = $user->data[0]->username;
				$this->profile['avatar'] = $user->data[0]->profile_picture;
				unset($user);
			}
			else die('User OR CLIENT_ID not found');
		}
		else die('Can\'t connect to Instagram API server.');
		$stats = $this->send('https://api.instagram.com/v1/users/'.$this->profile['userid'].'/?client_id='.$this->config['CLIENT_ID'].'');
		$stats = json_decode($stats);
		if(!empty($stats)){
			if($stats->meta->code == 200){
				$this->profile['posts']	= $stats->data->counts->media;
				$this->profile['followers'] = $stats->data->counts->followed_by;
				$this->profile['following'] = $stats->data->counts->follows;
				unset($stats);
			}
			else die('User OR CLIENT_ID not found');
		}
		else die('Can\'t connect to Instagram API server.');
		$images = $this->send('https://api.instagram.com/v1/users/'.$this->profile['userid'].'/media/recent/?client_id='.$this->config['CLIENT_ID'].'&count='.$this->config['imgCount']);
		$images = json_decode($images);
		if(!empty($images)){
			if($images->meta->code == 200){
				if(!empty($images->data)){
					$this->data = $images->data;
					mysql_query('UPDATE `inwidget` SET `data` = "'.addslashes(json_encode($images->data)).'" WHERE `id` = '.$this->cacheId);
					unset($images);
				}
				else die('Empty data');
			}
			else die('CLIENT_ID not found');
		}
		else die('Can\'t connect to Instagram API server.');
	}
	public function createCache(){
		mysql_query('INSERT INTO `inwidget` SET `data` = ""');
		$this->cacheId = mysql_insert_id();
	}
	public function getCache(){
		$cacheData = mysql_query('SELECT * FROM `inwidget` WHERE `date` >= ADDDATE(NOW(), INTERVAL -'.$this->config['expiration'].' HOUR) LIMIT 1');
		$cacheData = mysql_fetch_array($cacheData);
		return $cacheData;
	}
	public function updateCache(){
		mysql_query('UPDATE `inwidget` SET 
			`userid` 	= '.$this->profile['userid'].',
			`username` 	= "'.$this->profile['username'].'", 
			`avatar` 	= "'.$this->profile['avatar'].'", 
			`posts` 	= '.$this->profile['posts'].', 
			`followers` = '.$this->profile['followers'].', 
			`following` = '.$this->profile['following'].' 
		WHERE `id` = '.$this->cacheId);
	}
	public function deleteCache(){
		mysql_query('DELETE FROM `inwidget` WHERE `date` < ADDDATE(NOW(), INTERVAL -'.$this->config['expiration'].' HOUR)');
	}
	public function send($url){
		if(extension_loaded('curl')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0');
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
		else die('Can\'t send request. You need the cURL extension OR set allow_url_fopen to "true" in php.ini and openssl extension');
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
}