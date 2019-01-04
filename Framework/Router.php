<?php

namespace Framework;

use Controller\UserController;
use Controller\IndexController;
use Controller\PictureController;
use Controller\Picture\CommentController as PictureCommentController;

Class Router
{
	private $userController;
	private $indexController;
	private $pictureController;
	private $pictureCommentController;

	public function __construct()
	{
		$this->userController = new UserController();
		$this->indexController = new IndexController();
		$this->pictureController = new PictureController();
		$this->pictureCommentController = new PictureCommentController;
	}

	public static function redirectToUrl($action)
	{
		header('Location: index.php?action='.$action);
	}

	private function getParam($key, $default = 1)
	{
		$id = $default;
		if (isset($_GET[$key]) && is_numeric($_GET[$key]) && $_GET[$key] > 0)
			$id = intval($_GET[$key]);
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
				$this->indexController->index($this->getParam('page', 1));
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
			case 'user_send_reset':
				$this->userController->send_reset();
				break;
			case 'user_reset_password':
				$this->userController->reset_password();
				break;
			case 'take':
				$this->pictureController->take();
				break;
			case 'picture_show':
				$this->pictureController->show($this->getParam('id'));
				break;
			case 'picture_remove':
				$this->pictureController->remove($this->getParam('id'));
				break;
			case 'picture_comment_create':
				$this->pictureCommentController->create();
				break;
			case 'picture_comment_remove':
				$this->pictureCommentController->remove($this->getParam('id'));
				break;
			case 'picture_comment_like':
				$this->pictureCommentController->like($this->getParam('id'));
				break;
			case 'picture_comment_unlike':
				$this->pictureCommentController->unlike($this->getParam('id'));
				break;
		}
	}
}
