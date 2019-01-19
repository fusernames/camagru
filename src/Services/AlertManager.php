<?php

namespace Services;

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
		if ($type == 'danger')
			return 1;
		else if ($type == 'success')
			return 0;
	}
}
