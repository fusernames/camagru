<?php

namespace Model\Picture;

use Framework\AlertManager;
use Model\PictureManager;
use Model\Picture\Comment;

Class CommentManager
{
	public static function create()
	{
		global $APP;
		$comment = new PictureComment();
		$comment->idPicture = $_POST['picture'];
		$comment->idUser = $APP->user->id;
		$comment->comment = $_POST['comment'];
		if (!PictureManager::getPictureById($comment->idPicture))
			return AlertManager::addAlert('danger', 'Ce commentaire n\'existe pas');
		$req = $APP->pdo->prepare(
			'INSERT INTO picture_comment (id_picture, id_user, comment) VALUES (?, ?, ?)'
		);
		$req->execute([
			$comment->idPicture,
			$comment->idUser,
			$comment->comment
		]);
		return AlertManager::addAlert('success', 'Commentaire ajoute');
	}	
}
