<?php

namespace Framework;

Class AlertManager
{
	static public function showAlerts()
	{
		if (!isset($_SESSION['alerts']))
			$_SESSION['alerts'] = array();
		$alerts = $_SESSION['alerts'];
		unset($_SESSION['alerts']);
		return $alerts;
	}

	static public function addAlert($type, $message)
	{
		if (!isset($_SESSION['alerts']))
			$_SESSION['alerts'] = array();
		$alert['type'] = $type;
		$alert['message'] = $message;
		array_push($_SESSION['alerts'], $alert);
		return 1;
	}

	static public function hasType($type)
	{
		return array_key_exists($type, $_SESSION['alerts']);
	}
}
