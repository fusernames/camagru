<?php

namespace Services;

use Services\AlertManager;
use Picture\Comment\CommentManager;
use Picture\PictureManager;

class Security
{

	public static function comment($comment, $action)
	{
		global $APP;
		if (!$APP->user)
			return FALSE;
		if ($action == 'remove')
			if ($comment->id_user == $APP->user->id || $APP->user->role == 'admin')
				return TRUE;
		if ($action == 'like') {
			if (!CommentManager::getLike($comment->id, $APP->user->id))
				return TRUE;
		}
		if ($action == 'unlike') {
			if (CommentManager::getLike($comment->id, $APP->user->id))
				return TRUE;
		}
		return FALSE;
	}

	public static function user($user, $action)
	{
		global $APP;
		if (!$APP->user)
			return FALSE;
		if ($action == 'edit')
			if ($user->id == $APP->user->id || $APP->user->role == 'admin')
				return TRUE;
		if ($action == 'remove')
			if ($APP->user->role == 'admin')
				return TRUE;
		if ($action == 'edit_role')
			if ($APP->user->role == 'admin')
				return TRUE;
		return FALSE;
	}

	public static function picture($picture, $action)
	{
		global $APP;
		if (!$APP->user)
			return FALSE;
		if ($action == 'remove') {
			if ($APP->user->role == 'admin' || $picture->id_user == $APP->user->id)
				return TRUE;
		}
		if ($action == 'like') {
			if (!PictureManager::getLike($picture->id, $APP->user->id))
				return TRUE;
		}
		if ($action == 'unlike') {
			if (PictureManager::getLike($picture->id, $APP->user->id))
				return TRUE;
		}
		return FALSE;
	}

	public static function unauthorized()
	{
		global $APP;
		return $APP->router->redirectToUrl('index');
	}

	public static function notFound()
	{
		global $APP;
		return $APP->router->redirectToUrl('index');
	}

	public static function accessUserOnly($url = 'login')
	{
		global $APP;
		if (!$APP->user) {
			return $APP->router->redirectToUrl($url);
		}
	}

	public static function accessAdminOnly($url = 'login')
	{
		global $APP;
		if (!$APP->user || $APP->user->role != 'admin')
			return $APP->router->redirectToUrl($url);
	}

	public static function checkForm(array $posts)
	{
		if ($_SERVER['REQUEST_METHOD'] != 'POST')
			return 1;
		if (!isset($_POST['token']) || $_POST['token'] != $_SESSION['token'])
			return AlertManager::addAlert('danger', 'Token invalide');
		foreach ($posts as $post) {
			if (!isset($_POST[$post]))
				return AlertManager::addAlert('danger', 'Formulaire invalide');
		}
		return 0;
	}

	public static function checkFile(array $files)
	{
		foreach ($files as $file) {
			if (!isset($_FILES[$file]))
				return AlertManager::addAlert('danger', 'Fichier invalide');
		}
	}
}
