<?php

// THIS SCRIPT USE CACHE TO REDUCE HIGH LOAD. 
// SO IF THE CACHED FILE ALREADY EXIST - DELETE IT TO APPLY CHANGES!

$CONFIG = array(

	// Instagram login
	'LOGIN' => 'fotokto_ru',

	// Get pictures from around the world by hashtags. 
	// Separate hashtags by a comma. For example: girl, man
	'HASHTAG' => '',
		
	// ACCESS TOKEN granted to you by an Instagram app.
	// This option is NOT required. If you use it, the widget will start
	// sending requests through the official API
	'ACCESS_TOKEN' => '',
		
	// Login and password for authorization. This options are NOT required.
	// Authorization is necessary for alternative methods of obtaining data 
	// and provides more stability when you using the undocumented API
	'authLogin' => '',
	'authPassword' => '',
		
	// Specify here list of banned logins. 
	// Photos of these users will not be display in the widget.
	// Separate usernames by a comma. For example: mark18, kitty45
	'tagsBannedLogins' => '',
		
	// Search tagged media from your account only [ true / false ]
	// To improve search, increase value of the "imgCount" option
	'tagsFromAccountOnly' => false,
		
	// Random order of pictures [ true / false ]
	'imgRandom' => true,

	// How many pictures the widget will get from Instagram?
	'imgCount' => 30,
		
	// Cache expiration time (hours)
	'cacheExpiration' => 6,
		
	// Skip cache data [ true / false ]
	// So mean, requests to Instagram API will be sending every time. 
	// Warning! Use true value only for debug
	'cacheSkip' => false,
		
	// Full path to the cache directory
	'cachePath' => __DIR__.'/cache/',
		
	// Default skin. 
	// Possible values: default, modern-blue, modern-green, modern-red, modern-orange, modern-grey, modern-black, modern-violet, modern-yellow
	// This option may no effect if you set a skin by $_GET variable
	'skinDefault' => 'default',
		
	// Path to the skins directory
	'skinPath' => 'skins/',
		
	// Default language [ ru / en / ua ] or something else from the lang directory.
	// This option may no effect if you set a lang by $_GET variable
	'langDefault' => 'ru',
		
	// Full path to the langs directory
	'langPath' => __DIR__.'/langs/',

	// Language auto-detection [ true / false ]
	// This option may no effect if you set a language by $_GET variable.
	'langAuto' => false,

);