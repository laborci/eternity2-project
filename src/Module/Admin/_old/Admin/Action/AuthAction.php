<?php namespace Application\HTTP\Admin\Action;

use Application\Service\AuthService;
use Application\Service\UserLogger;
use Eternity\Response\Responder\JsonResponder;

class AuthAction extends JsonResponder {

	protected $authService;
	protected $userLog;

	public function __construct(AuthService $authService, UserLogger $userLogger) {
		$this->authService = $authService;
		$this->userLog = $userLogger;
	}

	protected function respond() {
		$method = $this->getArgumentsBag()->get('method');
		switch ($method) {
			case 'login':
				if (!$this->authService->login($this->getRequestBag()->get('login'), $this->getRequestBag()->get('password'), 'admin')) {
					$this->getResponse()->setStatusCode('401');
				} else {
					$this->userLog->log($this->authService->getAuthenticatedId(), UserLogger::ADMINLOGIN);
				}
				break;
			case 'logout':
				$this->userLog->log($this->authService->getAuthenticatedId(), UserLogger::ADMINLOGOUT);
				$this->authService->logout();
				break;
		}

	}
}