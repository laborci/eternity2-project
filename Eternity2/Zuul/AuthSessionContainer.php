<?php namespace Eternity2\Zuul;

use Eternity2\System\Session\Container;

class AuthSessionContainer extends Container implements AuthContainerInterface {

	public $userId;
	public function setUserId($userId) { $this->userId = $userId; }
	public function getUserId() { return $this->userId; }

}