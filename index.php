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
 * @copyright 2014 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.0.6
 * @package inWidget
 * 
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
setlocale(LC_ALL, "ru_RU.UTF-8");
header('Content-type: text/html; charset=utf-8');
		
require_once 'inwidget.php';

$inWidget = new inWidget();
$inWidget->getData();

require_once 'template.php';