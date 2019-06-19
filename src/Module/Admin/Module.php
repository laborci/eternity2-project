<?php namespace Application\Module\Admin;

use Application\HTTP\Admin\Action\DeleteConflict;
use Application\HTTP\Admin\Action\GetActiveUsers;
use Application\HTTP\Admin\Action\GetConflicts;
use Application\HTTP\Admin\Action\GetMenu;
use Application\HTTP\Admin\Page\Index;
use Eternity2\RedFox\Attachment\ThumbnailResponder;
use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Routing\Router;

class Module extends Application {

	protected function route(Router $router) {
		$router->get('/', Page\Index::class)();
//		$router->get('/users/codexinfo', Action\UsersCodexinfo::class)();
		$router->get('/thumbnails/*', ThumbnailResponder::class)();
//		$router->get('/menu', Action\GetMenu::class)();
		$router->get('/', Page\Index::class)();
	}

}
