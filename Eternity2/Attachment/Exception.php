<?php

namespace Eternity2\Attachment;

use Throwable;
class Exception extends \Exception{

	const FILE_COUNT = 1;
	const FILE_SIZE = 2;
	const FILE_EXTENSION = 3;
	const CATEGORY_NOT_FOUND = 4;

	protected function __construct($message = "", $code = 0, Throwable $previous = null){ parent::__construct($message, $code, $previous); }

	public static function fileCountException(){
		return new static('Number of files exceeds the maximum allowed', self::FILE_COUNT);
	}

	public static function fileSizeException(){
		return new static('File size exceeds the maximum allowed size', self::FILE_SIZE);
	}

	public static function extensionNotAccepted(){
		return new static('File type not allowed', self::FILE_EXTENSION);
	}

	public static function requestedCategoryNotFound($category, $storage){
		return new static("The requested category ({$category}) was not found in {$storage}", self::CATEGORY_NOT_FOUND);
	}

}