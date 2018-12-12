<?php

spl_autoload_register(function($className) {
	$className = str_replace('\\', '/', $className);
	$className = strtolower($className.'.php');
	require_once $className;
});
