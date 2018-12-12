<?php

session_start();
use Model\Security;	
use Framework\App;
use Framework\AlertManager;

define ('DIR_MODEL', __DIR__.'/Model/');
define ('DIR_VIEW', __DIR__.'/View/');

include_once 'Framework/autoloader.php';
include_once 'Config/database.php';

$APP = new App();
$APP->router->handleRequest();
