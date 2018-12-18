<?php

namespace Framework;

use Framework\DbManager;
use Framework\Router;
use Model\UserManager;

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
			$this->user = UserManager::getUserById($_SESSION['id']);
	}

	private function connectDb()
	{
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;
	
		try {
			$this->pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}
}

?>
