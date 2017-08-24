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
 * @copyright 2014-2017 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.1.0
 * @package inWidget
 * 
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
setlocale(LC_ALL, "ru_RU.UTF-8");
header('Content-type: text/html; charset=utf-8');

if(phpversion() < "5.4.0") 		die('inWidget required PHP >= <b>5.4.0</b>. Your version: '.phpversion());
if(!extension_loaded('curl')) 	die('inWidget required <b>cURL PHP extension</b>. Please, install it or ask your hosting provider.');

require_once 'plugins/instagram-php-scraper/InstagramScraper.php';
require_once 'plugins/unirest-php/Unirest.php';
require_once 'inwidget.php';

$inWidget = new inWidget();
$inWidget->getData();

require_once 'template.php';