<?php namespace Application\HTTP\Admin\Action;


use Application\Service\Auth\ScheduleBridge;
use Entity\Classroom\Classroom;
use Entity\Reservation\Reservation;
use Eternity\Response\Responder\JsonResponder;
use MikAuthEternity\Interfaces\MikUserApiServiceInterface;
use RedFox\Database\Filter\Filter;

class GetConflicts extends JsonResponder {

	protected $scheduleBridge;
	protected $mikUserApiService;

	public function __construct(ScheduleBridge $scheduleBridge, MikUserApiServiceInterface $mikUserApiService) {
		$this->scheduleBridge = $scheduleBridge;
		$this->mikUserApiService = $mikUserApiService;
	}

	protected function respond() {
		$conflicts = [];

		$futureReservations = Reservation::repository()->search(Filter::where('`date`>=Curdate()'))->asc('date')->collect();
		foreach ($futureReservations as $futureReservation) {
			$room = Classroom::repository()->pick($futureReservation->classroomId);
			if ($this->scheduleBridge->checkAvailability($room, $futureReservation->date->format('Y-m-d'), $futureReservation->block, $futureReservation->length) === false) {
				$dto = $futureReservation->getDTO();
				$dto['user'] = $this->mikUserApiService->getUser($dto['userId']);
				$dto['from'] = str_pad(floor($dto['block'] / 4),2,0, STR_PAD_LEFT) . ':' . str_pad((15*($dto['block']%4)),2,0, STR_PAD_LEFT);
				$dto['to'] = str_pad(floor(($dto['block'] + $dto['length']) / 4),2,0, STR_PAD_LEFT) . ':' . str_pad((15*(($dto['block'] + $dto['length'])%4)),2,0, STR_PAD_LEFT);
				$dto['classroom'] = $room->name;
				$conflicts[] = $dto;
			}
		}

		return ['conflicts' => $conflicts];
	}

}