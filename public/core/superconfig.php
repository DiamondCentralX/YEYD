<?php
// YEYD - SUPERconfig
// Last updated: 30.06.2013

// Site Variables
$SITE['title']					=	'YEY:D';
$SITE['desc']					=	'Welcome to YEYD!';
$SITE['keywords']				=	'php, html5, css3, awesome';
$SITE['author']					=	'erty5000';

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

$SITE['fileext']				=	'';

// Default page vars
$PAGE['title']					=	'page';
$PAGE['stylesheets']			=	array('/css/bootstrap.min.css','/css/bootstrap-responsive.min.css','/css/icons.css','/css/font-awesome.min.css');
$PAGE['scripts']				=	array('/js/jquery.js','/js/primary.js','/js/bootstrap.min.js');

// Selfsetting-variables or something like that ... :D
$domain							=	'//' . $_SERVER['HTTP_HOST'];

// Project
// DO NOT CHANGE!!!
$PROJECT['title']				=	'YEYD';
$PROJECT['version']				=	'0.01.2';
$PROJECT['mainauthor']			=	'erty5000';
$PROJECT['mainauthor_web']		=	'https://github.com/erty5000/';
$PROJECT['web']					=	'https://github.com/DiamondCentralX/yeyd';
?>