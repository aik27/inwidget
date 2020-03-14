<?php

// THIS SCRIPT USE CACHE TO REDUCE HIGH LOAD. 
// SO IF THE CACHED FILE ALREADY EXIST - DELETE IT TO APPLY CHANGES!

$CONFIG = array(

	// -------------------------------------------------------------
	// Main settings
	// -------------------------------------------------------------
		
	// Primary Instagram login
	'LOGIN' => 'fotokto_ru',
		
	// Primary hashtags
	// Separate hashtags by a comma. For example: girl, man
	'HASHTAG' => '',

	// -------------------------------------------------------------
	// Authorization (NOT required)
	// -------------------------------------------------------------
		
	// Access token granted to your primary account by an Instagram app.
	// If you use it, the widget will start sending requests through the official API (https://www.instagram.com/developer/)
	'ACCESS_TOKEN' => '',
		
	// Login and password of an Instagram account for authorization. 
	// Authorization is necessary for alternative methods of obtaining data and provides more stability when you using the undocumented API
	'authLogin' => '',
	'authPassword' => '',

	// -------------------------------------------------------------
	// Multi-account configuration
	// -------------------------------------------------------------
		
	// If you need to separete logins on diffent website pages, just add possible logins to the array below.
	// After that you can send login to the widget by GET variable. It workds only with the undocumented API.
	// Example: /inwidget/index.php?login=fotokto_ru
	'loginAvailable' => [
		#'fotokto_ru',
		#'instagram',
	],
	// Same option for tagged media. Add possible tags to the array below. 
	// Then you can use GET variable for tags. Example: /inwidget/index.php?tag=photography
	// You can mix this option with "loginAvailable" and "tagsFromAccountOnly"
	'tagsAvailable' => [
		#'girl',
		#'photography',
	],
		
	// -------------------------------------------------------------
	// Tags
	// -------------------------------------------------------------

	// Specify here list of banned logins. 
	// Photos of these users will not be display in the widget.
	// Separate usernames by a comma. For example: mark18, kitty45
	'tagsBannedLogins' => '',
		
	// Search tagged media from your account only [ true / false ]
	// To improve search, increase value of the "imgCount" option
	'tagsFromAccountOnly' => false,

	// -------------------------------------------------------------
	// Images
	// -------------------------------------------------------------
		
	// Random order of pictures [ true / false ]
	'imgRandom' => true,

	// How many pictures the widget will get from Instagram?
	'imgCount' => 30,
		
	// -------------------------------------------------------------
	// Cache
	// -------------------------------------------------------------
		
	// Cache expiration time (hours)
	'cacheExpiration' => 6,
		
	// Skip cache data [ true / false ]
	// So mean, requests to Instagram API will be sending every time. 
	// Warning! Use true value only for debug
	'cacheSkip' => false,
		
	// Full path to the cache directory
	'cachePath' => __DIR__.'/cache/',
		
	// -------------------------------------------------------------
	// Skin
	// -------------------------------------------------------------
	
	// Default skin. 
	// Possible values: default, modern-blue, modern-green, modern-red, modern-orange, modern-grey, modern-black, modern-violet, modern-yellow
	// This option may no effect if you set a skin by $_GET variable
	'skinDefault' => 'default',
	
	// Possible skin values.
	// If you are using a custom skin, add the skin filename in this array without extension. 
	'skinAvailable' => ['default', 'modern-blue', 'modern-green', 'modern-red', 'modern-orange', 'modern-grey', 'modern-black', 'modern-violet', 'modern-yellow'],
		
	// Path to the skins directory
	'skinPath' => 'skins/',
		
	// -------------------------------------------------------------
	// Lang
	// -------------------------------------------------------------
		
	// Default language [ ru / en / ua ] or something else from the lang directory.
	// This option may no effect if you set a lang by $_GET variable
	'langDefault' => 'ru',
		
	// Possible language values.
	// If you are using another language, add the lang filename in this array without extension. 
	'langAvailable' => ['ru','en','ua'],
		
	// Full path to the langs directory
	'langPath' => __DIR__.'/langs/',

	// Language auto-detection [ true / false ]
	// This option may no effect if you set a language by $_GET variable.
	'langAuto' => false,

);