<?php

class Manager
{
	private $pdo;

	public function __construct()
	{
		$this->pdo = $APP->dbManager->getPdo();
	}
}

?>
