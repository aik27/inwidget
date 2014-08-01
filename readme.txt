/**
 * Project:     Inwidget: A PHP class showing images from Instagram.com
 * File:        readme.txt
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of MIT license
 * http://inwidget.ru/MIT-license.txt
 *
 * @link http://inwidget.ru
 * @author Alexandr Kazarmshchikov
 * @version 1.0 (January 2014)
 *
 */

// ----------------------------------------
// Установка виджета на сайт:
// ----------------------------------------

1. Зарегистрируйте ваш сайт в instagram.com:

Для этого идём на instagram.com и аторизируемся под своим аккаунтом. Далее переходим в раздел API.
Вот прямая ссылка: http://instagram.com/developer/. Вас интересует раздел «Управлять программами». 
В нём вам требуется зарегистрировать новое приложение (ваш сайт), от лица которого и будет работать виджет. 
Так что переходим в этот раздел. Нажимаем кнопку «Регистрация новой программы» и заполняем форму:

* Application Name – название вашего приложения. Можете написать название сайта;
* Description – описание приложения;
* Website – URL-адрес вашего сайта;
* OAuth redirect_uri – URL на который перейдёт пользователь после авторизации.

Т.к. у вас просто виджет и никого авторизовывать вы не будете, можно просто продублировать адрес сайта.

Дальше нажимаем кнопку «Register». После регистрации вы получаете два хэш-ключа. 
Вас интересует CLIENT ID. Он потребуется для настройки виджета.

2. Создайте таблицу в БД MySQL:

База данных нужна для кэширования данных виджета, т.к. Instagram разрешает отправлять лишь 5000 запрос в час к своему API. 

CREATE TABLE IF NOT EXISTS `inwidget` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`userid` bigint(11) NOT NULL DEFAULT '0',
`username` varchar(255) NOT NULL,
`avatar` varchar(255) NOT NULL,
`posts` int(11) NOT NULL DEFAULT '0',
`followers` int(11) NOT NULL DEFAULT '0',
`following` int(11) NOT NULL DEFAULT '0',
`data` longtext NOT NULL,
`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

3. Загрузите исходный код виджета в корень вашего сайта:

Для этого скачайте архив с исходным кодом виджета. Извлеките папку /inwidget из архива. 
Загрузите папку /inwidget в корень вашего сайта со всеми файлами внутри.

4. Настройте виджет:

Отредактируйте файл /inwidget/config.php
Вам потребуется указать логин в Instgram, CLIENT_ID вашего приложения и параметры соединения с базой данных.

5. Вставьте виджет в сайт с помощью следующего кода:

<!-- По умолчанию -->
<iframe src='/inwidget/index.php' scrolling='no' frameborder='no' style='border:none;width:260px;height:330px;overflow:hidden;'></iframe> 

Ещё примеры вставки с различным отображением виджета: 

<!-- Без профиля -->
<iframe src='/inwidget/index.php?toolbar=false' scrolling='no' frameborder='no' style='border:none;width:260px;height:320px;overflow:hidden;'></iframe>

<!-- Мини 1 -->
<iframe src='/inwidget/index.php?width=100&inline=2&view=12&toolbar=false' scrolling='no' frameborder='no' style='border:none;width:100px;height:320px;overflow:hidden;'></iframe>

<!-- Мини 2 -->
<iframe src='/inwidget/index.php?width=100&inline=1&view=3&toolbar=false' scrolling='no' frameborder='no' style='border:none;width:100px;height:320px;overflow:hidden;'></iframe>

<!-- Горизонтальная ориентация -->
<iframe src='/inwidget/index.php?width=800&inline=7&view=14&toolbar=false' scrolling='no' frameborder='no' style='border:none;width:800px;height:295px;overflow:hidden;'></iframe>

<!-- Крупные preview -->
<iframe src='/inwidget/index.php?width=800&inline=3&view=9&toolbar=false&preview=large' scrolling='no' frameborder='no' style='border:none;width:800px;height:850px;overflow:hidden;'></iframe> 

// ----------------------------------------
// Точная настройка отображения виджета:
// ----------------------------------------

Параметры передаются как GET переменные при обращении к скрипту виджета.
К примеру, чтобы уставить ширину виджета 600px и вывести в строку пять фотографий, нужно добавить соотвествующие параметры в URL к скрипту. Т.е.: /inwidget/index.php?width=600&inline=5 

Список параметров:

width – ширина виджета (по умолчанию 260px);
inline – количество фотографий в строке (по умолчанию 4 шт.);
view – сколько фотографий отображать в виджете (по умолчанию 12 шт., максимально 30 шт., можно исправить в config.php);
toolbar – отобразить тулбар с аватаркой и статистикой (значения true/false, по умолчанию true);
preview – размер и качество изображений (small – маленькие до 150px, large – большие до 306px, fullsize – полноразмерые до 640px, по умолчанию стоит small)

При изменении ширины или количества фотографий не забудьте изменить размер iframe. 