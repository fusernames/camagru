<?php

namespace Controller;

use Framework\AbstractController;
use Model\UserManager;
use Model\Security;

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
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	public function edit($id)
	{
		Security::accessUserOnly();
		if (!($user = UserManager::getUserById($id)))
			Security::notFound();
		if (!Security::user($user, 'edit'))
			Security::unauthorized();
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
			UserManager::edit($user);
		$user = UserManager::getUserById($id);
		return $this->render('user/edit.php', [
			'user' => $user
		]);
	}

	public function remove($id)
	{
		Security::accessAdminOnly();
		if (!($user = UserManager::getUserById($id)))
			Security::notFound();
		if (!Security::user($user, 'remove'))
			Security::unauthorized();
		UserManager::remove($user);
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	
}
