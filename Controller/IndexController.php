<?php

namespace Controller;

use Framework\AbstractController;
use Model\Picture;

Class IndexController extends AbstractController
{
	public function index($page) {
		global $APP;
		$nbPerPage = 4;
		$nbRes = $APP->pdo->query('SELECT count(*) FROM pictures')->fetchColumn();
		$nbPages = ceil($nbRes/$nbPerPage);
		if ($page > $nbPages)
			$page = $nbPages;
		$start = ($page - 1) * $nbPerPage;
		$pictures = $APP->pdo->query("SELECT * FROM pictures ORDER BY creation_date DESC LIMIT $start, $nbPerPage")->fetchAll(\PDO::FETCH_CLASS, Picture::class);
		$this->render('index/index.php', [
			'pictures' => $pictures,
			'nbPages' => $nbPages,
			'page' => $page
		]);
	}
}
