<?php

namespace Model;

use Model\User;

Class UserManager
{
	public static function checkRegister($user)
	{
		global $APP;
		$errors = 0;
	
		$errors += checkEmail();
		$errors += checkUsername();
		$errors += checkPassword();
		if ($APP->dbManager->execute('SELECT count(*) FROM users WHERE email = '. $this->email))
			$errors += AlertManager::addAlert('danger', 'Cet email est deja utilise');
		if ($APP->dbManager->execute('SELECT count(*) FROM users WHERE username = '. $this->username))
			$errors += AlertManager::addAlert('danger', 'Ce nom d\'utilisateur est deja utilise');
		return $errors;
	}

	public static function register()
	{
		global $APP;

		$user = new User();
		$user->setEmail($_POST['email']);
		$user->setUsername($_POST['username']);
		$user->setPassword($_POST['password']);
		if (self::checkRegister())
			return 1;
		$user->hashPassword();
		self::saveUser();
	}
}
