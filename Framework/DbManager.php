<?php

class dbManager
{
	private $pdo;

	public function __construct()
	{
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;

		try {
			$this->pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo 'Échec lors de la connexion : ' . $e->getMessage();
		}
	}

	public function execute($request)
	{

	}
}
