<?php

namespace Model;

Class User
{
	private $id;
	private $email;
	private $username;
	private $password;
	private $role = 'user';

	public function hashPassword()
	{
		$this->password = hash('md5', $this->password);
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	public function checkEmail()
	{
		if (preg_match('/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/', $this->email))
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
