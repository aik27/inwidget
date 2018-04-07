<?php

namespace inWidget\Exception;

/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        inWidgetException.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 *
 * @link http://inwidget.ru
 * @copyright 2014-2018 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @package inWidget
 *
 */

class inWidgetException extends \Exception
{
	public function __construct($text, $code, $cacheFile) 
	{
		$text = str_replace('{$cacheFile}', $cacheFile, $text);
		$text = strip_tags($text);
		$result = '<b>ERROR <a href="http://inwidget.ru/#error'.$code.'" target="_blank">#'.$code.'</a>:</b> '.$text;
		if($code >= 401) {
			file_put_contents($cacheFile, $result, LOCK_EX);
		}
		\Exception::__construct($result, $code);
	}
}