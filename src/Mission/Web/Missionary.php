<?php namespace Application\Mission\Web;

use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Routing\Router;

class Mission extends Application {

	protected function route(Router $router) {
		$router->get('/thumbnail/*', \GhostThumbnailResponder::class)();
		$router->get('/users/codexinfo', Action\UsersCodexinfo::class)();
		$router->get('/articles/codexinfo', Action\ArticlesCodexInfo::class)();
		$router->get('/*', Page\Index::class)();
	}

}