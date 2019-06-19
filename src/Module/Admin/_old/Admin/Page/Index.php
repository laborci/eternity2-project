<?php namespace Application\HTTP\Admin\Page;

use Application\Service\AuthService;
use Eternity\Response\Responder\SmartPageResponder;

/**
 * @css /dist/admin/style.css
 * @js  /dist/admin/app.js
 * @title Admin
 * @template "@admin/Index.twig"
 */
class Index extends SmartPageResponder{


	protected $authService;
	protected $authRepository;
	protected $user;

	public function __construct(AuthService $authService) {
		parent::__construct();
		$this->authService = $authService;
	}

	function prepare() {
		$user = $this->authService->getAuthenticated();
		$this->getDataBag()->set('user', $user);
	}

}