<?php

Class PictureComment
{
	public $picture;
	public $author;
	public $comment;
	public $creation_date;
	public $nbLikes = 0;
}

Class PictureCommentManager
{
	public static function create()
	{
		global $APP;
		$comment = new PictureComment();
		$comment->picture = $_POST['picture'];
		$comment->author = $APP->user->id;
		$comment->comment = $_POST['comment'];
		$req = $APP->pdo->prepare('INSERT INTO picture_comments');
	}
}
