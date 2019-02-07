<?php

namespace User;

use Services\AlertManager;

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
	public $alert = 1;

	public static function hashWord($pwd)
	{
		return hash('whirlpool', $pwd);
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
		if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $this->password))
			return AlertManager::addAlert('danger', 'Aucun caractère special dans le mot de passe');
		if ($this->repassword != $this->password)
			return AlertManager::addAlert('danger', 'Mots de passe differents');
	}

	public function usernameExists()
	{
		global $APP;
		$req = $APP->pdo->prepare('SELECT username FROM user WHERE username = ?');
		$req->execute([$this->username]);
		if ($req->fetchColumn())
			return AlertManager::addAlert('danger', 'Ce nom d\'utilisateur est deja utilisé');
	}

	public function emailExists()
	{
		global $APP;
		$req = $APP->pdo->prepare('SELECT email FROM user WHERE email = ?');
		$req->execute([$this->email]);
		if ($req->fetchColumn())
			return AlertManager::addAlert('danger', 'Cet email est deja utilisé');
	}
}
