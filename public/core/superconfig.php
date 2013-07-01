<?php
// Site Variables
$SITE['fileext']				=	'';

// The subfolder YEYD is placed in relative to the web root
// Should always start and and with a "/" (without the quotes of course ...)
$SITE['location']				=	'/';

// DB Config
// Oh and by the way, this is my local DB setup so you probably wanna change this ;)
$DB['host']						=	'127.0.0.1';
$DB['port']						=	3306; // 3306 is the default MySQL port
$DB['name']						=	'php-site';
$DB['user']						=	'php-site';
$DB['pass']						=	'VeryInsecure...';

////////////////////////////////////////////////
// End of variables you need to care about ;) //
////////////////////////////////////////////////

// Default page vars
$PAGE['title']					=	'page';
$PAGE['stylesheets']			=	array('/css/bootstrap.min.css','/css/bootstrap-responsive.min.css','/css/icons.css','/css/font-awesome.min.css', '/css/contextmenu.css');
$PAGE['scripts']				=	array('/js/jquery.js','/js/bootstrap.min.js','/js/contextmenu.js','/js/primary.js');

// Selfsetting-variables or something like that ... :D
$domain							=	'//' . $_SERVER['HTTP_HOST'] . $SITE['location'];

// Project
// DO NOT CHANGE!!!
$PROJECT['title']				=	'YEYD';
$PROJECT['version']				=	'0.02';
$PROJECT['mainauthor']			=	'erty5000';
$PROJECT['mainauthor_web']		=	'https://github.com/erty5000/';
$PROJECT['web']					=	'https://github.com/DiamondCentralX/yeyd';
?>