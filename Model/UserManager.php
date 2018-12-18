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
		if ($APP->pdo->query('SELECT email FROM users WHERE email = \''. $user->email .'\'')->fetchColumn())
			$errors += AlertManager::addAlert('danger', 'Cet email est deja utilise');
		if ($APP->pdo->query('SELECT username FROM users WHERE username = \''. $user->username .'\'')->fetchColumn())
			$errors += AlertManager::addAlert('danger', 'Ce nom d\'utilisateur est deja utilise');
		return $errors;
	}


	public static function login()
	{
		global $APP;

		$req = $APP->pdo->prepare('SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1');
		$req->execute([
			$_POST['username'],
			User::hashPassword($_POST['password'])
		]);
		$user = $req->fetchObject(User::class);
		print_r($user);
		if ($user)
			$_SESSION['id'] = $user->id;
		else
			return AlertManager::addAlert('danger', 'Utilisateur/Mot de passe invalides');
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
		$user->password = User::hashPassword($user->password);
		$req = $APP->pdo->prepare('INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, ?)');
		$req->execute(array($user->email, $user->username, $user->password, $user->role));
	}

	public static function getUserById($id)
	{
		global $APP;

		$stmt = $APP->pdo->query('SELECT * FROM users WHERE id = '.$id);
		return $stmt->fetchObject(User::class);
	}
	
	public static function getUserBy($key, $value)
	{
		global $APP;

		$stmt = $APP->dbManager->execute('SELECT * FROM users WHERE '.$key.' = '.$value);
		return $stmt->fetchObject(User);
	}

}
