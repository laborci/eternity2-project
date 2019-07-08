<?php namespace Application\Module\Admin;

use Eternity2\RedFox\Attachment\ThumbnailResponder;
use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Routing\Router;

class Module extends Application{

	protected function route(Router $router){
		$router->post('/login', Action\AuthAction::class, ['method' => 'login'])();
		$router->pipe(Middleware\AuthCheck::class);

		$router->get('/', Page\Index::class)();
//		$router->get('/users/codexinfo', Action\UsersCodexinfo::class)();
//		$router->get('/thumbnails/*', ThumbnailResponder::class)();
//		$router->get('/menu', Action\GetMenu::class)();
//		$router->get('/', Page\Index::class)();
	}

}
