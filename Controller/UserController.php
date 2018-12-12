<?php

namespace Controller;

use Framework\AbstractController;
use Model\UserManager;

Class UserController extends AbstractController
{
	public function register()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!UserManager::register())
				return $this->redirectToUrl('login.php');
		}
		return $this->render('user/register.php');
	}

	public function login() {
	}

	public function edit($id) {	
	}

	public function remove($id) {		
	}
}
