<?php namespace Application\Mission\Admin;

use Application\Mission\Admin\Form\UserAdmin;
use Application\Mission\Admin\Page\Login;
use Eternity2\Codex\AdminRegistry;
use Eternity2\Codex\Responder\CodexAttachmentGet;
use Eternity2\Codex\Responder\CodexAttachmentUpload;
use Eternity2\Codex\Responder\CodexDeleteFormItem;
use Eternity2\Codex\Responder\CodexGetForm;
use Eternity2\Codex\Responder\CodexGetFormItem;
use Eternity2\Codex\Responder\CodexGetList;
use Eternity2\Codex\Responder\CodexInfo;
use Eternity2\Codex\Responder\CodexSaveFormItem;
use Eternity2\WebApplication\Action\Forbidden;
use Eternity2\WebApplication\Action\NotAuthorized;
use Eternity2\WebApplication\Application;
use Eternity2\WebApplication\Middleware\AuthCheck;
use Eternity2\WebApplication\Middleware\PermissionCheck;
use Eternity2\WebApplication\Routing\Router;
use Eternity2\Zuul\AuthService;

class Missionary extends Application{

	public function __construct(AdminRegistry $adminRegistry, AuthService $authService){
		if ($authService->isAuthenticated()){
			$adminRegistry->registerForm(UserAdmin::class);
		}
	}

	protected function route(Router $router){

		// PAGE AUTH
		$router->post("/login", Action\AuthAction::class, ["method" => "login"])();
		$router->pipe(AuthCheck::class, ["responder" => Login::class]);
		$router->pipe(PermissionCheck::class, ["responder" => Login::class, "permission" => "admin", "logout-on-fail" => true]);
		$router->post("/logout", Action\AuthAction::class, ["method" => "logout"])();

		// PAGES
		$router->get("/thumbnail/*", \GhostThumbnailResponder::class)();
		$router->get("/", Page\Index::class)();

		// API AUTH
		$router->clearPipeline();
		$router->pipe(AuthCheck::class, ["responder" => NotAuthorized::class]);
		$router->pipe(PermissionCheck::class, ["responder" => Forbidden::class, "permission" => "admin"]);

		// API
		$router->get('/{form}/codexinfo', CodexInfo::class)();
		$router->post('/{form}/get-list/{page}', CodexGetList::class)();
		$router->get('/{form}/get-form-item/{id}', CodexGetFormItem::class)();
		$router->get('/{form}/get-form', CodexGetForm::class)();
		$router->post('/{form}/save-item', CodexSaveFormItem::class)();
		$router->get('/{form}/delete-item/{id}', CodexDeleteFormItem::class)();
		$router->post('/{form}/attachment/upload/{id}', CodexAttachmentUpload::class)();
		$router->get('/{form}/attachment/get/{id}', CodexAttachmentGet::class)();

//		$router->get('/menu', Action\GetMenu::class)();
//		$router->get('/', Page\Index::class)();
	}

}
