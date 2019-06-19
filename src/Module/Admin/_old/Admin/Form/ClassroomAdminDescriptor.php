<?php namespace Application\HTTP\Admin\Form;

use Codex\AdminDescriptor;
use Codex\FormDataManager;
use Codex\FormHandler;
use Codex\ListHandler;
use Codex\Validation\StringLengthValidator;
use Entity\Classroom\Classroom;

class ClassroomAdminDescriptor extends AdminDescriptor {

	protected static function setOptions(&$url, &$entityClass, &$title, &$titleField, &$icon, &$attachments) {
		$url = '/admin/classroom/';
		$entityClass = Classroom::class;
		$title = 'Terem';
		$titleField = 'name';
		$icon = 'fas fa-users-class';
		$attachments = false;
	}

	public function setFields(FormDataManager $formDataManager) {
		$formDataManager->addField('name', 'szám')->addValidator(new StringLengthValidator(3));
		$formDataManager->addField('site', 'beszédes név');
		$formDataManager->addField('place', 'épület');
		$formDataManager->addField('description', 'leírás');
		$formDataManager->addField('capacity', 'kapacitás');
		$formDataManager->addField('whiteboard', 'tábla');
		$formDataManager->addField('projector', 'projektor');
		$formDataManager->addField('computers', 'számítógépek');
		$formDataManager->addField('loudspeakers', 'hangszóró');
		$formDataManager->addField('microphone', 'mikrofon');
		$formDataManager->addField('restricted', 'korlátozott hozzáférés');
		$formDataManager->addField('status', 'státusz');
		$formDataManager->addField('groups', 'felhasználó csoportok');
	}

	public function decorateListHandler(ListHandler $listHandler) {
		$listHandler->addField('name');
		$listHandler->addField('site');
	}

	public function decorateFormHandler(FormHandler $formHandler) {

		$sect = $formHandler->addSection('Adatok');

		$sect->input('text', 'name');
		$sect->input('text', 'site');
		$sect->input('text', 'place');
		$sect->input('checkbox', 'restricted');
		$sect->input('textarea', 'groups');
		$sect->input('select', 'status')
		('options', [
			['key' => 'active', 'value' => 'Aktív'],
			['key' => 'inactive', 'value' => 'Törölt'],
		]);

		$sect = $formHandler->addSection('Tulajdonságok');
		$sect->input('number', 'capacity');

		$sect->input('checkbox', 'whiteboard');
		$sect->input('checkbox', 'projector');
		$sect->input('checkbox', 'computers');
		$sect->input('checkbox', 'loudspeakers');
		$sect->input('checkbox', 'microphone');
		$sect->input('textarea', 'description');

	}
}
