<?php

namespace Controller;

use Framework\AbstractController;
use Model\UserManager;

Class UserController extends AbstractController
{
	public function register()
	{
		if (isset($_SESSION['id']))
			return $this->redirectToUrl('index');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!UserManager::register())
				return $this->redirectToUrl('login');
		}
		return $this->render('user/register.php');
	}

	public function login()
	{
		if (isset($_SESSION['id']))
			return $this->redirectToUrl('index');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!UserManager::login())
				return $this->redirectToUrl('index');	
		}
		return $this->render('user/login.php');
	}
	
	public function logout()
	{
		if (isset($_SESSION['id']))
			unset($_SESSION['id']);
		return $this->redirectToUrl('index');
	}

	public function edit($id)
	{
		Security::AccessUserOnly();
		Security::User($user, 'edit');
	}

	public function remove($id)
	{
		Security::AccessUserOnly();
		Security::User($user, 'remove');
	}
	
}
