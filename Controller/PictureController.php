<?php

Class PictureController extends AbstractController
{
	public function take() {
		Security::AccessUserOnly();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['img'] && $_POST['user_img']) {
				$dst = imagecreatefrompng($_POST['user_img']);
				$src = imagecreatefromjpeg(DIR_IMG.$_POST['img']);
				imagecopymerge($dst, $src);
				imagepng($dst, DIR_IMG.'a.png');
			}
		}
		return $this->render('picture/take.php');
	}
}
