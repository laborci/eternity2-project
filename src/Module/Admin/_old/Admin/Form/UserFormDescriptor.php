<?php namespace Application\HTTP\Admin\Form;

use Codex\AdminDescriptor;
use Codex\FormDataManager;
use Codex\FormHandler;
use Codex\ListHandler;
use Codex\Validation\StringLengthValidator;
use Entity\User\User;
use RedFox\Entity\Entity;

class UserFormDescriptor extends AdminDescriptor {

	protected static function setOptions(&$url, &$entityClass, &$title, &$titleField, &$icon, &$attachments) {
		$url = '/admin/user/';
		$entityClass = User::class;
		$title = 'Felhasználó';
		$titleField = 'name';
		$icon = 'fas fa-user';
		$attachments = true;
	}

	public function setFields(FormDataManager $formDataManager) {
		$formDataManager->addField('name', 'name')->addValidator(new StringLengthValidator(5));
		$formDataManager->addField('email', 'e-mail');
		$formDataManager->addField('password', 'jelszó');
		$formDataManager->addField('status', 'Státusz');
		$formDataManager->addField('permissions', 'jogosultságok');
		$formDataManager->addField('login', 'eha/neptun login');
	}

	public function decorateListHandler(ListHandler $listHandler) {
		$listHandler->addField('name');
		$listHandler->addField('email');
		$listHandler->addField('status');
	}

	public function decorateFormHandler(FormHandler $formHandler) {
		$sect = $formHandler->addSection();
		$sect->input('text', 'email');
		$sect->input('text', 'name');
		$sect->input('text', 'login');
		$sect->input('password', 'password');

		$sect = $formHandler->addSection();
		$sect->input('select', 'status')
		('options', [
			['key' => 'active', 'value' => 'Aktív'],
			['key' => 'deleted', 'value' => 'Törölt'],
		]);
		$sect->input('checkboxes', 'permissions')
		('options', [
			['key' => 'admin', 'value' => 'Admin'],
			['key' => 'super', 'value' => 'Super'],
		]);
	}

	public function createFormDataManager(): FormDataManager {
		return new class($this) extends FormDataManager {
			protected function pack(Entity $item, $data) {
				if (is_null($data['password'])) unset($data['password']);
				parent::pack($item, $data);
			}
		};
	}

}
