<?php

namespace Application\Service\Auth;

use Eternity2\System\ServiceManager\Service;
use Eternity2\Zuul\UserLoggerInterface;
use Ghost\User;
use Ghost\UserLog;

class AuthService extends \Eternity2\Zuul\AuthService implements UserLoggerInterface{

	use Service;

	public function log($userId, $type, $description = null){ UserLog::authLog($userId, $type, $description); }
	public function getUser(): ?User{
		$id = $this->getAuthenticatedId();
		return $id ? User::pick($id) : null;
	}

}