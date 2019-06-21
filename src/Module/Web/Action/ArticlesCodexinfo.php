<?php namespace Application\Module\Web\Action;


use Eternity2\WebApplication\Responder\JsonResponder;

class ArticlesCodexInfo extends JsonResponder {

	protected function respond() {
		return [
			'icon'=>'fas fa-user',
			'title'=>'Cikkek',
		];
	}

}