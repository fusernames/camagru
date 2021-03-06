<?php

use Framework\App;

session_start();
if (!isset($_SESSION['token']))
	$_SESSION['token'] = hash('whirlpool', srand(50000, 200000));

define ('DIR_APP', __DIR__.'/');
define ('DIR_SRC', __DIR__.'/src/');
define ('DIR_VIEW', __DIR__.'/templates/');
define ('DIR_PUBLIC', __DIR__.'/public/');
define ('DIR_PIC', DIR_PUBLIC.'pictures/');
define ('DIR_TMP', DIR_PUBLIC.'tmp/');
define ('DIR_JS', DIR_PUBLIC.'js/');
define ('APP_NAME', basename(__DIR__));

include_once 'config/autoloader.php';
include_once 'config/database.php';

$APP = new App();
if (isset($_GET['action']) && $_GET['action'] == 'setup')
{
	include_once 'config/setup.php';
	die();
}
$APP->getCurrentUser();
$APP->router->handleRequest();
