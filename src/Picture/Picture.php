<?php

namespace Picture;

Class Picture
{
	public $id;
	public $filename;
	public $id_user;
	public $user = NULL;
	public $description = NULL;
	public $dstPath = NULL;
	public $srcPath = NULL;
	public $nb_likes = 0;

	public function mergeImages()
	{
		global $APP;
		$dst = self::imagecreatefrompath($this->dstPath);
		$src = self::imagecreatefrompath($this->srcPath);
		imagecopy($dst, $src, 0, 0, 0, 0, imagesx($src), imagesy($src));
		$filename = time().'.png';
		imagepng($dst, DIR_PUBLIC.'pictures/'.$filename);
		$this->filename = $filename;
	}

	public static function imagecreatefrompath($path)
	{
		$ret = getimagesize($path);
		$ext = image_type_to_extension($ret[2]);
		switch ($ext) {
			case '.jpeg':
			case '.jpg':
				return imagecreatefromjpeg($path);
				break;
			case '.png':
				return imagecreatefrompng($path);
				break;
			case '.gif':
				return imagecreatefromgif($path);
				break;
		}
	}

}
