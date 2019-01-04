<?php

namespace Framework;

use Model\Security;

abstract Class AbstractController
{
	public function render($view, array $params = array())
	{
		global $APP;
		$alerts = AlertManager::showAlerts();
		extract($params);
		require(DIR_VIEW.$view);
	}

	public function redirectToUrl($action)
	{
		header('Location: index.php?action='.$action);
	}

	public function redirectBack()
	{
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
}
