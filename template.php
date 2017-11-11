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
 * @copyright 2014-2017 Alexandr Kazarmshchikov
 * @author Alexandr Kazarmshchikov
 * @version 1.1.3
 * @package inWidget
 *
 */

if(!$inWidget) die('inWidget object was not initialised.');
if(!is_object($inWidget->data)) die('<b style="color:red;">Cache file contains plain text:</b><br />'.$inWidget->data);

?>
<!DOCTYPE html> 
<html lang="ru">
	<head>
		<title>inWidget - free Instagram widget for your site!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="<?php echo $inWidget->langName; ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="stylesheet" type="text/css" href="css/default.css?r1" media="all" />
		<style type='text/css'>
			.widget {
				width:<?php echo $inWidget->width; ?>px;
			}
			.widget .title .text {
				width: <?php echo ($inWidget->width-44); ?>px;
				<?php if($inWidget->width<160) echo 'display:none'; ?>
			}
			.widget .data a.image:link, .widget .data a.image:visited {
				width:<?php echo $inWidget->imgWidth; ?>px;
				height:<?php echo $inWidget->imgWidth; ?>px;
			}
			.widget .data .image span {
				width:<?php echo $inWidget->imgWidth; ?>px;
				height:<?php echo $inWidget->imgWidth; ?>px;
			}
			.copyright {
				width:<?php echo $inWidget->width; ?>px;
			}
		</style>
	</head>
<body>
<div id="widget" class="widget">
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
		$i = 0;
		$count = $inWidget->countAvailableImages($inWidget->data->images);
		if($count>0) {
			if($inWidget->config['imgRandom'] === true) shuffle($inWidget->data->images);
			echo '<div id="widgetData" class="data">';
				foreach ($inWidget->data->images as $key=>$item){
					if($inWidget->isBannedUserId($item->authorId) === true) continue;
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
					echo '<a href="'.$item->link.'" class="image" target="_blank"><span style="background-image:url('.$thumbnail.');">&nbsp;</span></a>';
					$i++;
					if($i >= $inWidget->view) break;
				}
				echo '<div class="clear">&nbsp;</div>';
			echo '</div>';
		}
		else {
			if(!empty($inWidget->config['HASHTAG'])) {
				$inWidget->lang['imgEmptyByHash'] = str_replace(
					'{$hashtag}', 
					$inWidget->config['HASHTAG'], 
					$inWidget->lang['imgEmptyByHash']
				);
				echo '<div class="empty">'.$inWidget->lang['imgEmptyByHash'].'</div>';
			}
			else echo '<div class="empty">'.$inWidget->lang['imgEmpty'].'</div>';
		}
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