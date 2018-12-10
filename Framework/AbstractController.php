<?php

namespace Framework;

abstract Class AbstractController
{
	public function render($view, array $params = array())
	{
		//extract($params);
		require_once(DIR_VIEW . $view);
	}
}
