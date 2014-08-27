<?php 
/**
 * Project:     inWidget: show pictures from instagram.com on your site!
 * File:        template.php
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

if(!$inWidget) die('inWidget object is not init.');
if(!is_object($inWidget->data)) die('<b style="color:red;">Cache file contains plain text:</b><br />'.$inWidget->data);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>inWidget - free Instagram widget for your site!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?php echo $inWidget->langName; ?>" />
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
				background:#46729b url(data:image/gif;base64,R0lGODlhAQAhAMQAAFR/p0hznVN+plB8pFJ8pVN+p0dynFB7pEp2n096o0x3n0x3oFN9pUl1nkp2nlJ9pkZxm0x4oFB8o0h0nUt3n056ok14oUZym1F8pU55oU97o055ok96ogAAAAAAAAAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxNC0wMS0yOFQyMDowMDo1NyswNzowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTQtMDEtMjhUMjA6MDE6MTErMDc6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTQtMDEtMjhUMjA6MDE6MTErMDc6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvZ2lmIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjQzMjhFRkNGODgxQzExRTM5OUQ4OURBQTU4OUI5QjJFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjQzMjhFRkQwODgxQzExRTM5OUQ4OURBQTU4OUI5QjJFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NDMxMjBDMjI4ODFDMTFFMzk5RDg5REFBNTg5QjlCMkUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NDMxMjBDMjM4ODFDMTFFMzk5RDg5REFBNTg5QjlCMkUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQAAAAAACwAAAAAAQAhAAAFGiAgFoLAPAQ2HJKWcNWWWdGiUIjTTEFgXJAQADs=) repeat-x;
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
				<?php if($inWidget->width<160) echo 'display:none'; ?>
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
			.widget a.follow:link, .widget a.follow:visited {
				display:block;
				background:#ad4141;
				text-decoration:none;
				font-size:14px;
				color:#FFF;
				font-weight:bold;
				width:120px;
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
			.widget .empty {
				text-align:center;
				margin:10px 0 10px 0;
			}
			.copyright {
				width:<?php echo $inWidget->width; ?>px;
				margin:3px 0 0 0;
				font-size:10px;
				text-align:center;
			}
			.copyright a:link, .copyright a:visited {
				text-decoration:none;
				color:#666;
			}
			.copyright a:hover {
				text-decoration:underline;
			}
		</style>
	</head>
<body>
<div class="widget">
	<a href="http://instagram.com/<?php echo $inWidget->data->username; ?>" target="_blank" class="title">
		<img 
			src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA+dpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTQtMDEtMjhUMjA6MDA6NTcrMDc6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDE0LTAxLTI4VDIwOjAxOjEyKzA3OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE0LTAxLTI4VDIwOjAxOjEyKzA3OjAwIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0MzQ2MTUyRDg4MUMxMUUzOTlEODlEQUE1ODlCOUIyRSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0MzQ2MTUyRTg4MUMxMUUzOTlEODlEQUE1ODlCOUIyRSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjpp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" 
			class="icon" />
		<div class="text"><?php echo $inWidget->lang['title']; ?></div>
		<div class="clear">&nbsp;</div>
	</a>
	<?php
		if($inWidget->toolbar == true) { 
			echo '
			<table class="profile">
				<tr>
					<td rowspan="2" class="avatar">
						<a href="http://instagram.com/'.$inWidget->data->username.'" target="_blank"><img src="'.$inWidget->data->avatar.'"></a>
					</td>
					<td class="value">
						'.$inWidget->data->posts.'
						<span>'.$inWidget->lang['statPosts'].'</span>
					</td>
					<td class="value">
						'.$inWidget->data->followers.'
						<span>'.$inWidget->lang['statFollowers'].'</span>
					</td>
					<td class="value" style="border-right:none !important;">
						'.$inWidget->data->following.'
						<span>'.$inWidget->lang['statFollowing'].'</span>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="border-right:none !important;">
						<a href="http://instagram.com/'.$inWidget->data->username.'" class="follow" target="_blank">'.$inWidget->lang['buttonFollow'].' &#9658;</a>
					</td>
				</tr>
			</table>';
		}
		if(!empty($inWidget->data->images)){
			if($inWidget->config['imgRandom'] === true) shuffle($inWidget->data->images);
			$inWidget->data->images = array_slice($inWidget->data->images,0,$inWidget->view);
			echo '<div id="widgetData" class="data">';
			foreach ($inWidget->data->images as $key=>$item){
				switch ($inWidget->preview){
					case 'large':
						$thumbnail = $item->large;
						break;
					case 'fullsize':
						$thumbnail = $item->fullsize;
						break;
					default:
						$thumbnail = $item->small;
				}
				echo '<a href="'.$item->link.'" class="image" target="_blank"><img src="'.$thumbnail.'" alt="" /></a>';
			}
			echo '<div class="clear">&nbsp;</div>';
			echo '</div>';
		}
		else echo '<div class="empty">'.$inWidget->lang['imgEmpty'].'</div>';
	?>
</div>
<div class='copyright'>
	&copy; <a href='http://inwidget.ru' target='_blank' title='Free Instagram widget for your site!'>inwidget.ru</a>
</div>
</body>
</html>
<!-- 
	inWidget - free Instagram widget for your site!
	http://inwidget.ru
	© Alexandr Kazarmshchikov
-->