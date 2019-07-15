<?php namespace Eternity2\WebApplication;

use Eternity2\System\Module\Module;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\ServiceManager\SharedService;
use Eternity2\WebApplication\Routing\Router;

abstract class Application implements SharedService, Module {

	/** @var Router */
	protected $router;

	public function run(){
		$this->router = ServiceContainer::get(Router::class);
		$this->initialize();
		$this->route($this->router);
		die();
	}

	protected function initialize(){	}

	abstract protected function route(Router $router);
}