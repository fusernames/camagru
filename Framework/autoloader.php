<?php

spl_autoload_register(function($className) {
	$className = str_replace('\\', '/', $className);
	$className = $className.'.php';
	require_once DIR_APP.$className;
});
