<?php namespace Application\Mission\Admin\Page;


use Application\Service\Auth\WhoAmI;
use Eternity2\WebApplication\Responder\SmartPageResponder;

/**
 * @css /admin/css/style.css
 * @js  /admin/js/app.js
 * @title Admin
 * @template "@admin/Index.twig"
 */
class Index extends SmartPageResponder {

	/** @var \Application\Service\Auth\WhoAmI */
	private $whoAmI;

	public function __construct(WhoAmI $whoAmI) {
		parent::__construct();
		$this->whoAmI = $whoAmI;
	}

	function prepare() {
		$this->getDataBag()->set('user', $this->whoAmI->getUser()->name);
		$this->getDataBag()->set('avatar', $this->whoAmI->getUser()->getCodexAvatar());
	}

}