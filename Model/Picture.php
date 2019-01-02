<?php

namespace Model;

Class Picture
{
	public $filename;
	public $author;
	public $authorObject = NULL;
	public $description = NULL;
	public $creationDate;
	public $dstPath = NULL;
	public $srcPath = NULL;

	public function mergePicture()
	{
		global $APP;
		$dst = self::imagecreatefrompath($this->dstPath);
		$src = self::imagecreatefrompath($this->srcPath);
		imagecopy($dst, $src, 0, 0, 0, 0, imagesx($src), imagesy($src));
		$filename = $APP->user->username.'_'.time().'.png';
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
