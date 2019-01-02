<?php

namespace Model;

use Framework\AlertManager;

Class User
{
	public $id;
	public $email;
	public $username;
	public $password;
	public $repassword = NULL;
	public $role = 'user';
	public $hash;
	public $active = 0;

	public static function hashWord($pwd)
	{
		return hash('md5', $pwd);
	}

	public function checkEmail()
	{
		if (!$this->email || !preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $this->email))
			return AlertManager::addAlert('danger', 'Adresse email invalide');
	}

	public function checkUsername()
	{
		if (!$this->username)
			return AlertManager::addAlert('danger', 'Nom d\'utilisateur invalide');
	}

	public function checkPassword()
	{
		if (!$this->password || strlen($this->password) < 5)
			return AlertManager::addAlert('danger', 'Mot de passe invalide');
		if ($this->repassword != $this->password)
			return AlertManager::addAlert('danger', 'Mots de passe differents');
	}

	public function usernameExists()
	{
		global $APP;
		if ($APP->pdo->query('SELECT username FROM users WHERE username = \''. $this->username .'\'')->fetchColumn())
			return AlertManager::addAlert('danger', 'Ce nom d\'utilisateur est deja utilisé');
	}

	public function emailExists()
	{
		global $APP;
		if ($APP->pdo->query('SELECT email FROM users WHERE email = \''. $this->email .'\'')->fetchColumn())
			return AlertManager::addAlert('danger', 'Cet email est deja utilisé');
	}
}
