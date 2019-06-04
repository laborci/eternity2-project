<?php namespace Eternity2\WebApplication;

use Eternity2\System\Module\Module;
use Eternity2\System\ServiceManager\SharedService;
use Eternity2\System\ServiceManager\Service;
use Eternity2\WebApplication\Routing\Router;

abstract class Application implements SharedService, Module {

	use Service;

	protected $router;

	public function __construct(Router $router) {
		session_start();
		$this->router = $router;
	}

	public function run(){
		$this->route($this->router);
		die();
	}

	abstract protected function route(Router $router);
}
