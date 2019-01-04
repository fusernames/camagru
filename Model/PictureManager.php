<?php

namespace Model;

use Model\Picture;
use Model\Security;
use Framework\AlertManager;

Class PictureManager
{
	public static function createPicture($path)
	{
		global $APP;
		$pic = new Picture();
		$pic->dstPath = $_FILES['pic']['tmp_name'];
		$pic->srcPath = DIR_PUBLIC.'filters/'.$_POST['src'];
		if (self::checkTmp($pic))
			return 1;
		$pic->author = $APP->user->id;
		if ($_POST['description'])
			$pic->description = $_POST['description'];
		$pic->mergePicture();
		$req = $APP->pdo->prepare('INSERT picture (author, filename, description) VALUES (:author, :filename, :description)');
		$req->execute([
			':author' => $pic->author,
			':filename' => $pic->filename,
			':description' => $pic->description,
		]);
		return AlertManager::addAlert('success', 'Image enregistree');
	}

	public static function checkTmp($pic)
	{
		if (!$pic->dstPath || !file_exists($pic->dstPath)
			|| !$pic->srcPath || !file_exists($pic->srcPath))
			return AlertManager::addAlert('danger', 'Ce fichier n\'existe pas');
		if (!getimagesize($pic->dstPath) || !getimagesize($pic->srcPath))
			return AlertManager::addAlert('danger', 'Ce fichier n\'est pas une image');
	}

	public static function getPictureById($id)
	{
		global $APP;
		$req = $APP->pdo->prepare('SELECT * FROM picture WHERE id = ? LIMIT 1');
		$req->execute([$id]);
		return $req->fetchObject(Picture::class);
	}
}
