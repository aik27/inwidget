<?php

// THIS SCRIPT USE CACHE TO REDUCE HIGH LOAD. SO IF CACHE FILE EXIST -
// DELETE IT, WAIT "CACHE EXPIRATION TIME" OR USE "cacheSkip" OPTION TO APPLY CHANGES!

$CONFIG = array(

	// Instagram login
	'LOGIN' => 'fotokto_ru',

	// Get pictures from WORLDWIDE by hashtags. 
	// Separate hashtags by comma. For example: girl, man
	// Profile avatar and statistic will be hidden.
	// May combined with "tagsFromAccountOnly" option.
	'HASHTAG' => '',
		
	// ACCESS TOKEN granted to you by some Instagram app.
	// This option is optional. If you use it, widget will start 
	// sending requests through the official API
	'ACCESS_TOKEN' => '',
		
	// Specify here list of banned logins. 
	// Photos of these users will not be display in widget.
	// Separate usernames by comma. For example: mark18, kitty45
	'tagsBannedLogins' => '',
		
	// Search tagged media from user account only [ true / false ]
	// To improve search, increase value of "imgCount" option
	'tagsFromAccountOnly' => false,
		
	// Random order of pictures [ true / false ]
	'imgRandom' => true,

	// How many pictures widget will get from Instagram?
	'imgCount' => 30,
		
	// Cache expiration time (hours)
	'cacheExpiration' => 6,
		
	// Skip cache data [ true / false ]
	// Requests to Instagram API will be sending every time.
	// Warning! Use true option only for debug.
	'cacheSkip' => false,
		
	// Full path to cache directory
	'cachePath' => __DIR__.'/cache/',
		
	/* Default skin. 
	 * Possible values: default, modern-blue, modern-green, modern-red, modern-orange, modern-grey, modern-black, modern-violet, modern-yellow
	 * This option may no effect if you set skin by $_GET variable */
	'skinDefault' => 'default',
		
	// Path to skin directory
	'skinPath' => 'skins/',
		
	// Default language [ ru / en / ua ] or something else from lang directory.
	'langDefault' => 'ru',
		
	// Full path to langs directory
	'langPath' => __DIR__.'/langs/',

	// Language auto-detection [ true / false ]
	// This option may no effect if you set language by $_GET variable.
	'langAuto' => false,

);