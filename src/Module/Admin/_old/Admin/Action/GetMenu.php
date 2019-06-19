<?php namespace Application\HTTP\Admin\Action;

use Application\Config;
use Application\HTTP\Admin\Form as Form;

class GetMenu extends \Codex\Responder\Menu {
	protected function createMenu() {
		$this->addMenu()
			->addList(...Form\UserFormDescriptor::getMenuArguments())
			->addList(...Form\ScheduleFormDescriptor::getMenuArguments())
			->addList(...Form\ClassroomAdminDescriptor::getMenuArguments())
			->addList(...Form\ClassroomRuleAdminDescriptor::getMenuArguments())
			->addList(...Form\ReservationPeriodAdminDescriptor::getMenuArguments())
			->addItem('Ütközések', 'fas fa-angry', 'modal', ['title'=>'Ütközések', 'contentTag'=>'px-classroom-conflicts'])
		;

	}
}
