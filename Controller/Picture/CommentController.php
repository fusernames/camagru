<?php

namespace Controller\Picture;

use Framework\AbstractController;
use Model\Security;
use Model\Picture\Comment;
use Model\Picture\CommentManager;

Class CommentController extends AbstractController
{
	public function create()
	{
		Security::accessUserOnly();
		if (Security::checkForm(['comment', 'id_picture']))
			CommentManager::create();
		return $this->redirectBack();
	}
	
	public function remove($id)
	{
		Security::accessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$comment = CommentManager::getCommentById($id);
			if (!$comment)
				return Security::notFound();
			if (!Security::comment($comment, 'remove'))
				return Security::unauthorized();
			CommentManager::remove($comment);
			$req = $APP->pdo->prepare(
				'DELETE FORM pictures_comment WHERE id = ?)'
			);
			$req->execute([$comment->id]);
			AlertManager::addAlert('success', 'Commentaire supprime');
		}
		return $this->redirectBack();
	}
	
	public function like($id)
	{
		global $APP;
		Security::accessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$comment = CommentManager::getCommentById($id);
			if (!$comment)
				return Security::notFound();
			if (!Security::comment($comment, 'like'))
				return Security::unauthorized();
			$req = $APP->pdo->prepare(
				'INSERT INTO picture_comment_like (id_user, id_comment) VALUES (?, ?)'
			);
			$req->execute([$APP->user->id, $comment->id]);
		}
		return $this->redirectBack();
	}

	public function unlike($id)
	{
		global $APP;
		Security::accessUserOnly();
		if (isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
			$comment = CommentManager::getCommentById($id);
			if (!$comment)
				return Security::notFound();
			if (Security::comment($comment, 'like'))
				return Security::unauthorized();
			$req = $APP->pdo->prepare(
				'DELETE FROM picture_comment_like WHERE id_user = ? AND id_comment = ?'
			);
			$req->execute([$APP->user->id,$comment->id]);
		}
		return $this->redirectBack();
	}
}
