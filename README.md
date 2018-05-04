# inWidget - free Instagram widget for your website

This library is based on PHP and allows you to show photos from your Instagram account on your website.

[Demonstration >>](http://inwidget.ru/en/demo.php)

![demo](http://inwidget.ru/i/demo_en_2.jpg)

### Features:

+ Many settings
+ Direct links to photos
+ Profile stats
+ Adaptive, responsive template
+ Support of several hashtags
+ Language auto detection
+ Works without ACCESS_TOKEN
+ Inserting with one line in HTML
+ Many skins
+ Without advertising
+ For any use
+ Detailed instructions

## System requirements

PHP >= 5.4.0 with cURL extension

## Installation

### 1. Upload source code to the root folder of your website

[Download](https://github.com/aik27/inwidget/releases) source code. Extract /inwidget folder.
Upload /inwidget folder to website with all files inside.

Or use composer

```sh
composer.phar require aik27/inwidget
```

```sh
composer require aik27/inwidget
```

**Note**. inWidget using relative paths, so you can upload it to any folder. After that do not forget change URL in IFRAME tag.

### 2. Set write permissions to the folder: /inwidget/cache

inWidget will store cached data in /inwidget/cache folder.
If this directory does not have write permissions you will see ERROR #101.

### 3. Configuration

Modify /inwidget/config.php
You will need to specify Instagram login and other params

List of parameters:

+ **LOGIN** - Instagram login
+ **HASHTAG** - hashtags separated by a comma (for example: girl, man). Selection will be made from around the world in the order that photos were marked with desired tags
+ **ACCESS_TOKEN** - a hashkey granted to you by an Instagram app. This option is NOT required. If you use it, the widget will start sending requests through the official endpoints API (https://www.instagram.com/developer/). In this case, the widget will have only those rights and limits that the application itself possesses. For more information about, please, use this link: http://inwidget.ru/#token
+ **authLogin and authPassword** - login and password of an account for authorization. This options are NOT required. Authorization is necessary for alternative methods of obtaining data and provides more stability when you using the undocumented API. I advise you to create a separate account for this with disabled two-step authentication. Authorization data is not transferred to third parties and author of the widget
+ **tagsBannedLogins** - Specify here list of banned logins. Photos of these users will not be display in the widget. Separate usernames by a comma. For example: mark18, kitty45
+ **tagsFromAccountOnly** - Search tagged media from your account only [ true / false ]. To improve search increase value of "imgCount" option
+ **imgRandom** - Random order of pictures [ true / false ]
+ **imgCount** - How many pictures the widget will get from Instagram?
+ **cacheExpiration** - Cache expiration time (hours)
+ **cacheSkip** - Skip cache data [ true / false ]. So mean, requests to Instagram API will be sending every time. Warning! Use true value only for debug
+ **cachePath** - Full path to the cache directory
+ **skinDefault** -  Default skin. Possible values: *default, modern-blue, modern-green, modern-red, modern-orange, modern-grey, modern-black, modern-violet, modern-yellow*. This option may no effect if you set a skin by $_GET variable
+ **skinPath** - Path to the skins directory
+ **langDefault** - Default language [ ru / en / ua ] or something else from the langs directory
+ **langPath** - Full path to the langs directory
+ **langAuto** - Language auto-detection [ true / false ]. This option may no effect if you set a language by $_GET variable

### 4. Paste this code into your html template

```
<!-- default -->
<iframe src='/inwidget/index.php' scrolling='no' frameborder='no' style='border:none;width:260px;height:330px;overflow:hidden;'></iframe> 
```

Or use another examples with different display type:

```
<!-- Without profile -->
<iframe src='/inwidget/index.php?toolbar=false' data-inwidget scrolling='no' frameborder='no' style='border:none;width:260px;height:320px;overflow:hidden;'></iframe>

<!-- Mini 1 -->
<iframe src='/inwidget/index.php?width=100&inline=2&view=12&toolbar=false' data-inwidget scrolling='no' frameborder='no' style='border:none;width:100px;height:320px;overflow:hidden;'></iframe>

<!-- Mini 2 -->
<iframe src='/inwidget/index.php?width=100&inline=1&view=3&toolbar=false' data-inwidget scrolling='no' frameborder='no' style='border:none;width:100px;height:320px;overflow:hidden;'></iframe>

<!-- Horizontal orientation -->
<iframe src='/inwidget/index.php?width=800&inline=7&view=14&toolbar=false' data-inwidget scrolling='no' frameborder='no' style='border:none;width:800px;height:295px;overflow:hidden;'></iframe>

<!-- Large previews -->
<iframe src='/inwidget/index.php?width=800&inline=3&view=9&toolbar=false&preview=large' data-inwidget scrolling='no' frameborder='no' style='border:none;width:800px;height:850px;overflow:hidden;'></iframe> 
```

## Fine-tune widget display

Parameters are passed as GET variables when accessing to the widget script. For that you must change the URL in IFRAME tag. For example, to set the widget width to 600px and display five photos per a single row, you need to add appropriate parameters in the URL.

```
/inwidget/index.php?width=600&inline=5
```

List of parameters:

+ **width** -  the widget width (default: 260px)
+ **inline** - number of photos per line (default: 4 pcs.)
+ **view** - how many photos can be displayed in the widget (default: 12 pcs, max.: 30 pcs, you can change it in config.php)
+ **toolbar** - display toolbar with avatar and statistics ( true / false, default: true)
+ **preview** - size and quality of images (small - 320px, large - 640px, fullsize - maximum avalible size, default: large)
+ **lang** - the widget language (ru / en / ua, default settings are taken from config.php ). Priority of this parameter is higher than for settings in config.php
+ **skin** - the widget skin (default / modern-blue / modern-green / modern-red / modern-orange / modern-gray / modern-black / modern-violet / modern-yellow). Default value: default. Priority of this parameter is higher than for settings in config.php
+ **adaptive** - adaptive, responsive mode (true / false, by default: false). Widget will automatically adjust to dimensions of html container or browser window

When you changing width or number of photos, do not forget to change IFRAME tag size.


## How to make the widget adaptive / responsive? [(example)](http://inwidget.ru/adaptive.php)

Add GET variable "adaptive" in the URL of IFRAME tag.
 
```
/inwidget/index.php?adaptive=true
```

The value must be set to true. After that, the widget will automatically adjust to the dimensions of html container or browser window. In this case, the GET parameter "width" will be ignored, the "inline" parameter will have an effect when the widget width of more than 400px.

Please, see demonstration of adaptive mode: http://inwidget.ru/adaptive.php

## Video instruction how to get ACCESS TOKEN

https://www.youtube.com/watch?v=_O669Dx3djw

The URL to generate ACCESS TOKEN:

```
https://www.instagram.com/oauth/authorize/?client_id=YOUR_CLIENT_ID&redirect_uri=YOUR_REDIRECT_URI&response_type=token&scope=basic
```

The widget can work with two kinds of API (undocumented and endpoints). Default API is undocumented. Access token is not required for it. Specifying ACCESS TOKEN in the widget's settings takes it to Endpoints API mode (https://www.instagram.com/developer/). If you want to create your own application in Instagram, then use video instruction above. Keep in mind that your application will first get into "sandbox" with following limits:

+ **20** - maximum number of photos that can be obtained per one request.
+ **500** - maximum number of requests per hour.
+ ***And most importantly*** - photos can be obtained from your account only. Same goes for selection by tags.

**Keep in mind that Instagram has announced the end of support for endpoint API by 2020**.
More information: https://developers.facebook.com/blog/post/2018/01/30/instagram-graph-api-updates/

## For developers

You can include inWidget library in your application and set parameters through the class constructor. Be careful with the file paths when using example below. The classes support autoloading.

By default the widget use undocumented API that provided by [instagram-php-scraper](https://github.com/postaddictme/instagram-php-scraper) library. To switch to the endpoint API, you need to specify ACCESS_TOKEN.

```php
#require_once 'inwidget/classes/Autoload.php';
require_once 'inwidget/classes/InstagramScraper.php';
require_once 'inwidget/classes/Unirest.php';
require_once 'inwidget/classes/InWidget.php';

try {
	
    // Options may change through the class constructor. For example:
    
    $config = array(
       'LOGIN' => 'fotokto_ru',
       'HASHTAG' => '',
       'ACCESS_TOKEN' => '',
       'authLogin' => '',
       'authPassword' => '',
       'tagsBannedLogins' => '',
       'tagsFromAccountOnly' => false,
       'imgRandom' => true,
       'imgCount' => 30,
       'cacheExpiration' => 6,
       'cacheSkip' => false,
       'cachePath' =>  $_SERVER['DOCUMENT_ROOT'].'/inwidget/cache/',
       'skinDefault' => 'default',
       'skinPath'=> '/inwidget/skins/',
       'langDefault' => 'ru',
       'langAuto' => false,
       'langPath' => $_SERVER['DOCUMENT_ROOT'].'/inwidget/langs/',
    );
    
    $inWidget = new \inWidget\Core($config);
	
    // Also, you may change default values of properties

    /*
    $inWidget->width = 800;         // widget width in pixels
    $inWidget->inline = 6;          // number of images in single line
    $inWidget->view = 18;	           // number of images in widget
    $inWidget->toolbar = false;     // show profile avatar, statistic and action button
    $inWidget->preview = 'large';   // quality of images: small, large, fullsize
    $inWidget->adaptive = false;    // enable adaptive mode
    $inWidget->skipGET = true;      // skip GET variables to avoid name conflicts
    $inWidget->setOptions();        // apply new values
    */
	
    $inWidget->getData();
    include 'inwidget/template.php';

}
catch (\Exception $e) {
    echo $e->getMessage();
}
```

## Error codes

**ERROR #101** - can not access to the cached file. You need to change permissions for directory: /inwidget/cache 

If cached file does not exist, the widget will try to create it. Then the widget will try to open it for reading and writing. Incorrect rights provide this error. If you already had some files in the cache directory, just delete them, because they also may has incorrect rights.

**ERROR #102** - can not get the last modification time of the cached file.

Perhaps, this function is limited or not supported by your server's file system. If the widget can not determine the time, cache will always be irrelevant, which will result in permanent requests to Instagram API.

**ERROR #500** - unknown error

Please, see what exactly was written into the cached file. This error is generated by the official API or instagram-php-scraper library. In most cases, it means a problem when sending or receiving data from Instagram server. Delete the cached file and refresh a page (on which the widget is displayed) to try send request again.

## Feedback, questions and suggestions

Visit website: http://inwidget.ru
Write to: aik@inwidget.ru 
Join to development on GitHub: https://github.com/aik27/inwidget
Article about inWidget on Habrahabr: http://habrahabr.ru/post/223739/

## Donate

inWidget is a non-profit library that exists on bare enthusiasm. Your support are welcome!

PayPal: aik@inwidget.ru

Thank you!

## Copyrights

Author: Alexandr Kazarmshchikov
E-mail: aik@inwidget.ru
Site: http://inwidget.ru

## License

This library is free software; you can redistribute it and/or modify it under the terms of MIT license: http://inwidget.ru/MIT-license.txt