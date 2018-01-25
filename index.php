<?php 
/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        index.php
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

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING);
setlocale(LC_ALL, "ru_RU.UTF-8");
header('Content-type: text/html; charset=utf-8');

if(phpversion() < "5.4.0") 		die('inWidget required PHP >= <b>5.4.0</b>. Your version: '.phpversion());
if(!extension_loaded('curl')) 	die('inWidget required <b>cURL PHP extension</b>. Please, install it or ask your hosting provider.');

#require_once 'classes/Autoload.php';
require_once 'classes/InstagramScraper.php';
require_once 'classes/Unirest.php';
require_once 'classes/InWidget.php';

/* -----------------------------------------------------------
	Native initialization
 ------------------------------------------------------------*/

try {
	$inWidget = new \inWidget\Core;
	$inWidget->getData();
	include 'template.php';
}
catch (\Exception $e) {
	echo $e->getMessage();
}

/* -----------------------------------------------------------
	Custom initialization
------------------------------------------------------------*/

/*
try {

	// Options may change through class constructor. For example:
	
	$config = array(
		'LOGIN' => 'fotokto_ru',
		'HASHTAG' => '',
		'ACCESS_TOKEN' => '',
		'tagsBannedLogins' => '',
		'tagsFromAccountOnly' => false,
		'imgRandom' => false,
		'imgCount' => 30,
		'cacheExpiration' => 6,
		'cacheSkip' => false,
		'cachePath' =>  __DIR__.'/cache/',
		'skinDefault' => 'default',
		'skinPath'=> 'skins/',
		'langDefault' => 'ru',
		'langAuto' => false,
		'langPath' => __DIR__.'/langs/',
	);
	
	$inWidget = new \inWidget\Core($config);
	
	// Also, you may change default values of properties
	
	$inWidget->width = 800;			// widget width in pixels
	$inWidget->inline = 6;			// number of images in single line
	$inWidget->view = 18;			// number of images in widget
	$inWidget->toolbar = false;		// show profile avatar, statistic and action button
	$inWidget->preview = 'large';	// quality of images: small, large, fullsize
	$inWidget->adaptive = false;	// enable adaptive mode
	$inWidget->skipGET = true; 		// skip GET variables to avoid name conflicts
	$inWidget->setOptions(); 		// apply new values

	$inWidget->getData();
	include 'template.php';
	
	// Also, you may use API methods directly
	
	// $account = $inWidget->api->getAccountByLogin($config['LOGIN'], $config['ACCESS_TOKEN'], $config['imgCount']);
	// $mediasByLogin = $inWidget->api->getMediasByLogin($config['LOGIN'], $config['ACCESS_TOKEN'], $config['imgCount']);
	// $mediasByTag = $inWidget->api->getMediasByTag('girl', $config['ACCESS_TOKEN'], $config['imgCount']);

}
catch (\Exception $e) {
	echo $e->getMessage();
}
*/