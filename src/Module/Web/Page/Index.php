<?php namespace Application\Module\Web\Page;

use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\WebApplication\Responder\SmartPageResponder;

/**
 * @template "@web/Index.twig"
 * @title "Index"
 * @bodyclass "mypage"
 * @js "/js/www/app.js"
 * @css "/css/www/app.css"
 */
class Index extends SmartPageResponder {

	public function __construct(\DefaultDBConnection $connection) {
		parent::__construct();
		$connection = ServiceContainer::get(\DefaultDBConnection::class);
		$users = $connection->query("SELECT * FROM user")->fetchAll();
		print_r($users);
	}

	protected function prepare() {
		parent::prepare();
	}

}