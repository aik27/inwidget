<?php 
/**
 * Project:     Inwidget: A PHP class showing images from Instagram.com
 * File:        template.php
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

if(!$inWidget) die('inWidget object not init.');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>Instagram</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="ru" />
		<meta http-equiv="content-style-type" content="text/css2" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<style type='text/css'>
			body {
				color: #212121;
   				font-family: arial;
   				font-size:12px;
   				padding:0px;
   				margin:0px;
			}
			img {
				border: 0;
			}
			.clear {
				clear:both;
				height:1px;
				line-height:1px;
			}
			.widget {
				width:<?php echo $inWidget->width; ?>px;
				border:1px solid #c3c3c3;
				background:#f9f9f9;
				border-radius: 5px 5px 5px 5px;
				-webkit-border-radius: 5px 5px 5px 5px;
				-moz-border-radius: 5px 5px 5px 5px;
				overflow:hidden;
			}
			.widget a.title:link, .widget a.title:visited  {
				display:block;
				height:33px;
				background:#46729b url(i/bg-title.gif) repeat-x;
				text-decoration:none;
			}
				.widget .title .icon{
					display:block;
					float:left;
					width:25px;
					height:25px;
					margin:4px 10px 0 5px;
				}
				.widget .title .text {
					float:left;
					width: <?php echo ($inWidget->width-44); ?>px;
					height:25px;
					overflow:hidden;
					margin:5px 0 0 0;
					color:#FFF;
					font-size:18px;
					white-space:nowrap;
					<?php if($inWidget->width<130) echo 'display:none'; ?>
				}
			.widget .profile {
				width:100%;
				border-collapse: collapse;
			}
				.widget .profile tr td {
					padding:0px;
					margin:0px;
					text-align:center;
				}
				.widget .profile td {
					border:1px solid #c3c3c3;
				}
				.widget .profile .avatar {
					width:1%;
					padding:10px !important;
					border-left:none !important;
					line-height:0px;
				}
					.widget .profile .avatar img {
						width:60px;
					}
				.widget .profile .value {
					width:33%;
					height:30px;
					font-size:14px;
					font-weight:bold;
				}
				.widget .profile span {
					display:block;
					font-size:9px;
					font-weight:bold;
					color:#999999;
					margin:-2px 0 0 0;
				}
			.widget .data{
				text-align:left;
				margin:10px 0 0 10px;
				padding:0 0 5px 0;
			}
				.widget .data .image {
					display:block;
					float:left;
					margin:0 5px 5px 0;
					width:<?php echo $inWidget->imgWidth; ?>px;
					height:<?php echo $inWidget->imgWidth; ?>px;
					overflow:hidden;
					border:2px solid #FFF;
					box-shadow: 0 1px 1px rgba(0,0,0,0.3);
					ling-height:0px;
					
				}
					.widget .data .image img{
						width:<?php echo $inWidget->imgWidth; ?>px;
					}
				.widget .data .image:hover {
					filter: alpha(opacity=80);
    				opacity: 0.8;
				}
			.widget a.follow:link, .widget a.follow:visited {
				display:block;
				background:#ad4141;
				text-decoration:none;
				font-size:14px;
				color:#FFF;
				font-weight:bold;
				width:130px;
				margin:0 auto 0 auto;
				padding:4px 4px 4px 10px;
				border:3px solid #FFF;
				border-radius: 5px 5px 5px 5px;
				-webkit-border-radius: 5px 5px 5px 5px;
				-moz-border-radius: 5px 5px 5px 5px;
				box-shadow: 0 0px 2px rgba(0,0,0,0.5);
			}
			.widget a.follow:hover {
				background:#cf3838;
			}
			.copy {
				margin:3px 0 0 0;
				font-size:10px;
				color:#666;
				text-align:center;
			}
				.copy a:link, .copy a:visited {
					text-decoration:none;
					color:#666;
				}
				.copy a:hover {
					text-decoration:underline;
				}
		</style>
	</head>
<body>
<div class='widget'>
	<?php 
		// выводим заголовок
		echo '
		<a href="http://instagram.com/'.$inWidget->profile['username'].'" target="_blank" class="title">
			<img src="i/icon.png" class="icon" />
			<div class="text">'.$inWidget->config['title'].'</div>
			<div class="clear">&nbsp;</div>
		</a>';
		// выводим тулбар
		if($inWidget->toolbar == true) { 
			echo '
			<table class="profile">
				<tr>
					<td rowspan="2" class="avatar">
						<a href="http://instagram.com/'.$inWidget->profile['username'].'" target="_blank"><img src="'.$inWidget->profile['avatar'].'"></a>
					</td>
					<td class="value">
						'.$inWidget->profile['posts'].'
						<span>posts</span>
					</td>
					<td class="value">
						'.$inWidget->profile['followers'].'
						<span>followers</span>
					</td>
					<td class="value" style="border-right:none !important;">
						'.$inWidget->profile['following'].'
						<span>following</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="border-right:none !important;">
						<a href="http://instagram.com/'.$inWidget->profile['username'].'" class="follow" target="_blank">Посмотреть &#9658;</a>
					</td>
				</tr>
			</table>';
		}
		if(!empty($inWidget->data)){
			shuffle($inWidget->data);
			$inWidget->data = array_slice($inWidget->data,0,$inWidget->view);
			echo '<div id="widgetData" class="data">';
			foreach ($inWidget->data as $key=>$item){
				switch ($inWidget->preview){
					case 'large':
						$thumbnail = $item->images->low_resolution->url;
						break;
					case 'fullsize':
						$thumbnail = $item->images->standard_resolution->url;
						break;
					default:
						$thumbnail = $item->images->thumbnail->url;
				}
				echo '<a href="'.$item->link.'" class="image" target="_blank"><img src="'.$thumbnail.'" /></a>';
			}
			echo '<div class="clear">&nbsp;</div>';
			echo '</div>';
		}
	?>
</div>
<div class='copy'>
	&copy; <a href='http://inwidget.ru' target='_blank' title='Бесплатный Instagram виджет для сайта'>inwidget.ru</a>
</div>
</body>
</html>
<!-- 
	Inwidget - small PHP script showing images from instagram.com in you site!
	http://inwidget.ru
	© Alexandr Kazarmshchikov
-->