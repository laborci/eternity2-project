<?php namespace Eternity2\Zuul;


class AuthService implements AuthServiceInterface {

	protected $container;
	protected $repository;

	public function __construct(AuthContainerInterface $container, AuthenticableRepositoryInterface $repository) {
		$this->container = $container;
		$this->repository = $repository;
	}

	public function isAuthenticated(): bool {
		return (bool)$this->container->getUserId();
	}

	public function getAuthenticatedId():int {
		return $this->container->getUserId();
	}

	public function login($login, $password, $permission = null): bool {
		$user = $this->repository->authLoginLookup($login);
		if(!$user) return false;
		if ($user->checkPassword($password) && ( $user->checkPermission($permission) || is_null($permission))) {
			$this->registerLogin($user);
			return true;
		} else {
			return false;
		}
	}

	public function registerLogin(AuthenticableInterface $user){
		$this->container->setUserId( $user->getId() );
	}

	public function checkPermission($permission): bool {
		if(!$this->isAuthenticated()) return false;
		return  $this->repository->authLookup($this->container->getUserId())->checkPermission($permission);
	}

	public function logout() {
		$this->container->forget();
	}

}