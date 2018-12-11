<?php

use Model\Router;
use Model\Security;	

define ('DIR_MODEL', __DIR__.'/Model/');
define ('DIR_VIEW', __DIR__.'/View/');
include_once DIR_MODEL.'autoloader.php';

$ROUTER = new Router();
$ROUTER->handleRequest();
