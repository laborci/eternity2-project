<?php namespace Application\Module\Admin\Middleware;

use Application\Service\Auth\AuthService;
use Application\Module\Admin\Page\Login;
use Eternity2\WebApplication\Pipeline\Middleware;

class AuthCheck extends Middleware {

	protected $authService;

	public function __construct(AuthService $authService) {
		$this->authService = $authService;
	}

	protected function run() {
		if (!$this->authService->isAuthenticated() || !$this->authService->checkPermission('admin')) {
			$this->authService->logout();
			$this->break(Login::class);
		} else {
			$this->next();
		}
	}

}
