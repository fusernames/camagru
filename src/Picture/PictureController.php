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
		global $APP;
		Security::AccessUserOnly();
		if (!Security::checkForm(['src', 'description', 'snapshot'])) {
			if (empty($_POST['snapshot'])) {
				Security::checkFile(['pic']);
				PictureManager::createPicture($_FILES['pic']['tmp_name']);
			} else {
				$data = explode(',', $_POST['snapshot']);
				$content = base64_decode($data[1]);
				$filename = hash('md5', rand(0, 500)).'_'.time().'.png';
				file_put_contents(DIR_TMP.$filename, $content);
				PictureManager::createPicture(DIR_TMP.$filename);
				unlink(DIR_TMP.$filename);
			}
		}
		$pictures = PictureManager::getPicturesById($APP->user->id);
		return $this->render('picture/take.php', [
			'pictures' => $pictures
		]);
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
			unlink(DIR_PIC.$picture->filename);
			$APP->pdo->query("DELETE FROM picture WHERE id = $picture->id");
			AlertManager::addAlert('success', 'Photo supprimee');
		}
		$this->redirectBack();
	}

	public function like($id)
	{
		global $APP;
		Security::accessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$picture = PictureManager::getPictureById($id);
			if (!$picture)
				return Security::notFound();
			if (!Security::picture($picture, 'like'))
				return Security::unauthorized();
			$req = $APP->pdo->prepare(
				'INSERT INTO picture_like (id_user, id_picture) VALUES (?, ?)'
			);
			$req->execute([$APP->user->id, $picture->id]);
			$APP->pdo->query("UPDATE picture SET nb_likes = nb_likes + 1 WHERE id = $picture->id");
		}
		return $this->redirectBack();
	}

	public function unlike($id)
	{
		global $APP;
		Security::accessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$picture = PictureManager::getPictureById($id);
			if (!$picture)
				return Security::notFound();
			if (!Security::picture($picture, 'unlike'))
				return Security::unauthorized();
			$req = $APP->pdo->prepare(
				'DELETE FROM picture_like WHERE id_user = ? AND id_picture = ?'
			);
			$req->execute([$APP->user->id, $picture->id]);
			$APP->pdo->query("UPDATE picture SET nb_likes = nb_likes - 1 WHERE id = $picture->id");
		}
		return $this->redirectBack();
	}
}
