<?php

namespace Model;

Class User
{
	private $id;
	private $email;
	private $username;
	private $password;
	private $role = 'user';

	public function setPassword($password)
	{
		$this->password = hash('md5', $password);
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function checkUser()
	{
		if (!preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $this->email))
			$ERROR("Adresse email invalide");
	}
}	
