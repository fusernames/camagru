<?php

namespace Framework;

use Controller\UserController;
use Controller\IndexController;

Class Router
{
	private $userController;
	private $indexController;

	public function __construct()
	{
		$this->userController = new UserController();
		$this->indexController = new IndexController();
	}

	public static function redirectToUrl($action)
	{
		header('Location: index.php?action='.$action);
	}

	private function getParam($key, $default = 0)
	{
		$id = $default;
		if (isset($_GET[$key]))
			$id = $_GET[$key];
		return ($id);
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
			case 'index':
				$this->indexController->index();
				break;
			case 'login':
				$this->userController->login();
				break;
			case 'logout':
				$this->userController->logout();
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
			case 'user_activate':
				$this->userController->activate();
				break;
		}
	}
}
