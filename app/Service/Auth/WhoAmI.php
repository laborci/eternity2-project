<?php namespace Application\Service\Auth;

use Eternity2\Zuul\AuthServiceInterface;
use Ghost\User;

class WhoAmI{

	/** @var \Eternity2\Zuul\AuthServiceInterface */
	private $authService;
	public function __construct(AuthServiceInterface $authService){ $this->authService = $authService; }

	public function checkPermission($permission){ return $this->authService->checkPermission($permission); }
	public function isAuthenticated(){ return $this->authService->isAuthenticated(); }
	public function logout(){ return $this->authService->logout(); }
	public function getUser(): ?User{ return $this->authService->isAuthenticated() ? User::pick($this->authService->getAuthenticatedId()) : null; }

	public function getAuthService(): \Eternity2\Zuul\AuthServiceInterface{ return $this->authService; }

}