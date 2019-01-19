<?php

namespace Picture;

use Framework\AbstractController;
use Services\AlertManager;
use Services\Security;
use Picture\PictureManager;
use User\UserManager;
use Picture\Comment\CommentManager;

Class PictureController extends AbstractController
{
	public function show($id)
	{
		$picture = PictureManager::getPictureById($id);
		if (!$picture)
			Security::notFound();
		$picture->user = UserManager::getUserById($picture->id_user);
		$comments = CommentManager::getCommentsByPictureId($picture->id);
		return $this->render('picture/show.php', [
			'picture' => $picture,
			'comments' => $comments
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
			unlink(DIR_PUBLIC.'pictures/'.$picture->name);
			$APP->pdo->query("DELETE FROM picture WHERE id = $picture->id");
			AlertManager::addAlert('success', 'Photo supprimee');
		}
		$this->redirectBack();
	}
}
