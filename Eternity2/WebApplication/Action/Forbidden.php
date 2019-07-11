<?php namespace Eternity2\WebApplication\Action;

use Eternity2\WebApplication\Responder\PageResponder;

class Forbidden extends PageResponder {

	protected function respond() {
		$this->getResponse()->setStatusCode(403);
	}
	
}