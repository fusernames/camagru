<?php

namespace Model;

use Controller\UserController;
use Controller\IndexController;

Class Router
{
	private $userController;
	private $indexController;

	public function __construct()
	{
		$userController = new UserController;
		$indexController = new indexController;
	}
	
	private function getParam($key, $default = 0)
	{
		$id = $default;
		if (isset($_GET[$key]))
			$id = $_GET[$key];
		return ($id);
	}

	public function redirectToUrl($route)
	{
		header('Location : index.php?action='.$route);
	}

	public function handleRequest()
	{
		if (isset($_GET['action'])) {
			$this->findRoute();
		} else {
			$this->findRoute('index');
		}
	}

	private function findRoute($route = NULL)
	{
		if (!$route)
			$route = $_GET['action'];
		switch ($route) {
			case '':
				$this->indexController->index();
				break;
			case 'index':
				$this->indexController->index();
				break;
			case 'login':
				$this->userController->login();
				break;
			case 'register':
				$this->userController->register();
				break;
			case 'user_edit':
				$this->userController->edit($this->getParam('id'));
				break;
			case 'user_remove':
				$this->userController->remove($this->getParam('id'));
				break;
		}
	}
}
