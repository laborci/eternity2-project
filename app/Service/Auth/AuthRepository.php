<?php namespace Application\Service\Auth;

use Eternity2\Zuul\AuthenticableInterface;
use Eternity2\Zuul\AuthenticableRepositoryInterface;
use Ghost\User;

class AuthRepository implements AuthenticableRepositoryInterface{


	public function authLookup($id): ?AuthenticableInterface{ return User::authLookup($id); }
	public function authLoginLookup($login): ?AuthenticableInterface{ return User::authLoginLookup($login); }

}