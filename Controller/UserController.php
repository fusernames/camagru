<?php

namespace Controller;

use Framework\AbstractController;
use Framework\AlertManager;
use Model\User;
use Model\UserManager;
use Model\Security;
use Model\Email;

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
			return Security::notFound();
		if (!Security::user($user, 'edit'))
			return Security::unauthorized();
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
			return Security::notFound();
		if (!Security::user($user, 'remove'))
			return Security::unauthorized();
		UserManager::remove($user);
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	public function activate()
	{
		global $APP;
		if (isset($_GET['username']) && isset($_GET['hash'])) {
			$user = UserManager::getUserBy('username', $_GET['username']);
			if ($user && $user->hash == $_GET['hash']) {
				$req = $APP->pdo->prepare('UPDATE users SET active = 1 WHERE id = ?');
				$req->execute([$user->id]);
				AlertManager::addAlert('success', 'Email verifié');
			}
		}
		$this->redirectToUrl('login');
	}

	public function send_reset()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['email'])) {
				$user = UserManager::getUserBy('email', $_POST['email']);
				if ($user) {
					Email::sendReset($user);
					AlertManager::addAlert('success', 'Email envoye');
				} else {
					AlertManager::addAlert('danger', 'Aucun resultat pour cet email');	
				}
			}
		}
		return $this->render('user/send_reset.php');
	}

	public function reset_password()
	{
		global $APP;
		if (isset($_GET['hash']) && isset($_GET['username'])) {
			$user = UserManager::getUserBy('username', $_GET['username']);
			if ($user && $user->hash == $_GET['hash']) {
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$user->password = $_POST['password'];
					$user->repassword = $_POST['repassword'];
					if (!$user->checkPassword()) {
						$req = $APP->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
						$req->execute([User::hashWord($user->password), $user->id]);
						AlertManager::addAlert('success', 'Mot de passe mis a jour');
						$this->redirectToUrl('login');
					}
				}
				return $this->render('user/reset_password.php');
			} else {
				return Security::unauthorized();
			}
		}
	}
}
