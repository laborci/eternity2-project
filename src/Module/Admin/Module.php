<?php namespace Application\Module\Admin;

use Application\Module\Admin\Page\Login;
use Eternity2\WebApplication\Action\Forbidden;
use Eternity2\WebApplication\Action\NotAuthorized;
use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Middleware\AuthCheck;
use Eternity2\WebApplication\Middleware\PermissionCheck;
use Eternity2\WebApplication\Routing\Router;

class Module extends Application{

	protected function route(Router $router){

		// PAGE AUTH
		$router->post("/login", Action\AuthAction::class, ["method" => "login"])();
		$router->pipe(AuthCheck::class, ["responder" =>Login::class]);
		$router->pipe(PermissionCheck::class, ["responder" =>Login::class, "permission" =>"admin", "logout-on-fail" =>true]);
		$router->post("/logout", Action\AuthAction::class, ["method" => "logout"])();


		// PAGES
		$router->get("/thumbnail/*", \GhostThumbnailResponder::class)();
		$router->get("/", Page\Index::class)();

		// API AUTH
		$router->clearPipeline();
		$router->pipe(AuthCheck::class, ["responder" =>NotAuthorized::class]);
		$router->pipe(PermissionCheck::class, ["responder" =>Forbidden::class, "permission" =>"admin"]);

		// API


		//		$router->get('/users/codexinfo', Action\UsersCodexinfo::class)();
//		$router->get('/thumbnails/*', ThumbnailResponder::class)();
//		$router->get('/menu', Action\GetMenu::class)();
//		$router->get('/', Page\Index::class)();
	}

}
