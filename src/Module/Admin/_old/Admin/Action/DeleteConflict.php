<?php namespace Application\HTTP\Admin\Action;


use Application\Service\ScheduleBridge;
use Entity\Classroom\Classroom;
use Entity\Reservation\Reservation;
use Eternity\Response\Responder\JsonResponder;
use MikAuthEternity\Interfaces\MikUserApiServiceInterface;
use RedFox\Database\Filter\Filter;

class DeleteConflict extends JsonResponder {


	protected function respond() {
		$reservation = Reservation::repository()->pick($this->getPathBag()->get('id'));
		if($reservation)$reservation->delete();
		return [];
	}

}