<?php

use Framework\App;

session_start();
if (!isset($_SESSION['token']))
	$_SESSION['token'] = hash('whirlpool', srand(50000, 200000));

define ('DIR_MODEL', __DIR__.'/Model/');
define ('DIR_VIEW', __DIR__.'/View/');
define ('DIR_PUBLIC', __DIR__.'/Public/');
define ('DIR_APP', __DIR__.'/');

include_once 'Framework/autoloader.php';
include_once 'Config/database.php';

$APP = new App();
include_once 'Config/setup.php';

$APP->getCurrentUser();
$APP->router->handleRequest();
