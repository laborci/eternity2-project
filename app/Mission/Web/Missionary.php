<?php namespace Application\Mission\Web;

use Eternity2\Mission\Web\Application;
use Eternity2\Mission\Web\Routing\Router;

class Mission extends Application {

	protected function route(Router $router) {
		$router->get('/thumbnail/*', \GhostThumbnailResponder::class)();
	}

}