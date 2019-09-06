<?php namespace Application\Mission\Web\Action;


use Eternity2\Mission\Web\Responder\JsonResponder;

class UsersCodexinfo extends JsonResponder {

	protected function respond() {
		return [
			'icon'=>'fas fa-user',
			'title'=>'Felhasználók'
		];
	}

}