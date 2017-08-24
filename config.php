<?php

// ONLY FOR OPTIONS: LOGIN AND HASHTAG:
// IF CACHE FILE EXIST, DELETE IT OR WAIT "CACHE EXPIRATION TIME" TO APPLY CHANGES! 

$CONFIG = array(

	// Instagram login
	'LOGIN' => 'fotokto_ru',

	// Get pictures from WORLDWIDE by hashtags. 
	// Separate hashtags by comma. For example: girl, man
	// Use this options only if you want show pictures of other users. 
	// Profile avatar and statistic will be hidden.
	'HASHTAG' => '',

	// Specify here list of banned logins. 
	// Photos of these users will not be displayed in widget.
	// Separate usernames by comma. For example: mark18, kitty45
	'bannedLogins' => '',
		
	// Random order of pictures [ true / false ]
	'imgRandom' => true,

	// How many pictures widget will get from Instagram?
	'imgCount' => 30,

	// Cache expiration time (hours)
	'cacheExpiration' => 6,

	// Default language [ ru / en ] or something else from lang directory.
	'langDefault' => 'ru',

	// Language auto-detection [ true / false ]
	// This option may no effect if you set language by $_GET variable
	'langAuto' => false,

);