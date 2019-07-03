<?php

namespace Application\Service;

use Eternity2\Zuul\AuthenticableInterface;
use Eternity2\Zuul\AuthenticableRepositoryInterface;
use Eternity2\Zuul\UserLoggerInterface;

class AuthService extends \Eternity2\Zuul\AuthService implements AuthenticableRepositoryInterface, UserLoggerInterface{

	public function authLookup($id): AuthenticableInterface{
		// TODO: Implement authLookup() method.
	}
	public function authLoginLookup($login): ?AuthenticableInterface{
		// TODO: Implement authLoginLookup() method.
	}
	public function log($userId, $type, $description = null){
		// TODO: Implement log() method.
	}
}