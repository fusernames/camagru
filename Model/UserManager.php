<?php

namespace Model;

use Model\User;
use Model\Security;
use Framework\AlertManager;

Class UserManager
{
	public static function sendEmail($user)
	{
		$to = $user->email;
		$subject = 'Camagru - Verifier votre compte';
		$message = 'localhost:8080/index.php?action=user_check_email&user_id='.$user->id.'&hash='.$user->hash;
		$message = 'salut';
		mail($to, $subject, $message);
	}

	public static function edit($user)
	{
		global $APP;
		$edited = clone $user;
		$edited->email = $_POST['email'];
		$edited->username = $_POST['username'];
		if ($_POST['password']) {
			$edited->password = $_POST['password'];
			$edited->repassword = $_POST['repassword'];
		}
		if (Security::user($user, 'edit_role') && $_POST['role'])
			$edited->role = $_POST['role'];
		if (self::checkEdit($user, $edited))
			return 1;
		if ($_POST['password'])
			$edited->password = User::hashWord($user->password);

		$req = $APP->pdo->prepare('UPDATE users SET email = :email, username = :username, password = :password, role = :role WHERE id = :id');
		$req->execute([
			':email' => $edited->email,
			':username' => $edited->username,
			':password' => $edited->password,
			':role' => $edited->role,
			':id' => $edited->id
		]);
	}

	public static function login()
	{
		global $APP;

		$req = $APP->pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password LIMIT 1');
		$req->execute([
			':username' => $_POST['username'],
			':password' => User::hashWord($_POST['password'])
		]);
		$user = $req->fetchObject(User::class);
		if ($user && $user->active == 0)
			return AlertManager::addAlert('danger', 'Email non verifie, regardez vos mails');
		if ($user)
			$_SESSION['id'] = $user->id;
		else
			return AlertManager::addAlert('danger', 'Utilisateur/Mot de passe invalides');
	}

	public static function register()
	{
		global $APP;

		$user = new User();
		$user->email = $_POST['email'];
		$user->username = $_POST['username'];
		$user->password = $_POST['password'];
		$user->repassword = $_POST['repassword'];
		if (self::checkRegister($user))
			return 1;
		$user->password = User::hashWord($user->password);

		$req = $APP->pdo->prepare('INSERT INTO users (email, username, password, role, hash, active) VALUES (:email, :username, :password, :role, :hash, :active)');
		$req->execute([
			':email' => $user->email,
			':username' => $user->username,
			':password' => $user->password,
			':role' => $user->role,
			':hash' => $user->hash,
			':active' => $user->active
		]);
		self::sendEmail($user);
		die();
	}

	public static function remove($user)
	{
		global $APP;
		$req = $APP->pdo->prepare('DELETE FROM user WHERE id = :id');
		$req->execute([
			':id' => $user->id
		]);
	}
	
	public static function checkRegister($user)
	{
		$errors = 0;	
		$errors += $user->checkEmail();
		$errors += $user->checkUsername();
		$errors += $user->checkPassword();
		$errors += $user->usernameExists();
		$errors += $user->emailExists();
		return $errors;
	}

	public static function checkEdit($user, $edited)
	{
		$errors = 0;	
		$errors += $edited->checkEmail();
		$errors += $edited->checkUsername();
		if ($user->password != $edited->password)
			$errors += $edited->checkPassword();
		if ($user->username != $edited->username)
			$errors += $edited->usernameExists();
		if ($user->email != $edited->email)
			$errors += $edited->emailExists();
		return $errors;
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
		$stmt = $APP->pdo->query('SELECT * FROM users WHERE '.$key.' = '.$value);
		return $stmt->fetchObject(User::class);
	}
}
