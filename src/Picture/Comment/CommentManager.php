<?php

namespace Picture\Comment;

use Services\AlertManager;
use Services\Email;
use Picture\PictureManager;
use Picture\Comment\Comment;
use User\UserManager;

Class CommentManager
{
	public static function create()
	{
		global $APP;
		$comment = new Comment();
		if (!isset($_POST['comment']) || $_POST['comment'] === '')
			return AlertManager::addAlert('danger', 'Message trop court');
		$comment->id_picture = $_POST['id_picture'];
		$comment->id_user = $APP->user->id;
		$comment->comment = $_POST['comment'];
		if (!PictureManager::getPictureById($comment->id_picture))
			return AlertManager::addAlert('danger', 'Ce commentaire n\'existe pas');
		$req = $APP->pdo->prepare(
			'INSERT INTO picture_comment (id_picture, id_user, comment) VALUES (?, ?, ?)'
		);
		$req->execute([
			$comment->id_picture,
			$comment->id_user,
			$comment->comment
		]);

		$pic = pictureManager::getPictureById($_POST['id_picture']);
		$user = userManager::getUserById($pic->id_user);
		if ($user->alert === 1)
		{
			Email::sendCommentAlert($user, $comment);
		}
		return AlertManager::addAlert('success', 'Commentaire ajouté');
	}

	public static function getCommentsByPictureId($id)
	{
		global $APP;
		$req = $APP->pdo->prepare(
			'SELECT * FROM picture_comment WHERE id_picture = ? ORDER BY creation_date DESC'
		);
		$req->execute([$id]);
		$comments = $req->fetchAll(\PDO::FETCH_CLASS, Comment::class);
		foreach($comments as &$comment)
			$comment->user = UserManager::getUserById($comment->id_user);
		return $comments;
	}

	public static function getCommentById($id)
	{
		global $APP;
		$req = $APP->pdo->prepare(
			'SELECT * FROM picture_comment WHERE id = ? LIMIT 1'
		);
		$req->execute([$id]);
		$comment = $req->fetchObject(Comment::class);
		return $comment;
	}

	public static function getLike($id_comment, $id_user)
	{
		global $APP;
		$req = $APP->pdo->prepare(
			'SELECT count(*) FROM picture_comment_like WHERE id_comment = ? AND id_user = ? LIMIT 1'
		);
		$req->execute([$id_comment, $id_user]);
		$like = $req->fetchColumn();
		return $like;
	}
}
