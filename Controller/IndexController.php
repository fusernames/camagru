<?php

namespace Controller;

use Framework\AbstractController;
use Model\Picture;

Class IndexController extends AbstractController
{
	public function index($page) {
		global $APP;
		$nbPerPage = 4;
		$nbRes = $APP->pdo->query('SELECT count(*) FROM picture')->fetchColumn();
		$nbPages = ceil($nbRes/$nbPerPage);
		if ($page > $nbPages)
			$page = $nbPages;
		if ($nbPages == 0)
			$page = 1;
		$start = ($page - 1) * $nbPerPage;
		$pictures = $APP->pdo->query("SELECT * FROM picture ORDER BY creation_date DESC LIMIT $start, $nbPerPage")->fetchAll(\PDO::FETCH_CLASS, Picture::class);
		$this->render('index/index.php', [
			'pictures' => $pictures,
			'nbPages' => $nbPages,
			'page' => $page
		]);
	}
}
