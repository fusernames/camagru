<?php

namespace Model;

use Model\User;
use Framework\AlertManager;

Class UserManager
{
	public static function checkRegister($user)
	{
		global $APP;
		$errors = 0;
	
		$errors += $user->checkEmail();
		$errors += $user->checkUsername();
		$errors += $user->checkPassword();
		if ($APP->pdo->query('SELECT COUNT(*) FROM users')->fetchColumn())
			$errors += AlertManager::addAlert('danger', 'Cet email est deja utilise');
		if ($APP->pdo->query('SELECT COUNT(*) FROM users')->fetchColumn())
			$errors += AlertManager::addAlert('danger', 'Ce nom d\'utilisateur est deja utilise');
		return $errors;
	}

	public static function register()
	{
		global $APP;

		$user = new User();
		$user->email = ($_POST['email']);
		$user->username = ($_POST['username']);
		$user->password = ($_POST['password']);
		if (self::checkRegister($user))
			return 1;
		$user->hashPassword();
		$APP->pdo->prepare('INSERT INTO users VALUES (?, ?, ?, ?)');
	}

	public static function getUserById($id)
	{
		global $APP;

		$stmt = $APP->dbManager->execute('SELECT * FROM users WHERE id = '.$id);
		return $stmt->fetchObject(User);
	}
	
	public static function getUserBy($key, $value)
	{
		global $APP;

		$stmt = $APP->dbManager->execute('SELECT * FROM users WHERE '.$key.' = '.$value);
		return $stmt->fetchObject(User);
	}

}
