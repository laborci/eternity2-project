<?php

namespace Application\Service;

use Eternity2\Zuul\AuthenticableInterface;
use Eternity2\Zuul\AuthenticableRepositoryInterface;
use Eternity2\Zuul\UserLoggerInterface;
use Ghost\User;
use Ghost\UserLog;

class AuthService extends \Eternity2\Zuul\AuthService implements AuthenticableRepositoryInterface, UserLoggerInterface{

	public function authLookup($id): AuthenticableInterface{ return User::authLookup($id); }
	public function authLoginLookup($login): ?AuthenticableInterface{ return User::authLoginLookup($login); }
	public function log($userId, $type, $description = null){ UserLog::authLog($userId, $type, $description); }
	public function getUser(): ?User{
		$id = $this->getAuthenticatedId();
		return $id ? User::pick($id) : null;
	}

}