<?php namespace Application\HTTP\Admin\Form;

use Codex\AdminDescriptor;
use Codex\FormDataManager;
use Codex\FormHandler;
use Codex\ListHandler;
use Codex\Validation\StringLengthValidator;
use Entity\Classroom\Classroom;
use Entity\ClassroomRule\ClassroomRule;

class ClassroomRuleAdminDescriptor extends AdminDescriptor {

	protected static function setOptions(&$url, &$entityClass, &$title, &$titleField, &$icon, &$attachments) {
		$url = '/admin/classroomrule/';
		$entityClass = ClassroomRule::class;
		$title = 'TeremSzabályok';
		$titleField = 'name';
		$icon = 'fas fa-hand-middle-finger';
		$attachments = false;
	}

	public function setFields(FormDataManager $formDataManager) {
		$formDataManager->addField('name', 'megnevezés')->addValidator(new StringLengthValidator(3));
		$formDataManager->addField('roompattern', 'Terem');
		$formDataManager->addField('rules', 'szabály');
		$formDataManager->addField('activeFrom', 'érvényesség kezdete');
		$formDataManager->addField('activeTo', 'érvényesség vége');
	}

	public function decorateListHandler(ListHandler $listHandler) {
		$listHandler->addField('name');
		$listHandler->addField('roompattern');
		$listHandler->addField('activeFrom');
		$listHandler->addField('activeTo');
	}

	public function decorateFormHandler(FormHandler $formHandler) {
		$sect = $formHandler->addSection();
		$sect->input('text', 'name');
		$sect->input('text', 'roompattern');
		$sect->input('rule-editor', 'rules');
		$sect->input('date', 'activeFrom');
		$sect->input('date', 'activeTo');
	}
}
