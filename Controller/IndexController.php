<?php

namespace Controller;

use Framework\AbstractController;

Class IndexController extends AbstractController
{
	public function index() {
		return $this->render('index/index.php');
	}
}
