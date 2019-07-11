<?php namespace Eternity2\WebApplication\Middleware;

use Eternity2\WebApplication\Pipeline\Middleware;
use Eternity2\Zuul\AuthServiceInterface;

class PermissionCheck extends Middleware {

	protected $authService;

	public function __construct(AuthServiceInterface $authService) {
		$this->authService = $authService;
	}

	protected function run() {

		$responder = $this->getArgumentsBag()->get('responder');
		$permission = $this->getArgumentsBag()->get('permission');
		$logoutOnFail = $this->getArgumentsBag()->get('logout-on-fail');

		if (!$this->authService->checkPermission($permission)) {
			if($logoutOnFail) $this->authService->logout();
			$this->break($responder);
		} else {
			$this->next();
		}
	}

}
