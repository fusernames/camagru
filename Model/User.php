<?php

namespace Model;

use Framework\AlertManager;

Class User
{
	public $id;
	public $email;
	public $username;
	public $password;
	public $role = 'user';

	public static function hashPassword($pwd)
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
		if (!$this->password || strlen($this->password) < 2)
			return AlertManager::addAlert('danger', 'Mot de passe invalide');	
	}
}
