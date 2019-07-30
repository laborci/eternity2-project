<?php namespace Application\HTTP\Admin;

use Eternity\Routing\Router;
use RedFox\Entity\Attachment\ThumbnailResponder;

class Site extends \Eternity\Application\WebSite {

	function route(Router $router) {

		$router->post('/login', Action\AuthAction::class, ['method'=>'login'])();
		$router->pipe(Middleware\AuthCheck::class);
		$router->post('/logout', Action\AuthAction::class, ['method'=>'logout'])();
		$router->get('/thumbnails/*', ThumbnailResponder::class)();
		$router->get('/menu', Action\GetMenu::class)();
		$router->get('/', Page\Index::class)();
		$router->get('/get-active-users/get/{ids}', Action\GetActiveUsers::class)();
		$router->get('/get-active-users/{search}', Action\GetActiveUsers::class)();
		$router->get('/get-active-users', Action\GetActiveUsers::class)();
		$router->get('/get-conflicts', Action\GetConflicts::class)();
		$router->get('/delete-conflict/{id}', Action\DeleteConflict::class)();

		Form\UserFormDescriptor::createRoutes($router);
		Form\ScheduleFormDescriptor::createRoutes($router);
		Form\ClassroomAdminDescriptor::createRoutes($router);
		Form\ClassroomRuleAdminDescriptor::createRoutes($router);
		Form\ReservationPeriodAdminDescriptor::createRoutes($router);

	}
}


