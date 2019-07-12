<?php namespace Application\Module\Admin\Action;

use Application\Module\Admin\Service\CodexRegistry;
use Eternity2\WebApplication\Responder\JsonResponder;

class CodexInfo extends JsonResponder{

	protected function respond(){
		$admin = CodexRegistry::Service()->get($this->getPathBag()->get('form'));

		dump($admin->getListDescriptor()->get(1));
		return $admin->getHeader();
	}

}