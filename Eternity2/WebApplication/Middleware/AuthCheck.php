<?php namespace Eternity2\WebApplication\Middleware;

use Eternity2\WebApplication\Pipeline\Middleware;
use Eternity2\Zuul\AuthServiceInterface;

class AuthCheck extends Middleware {

	protected $authService;

	public function __construct(AuthServiceInterface $authService) {
		$this->authService = $authService;
	}

	protected function run() {
		$responder = $this->getArgumentsBag()->get('responder');
		if (!$this->authService->isAuthenticated()){
			$this->authService->logout();
			$this->break($responder);
		} else {
			$this->next();
		}
	}

}
