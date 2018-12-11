<?php

namespace Controller;

use Framework\AbstractController;

Class IndexController extends AbstractController
{
	public function index() {
		$this->render('index/index.php');
	}
}
