<?php namespace Eternity2\Zuul;

interface AuthContainerInterface {

	public function setUserId($userId);
	public function getUserId();
	public function forget();


}