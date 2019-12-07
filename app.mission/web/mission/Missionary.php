<?php namespace Application\Mission\Web;

use Application\Mission\Web\Page\Index;
use Eternity2\Mission\Web\Application;
use Eternity2\Mission\Web\Routing\Router;
use Eternity2\Thumbnail\ThumbnailResponder;

class Missionary extends Application {

	protected function route(Router $router) {
		$router->get('/thumbnail/*', ThumbnailResponder::class)();
		$router->get('/', Index::class)();
	}

}