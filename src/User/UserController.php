<?php

namespace User;

use Framework\AbstractController;
use Services\AlertManager;
use Services\Security;
use Services\Email;
use User\User;
use User\UserManager;

Class UserController extends AbstractController
{
	public function register()
	{
		if (isset($_SESSION['id']))
			return $this->redirectToUrl('index');
		if (!Security::checkForm(['email', 'username', 'password', 'repassword'])) {
			if (!UserManager::register())
				return $this->redirectToUrl('login');
		}
		return $this->render('user/register.php');
	}

	public function login()
	{
		if (isset($_SESSION['id']))
			return $this->redirectToUrl('index');
		if (!Security::checkForm(['username', 'password'])) {
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
		$user = UserManager::getUserById($id);
		if (!$user)
			return Security::notFound();
		if (!Security::user($user, 'edit'))
			return Security::unauthorized();
		if (!Security::checkForm(['username', 'email', 'password', 'repassword']))
			UserManager::edit($user);
		$user = UserManager::getUserById($id);
		return $this->render('user/edit.php', [
			'user' => $user
		]);
	}

	public function remove($id)
	{
		Security::accessAdminOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			if (!($user = UserManager::getUserById($id)))
				return Security::notFound();
			if (!Security::user($user, 'remove'));
				return Security::unauthorized();
			UserManager::remove($user);
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}

	public function activate()
	{
		global $APP;
		if (isset($_GET['username']) && isset($_GET['hash'])) {
			$user = UserManager::getUserBy('username', $_GET['username']);
			if ($user && $user->hash == $_GET['hash']) {
				$req = $APP->pdo->prepare('UPDATE user SET active = 1 WHERE id = ?');
				$req->execute([$user->id]);
				AlertManager::addAlert('success', 'Email verifié');
			}
		}
		$this->redirectToUrl('login');
	}

	public function send_reset()
	{
		if (!Security::checkForm(['email'])) {
			$user = UserManager::getUserBy('email', $_POST['email']);
			if ($user) {
				Email::sendReset($user);
				AlertManager::addAlert('success', 'Email envoye');
			} else {
				AlertManager::addAlert('danger', 'Aucun resultat pour cet email');
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
				if (!Security::checkForm(['password', 'repassword'])) {
					$user->password = $_POST['password'];
					$user->repassword = $_POST['repassword'];
					if (!$user->checkPassword()) {
						$req = $APP->pdo->prepare('UPDATE user SET password = ? WHERE id = ?');
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
