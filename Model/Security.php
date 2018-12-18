<?php

namespace Model;

class Security
{
	public static function user($user, $action)
	{
		global $APP;
		if ($action == 'edit') {
			if ($user->id == $APP->user->id || $APP->user->role == 'admin')
				return TRUE;
		}
		if ($action == 'delete') {
			if ($APP->user->role == 'admin')
				return TRUE;
		}
		if ($action == 'edit_role') {
			if ($APP->user->role == 'admin')
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
			return ($APP->router->redirectToUrl($url));
		}
	}

	public static function accessAdminOnly($url = 'login')
	{
		global $APP;
		if (!$APP->user || $APP->user->role != 'admin')
			return ($APP->router->redirectToUrl($url));
	}
}
