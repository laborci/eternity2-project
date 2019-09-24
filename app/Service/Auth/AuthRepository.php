<?php namespace Application\Service\Auth;

use Eternity2\Module\Zuul\Interfaces\AuthenticableInterface;
use Ghost\User;

class AuthRepository implements \Eternity2\Module\Zuul\Interfaces\AuthRepositoryInterface{


	public function authLookup($id): ?AuthenticableInterface{ return User::authLookup($id); }
	public function authLoginLookup($login): ?AuthenticableInterface{ return User::authLoginLookup($login); }

}