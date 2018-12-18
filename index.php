<?php

session_start();
use Model\Security;	
use Framework\App;
use Framework\AlertManager;

define ('DIR_MODEL', __DIR__.'/Model/');
define ('DIR_VIEW', __DIR__.'/View/');
define ('DIR_APP', __DIR__.'/');

include_once 'Framework/autoloader.php';
include_once 'Config/database.php';

$APP = new App();
include_once 'Config/install.php';

$APP->getCurrentUser();
$APP->router->handleRequest();
