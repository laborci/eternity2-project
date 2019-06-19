<?php namespace Application\HTTP\Admin\Form;

use Codex\AdminDescriptor;
use Codex\FormDataManager;
use Codex\FormHandler;
use Codex\ListHandler;
use Codex\Validation\StringLengthValidator;
use Entity\ReservationPeriod\ReservationPeriod;
use Entity\Schedule\Schedule;
use Entity\User\User;
use RedFox\Entity\Entity;

class ReservationPeriodAdminDescriptor extends AdminDescriptor {

	protected static function setOptions(&$url, &$entityClass, &$title, &$titleField, &$icon, &$attachments) {
		$url = '/admin/reservation-period/';
		$entityClass = ReservationPeriod::class;
		$title = 'Foglalási időszak';
		$titleField = 'name';
		$icon = 'fas fa-calendar';
		$attachments = true;
	}

	public function setFields(FormDataManager $formDataManager) {
		$formDataManager->addField('name', 'name')->addValidator(new StringLengthValidator(5));
		$formDataManager->addField('start', 'kezdő dátum');
		$formDataManager->addField('end', 'befejező dátum');
		$formDataManager->addField('activeFrom', 'érvényesség kezdete');
		$formDataManager->addField('activeTo', 'érvényesség vége');
	}

	public function decorateListHandler(ListHandler $listHandler) {
		$listHandler->addField('name');
		$listHandler->addField('start');
	}

	public function decorateFormHandler(FormHandler $formHandler) {
		$sect = $formHandler->addSection();
		$sect->input('text', 'name');
		$sect->input('date', 'start');
		$sect->input('date', 'end');
		$sect->input('date', 'activeFrom');
		$sect->input('date', 'activeTo');

	}

}
