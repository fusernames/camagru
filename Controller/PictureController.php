<?php

namespace Controller;

use Framework\AbstractController;
use Framework\AlertManager;
use Model\Security;
use Model\PictureManager;
use Model\UserManager;

Class PictureController extends AbstractController
{
	public function show($id)
	{
		$picture = PictureManager::getPictureById($id);
		if (!$picture)
			Security::notFound();
		$picture->authorObject = UserManager::getUserById($picture->author);
		return $this->render('picture/show.php', [
			'picture' => $picture
		]);
	}

	public function take()
	{
		Security::AccessUserOnly();
		if (!Security::checkForm(['src', 'description'], ['pic'])) {
			PictureManager::createPicture($_FILES['pic']['tmp_name']);
		}
		return $this->render('picture/take.php');
	}

	public function remove($id)
	{
		global $APP;
		Security::AccessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$picture = PictureManager::getPictureById($id);
			if (!$picture)
				return Security::notFound();
			if (!Security::picture($picture, 'remove'))
				return Security::unauthorized();
			$APP->pdo->query("DELETE FROM pictures WHERE id = $picture->id");
			AlertManager::addAlert('success', 'Photo supprimee');
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
}
