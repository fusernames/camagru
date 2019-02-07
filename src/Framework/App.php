<?php

namespace Framework;

use Framework\Router;
use User\UserManager;

class App
{
	public $pdo;
	public $router;
	public $user = NULL;

	public function __construct()
	{
		$this->connectDb();
		$this->router = new Router();
	}

	public function getCurrentUser()
	{
		if (isset($_SESSION['id']))
		{
			$this->user = UserManager::getUserById($_SESSION['id']);
			if (!$this->user)
				unset($_SESSION['id']);
		}
	}

	private function connectDb()
	{
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;

		try {
			$this->pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		} catch (PDOException $e) {
			die('Échec lors de la connexion : ' . $e->getMessage());
		}
	}
}
