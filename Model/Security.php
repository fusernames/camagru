<?php

namespace Model;

class Security
{
	public static function AccessUserOnly($url = 'login')
	{
		global $APP;
		if (!$APP->user) {
			return ($APP->router->redirectToUrl($url));
		}
	}

	public static function AccessAdminOnly($url = 'login')
	{
		global $APP;
		if (!$APP->user || $APP->user->role != 'admin')
			return ($APP->router->redirectToUrl($url));
	}
}
