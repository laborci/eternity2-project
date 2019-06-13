<?php namespace Application\Module\Web;

use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Routing\Router;

class Module extends Application {

	protected function route(Router $router) {
		$router->get('/', Page\Index::class)();
		$router->get('/users/codexinfo', Action\UsersCodexinfo::class)();
	}

}