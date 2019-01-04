<?php

namespace Model\Picture;

Class Comment
{
	public $id;
	public $idPicture;
	public $idUser;
	public $comment;
	public $creationDate;
	public $nbLikes = 0;
}
