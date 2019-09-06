<?php namespace Application\Mission\Web\Action;


use Eternity2\Mission\Web\Responder\JsonResponder;

class ArticlesCodexInfo extends JsonResponder {

	protected function respond() {
		return [
			'icon'=>'fas fa-user',
			'title'=>'Cikkek',
		];
	}

}