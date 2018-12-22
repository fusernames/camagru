<?php

Class PictureController extends AbstractController
{
	public function take() {
		Security::AccessUserOnly();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$pic = new Picture();
			$pic->path = $_FILES['file']['tmp_name'];
			if (!PictureManager::checkPicture)
				if ($_POST['img'] && $_POST['user_img']) {
					$dst = imagecreatefrompng($_POST['user_img']);
					$src = imagecreatefromjpeg($pic->path);
					imagecopymerge($dst, $src);
					imagepng($dst, DIR_IMG.'a.png');
				}
			}
		}
		return $this->render('picture/take.php');
	}
}
