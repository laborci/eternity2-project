<?php namespace Eternity2\WebApplication\Action;

use Eternity2\WebApplication\Responder\PageResponder;

class NotAuthorized extends PageResponder {

	protected function respond() {
		$this->getResponse()->setStatusCode(401);
	}

}