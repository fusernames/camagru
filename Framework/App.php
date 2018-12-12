<?php

namespace Framework;

use Framework\DbManager;
use Framework\Router;

class App
{
	public $dbManager;
	public $router;
	public $user = NULL;

	public function __construct()
	{
		$this->router = new Router();
		if (isset($_SESSION['id']))
			$this->user = Database::getObject('User', 'SELECT * FROM users WHERE id = '.$_SESSION['id']);
	}
}

?>
