<?php namespace Eternity2\Zuul;

Interface UserLoggerInterface {
	public function log($userId, $type, $description = null);
}