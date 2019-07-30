<?php namespace Application\HTTP\Admin\Form;

use Codex\AdminDescriptor;
use Codex\FormDataManager;
use Codex\FormHandler;
use Codex\ListHandler;
use Codex\Validation\StringLengthValidator;
use Entity\Schedule\Schedule;
use Entity\User\User;
use RedFox\Entity\Entity;

class ScheduleFormDescriptor extends AdminDescriptor {

	protected static function setOptions(&$url, &$entityClass, &$title, &$titleField, &$icon, &$attachments) {
		$url = '/admin/schedule/';
		$entityClass = Schedule::class;
		$title = 'Órarend';
		$titleField = 'name';
		$icon = 'fas fa-clipboard-list';
		$attachments = true;
	}

	public function setFields(FormDataManager $formDataManager) {
		$formDataManager->addField('name', 'name')->addValidator(new StringLengthValidator(5));
		$formDataManager->addField('start', 'kezdő dátum');
		$formDataManager->addField('status', 'státusz');
	}

	public function decorateListHandler(ListHandler $listHandler) {
		$listHandler->addField('name');
		$listHandler->addField('start');
		$listHandler->addField('status');
	}

	public function decorateFormHandler(FormHandler $formHandler) {
		$sect = $formHandler->addSection();
		$sect->input('text', 'name');
		$sect->input('date', 'start');
		$sect->input('select', 'status')
		('options', [
			['key' => 'active', 'value' => 'Aktív'],
			['key' => 'inactive', 'value' => 'Törölt'],
		]);

	}

}
