<?php namespace Application\Mission\Web\Page;

use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\Mission\Web\Responder\SmartPageResponder;

/**
 * @template "@web/Index.twig"
 * @title "Index"
 * @bodyclass "mypage"
 * @js "/web/js/app.js"
 * @css "/web/css/style.css"
 */
class Index extends SmartPageResponder {

	protected $connection;

//	public function __construct(\DefaultDBConnection $connection) {
//		parent::__construct();
//		$this->connection = $connection;
//	}

	protected function prepare() {
		parent::prepare();

//		$connection = ServiceContainer::get(\DefaultDBConnection::class);
//		$users = $this->connection->query("SELECT * FROM user")->fetchAll();
//		$this->getDataBag()->set('users', $users);
	}

}