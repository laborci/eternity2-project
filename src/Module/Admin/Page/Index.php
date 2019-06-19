<?php namespace Application\Module\Admin\Page;


use Eternity2\WebApplication\Responder\SmartPageResponder;

/**
 * @css /admin/css/style.css
 * @js  /admin/js/app.js
 * @title Admin
 * @template "@admin/Index.twig"
 */
class Index extends SmartPageResponder {


	protected $authService;
	protected $authRepository;
	protected $user;

//	public function __construct(AuthService $authService) {
//		parent::__construct();
//		$this->authService = $authService;
//	}
//
//	function prepare() {
//		$user = $this->authService->getAuthenticated();
//		$this->getDataBag()->set('user', $user);
//	}

}