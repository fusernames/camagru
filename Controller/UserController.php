<?php

namespace Controller;

use Framework\AbstractController;
use Model\User;

Class UserController extends AbstractController
{
	public function register() {
		if ($this->request == 'POST') {
			$user = new User();
			$user->setPassword();
			$user->setUsername();
			if (Security::userSecurity('promote', $user))
				$user->setRole($role);
			$errors = $user->selfCheck();
			if ($this->getErrorManager()->getErrors()) {
				$this->dbManager->new($user);
				return $this->redirectToUrl('login.php');
			}
		}
		return $this->render('user/register.php');
	}

	function login() {
	}

	function edit($id) {	
	}
	
	function remove($id) {
		
	}
}
