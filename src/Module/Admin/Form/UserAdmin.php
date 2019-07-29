<?php namespace Application\Module\Admin\Form;

use Eternity2\Codex\AdminDescriptor;
use Eternity2\Codex\DataProvider\DataProviderInterface;
use Eternity2\Codex\FormHandler\FormHandler;
use Eternity2\Codex\DataProvider\GhostDataProvider;
use Eternity2\Codex\ListHandler\ListHandler;
use Ghost\User;

class UserAdmin extends AdminDescriptor{

	protected $permission = 'admin';

	protected $headerIcon = 'fal fa-user';
	protected $headerTitle = 'Felhasználók';
	protected $formIcon = 'fal fa-user';
	protected $tabIcon = 'fas fa-user';
	protected $fields = [
		User::F_ID    => 'id',
		User::F_NAME  => 'név',
		User::F_EMAIL => 'e-mail',
		User::F_ROLES => 'szerepkörök',
	];

	protected function createDataProvider(): DataProviderInterface{ return new GhostDataProvider(User::class); }

	protected function listHandler(ListHandler $list): ListHandler{

		$list->add(User::F_ID)->visible(false);
		$list->add(User::F_NAME);
		$list->add(User::F_EMAIL);
		$list->add(User::F_ROLES)->visible(false);
		$list->add(User::F_STATUS)->visible(false);
		$list->add('userType', '<i class="fas fa-user"></i>')->clientOnly()->sortable(false);

		$list->addJSPlugin('UserListPreprocess2');
		return $list;
	}

	protected function formHandler(FormHandler $form): FormHandler{

		$form->setLabelField(User::F_NAME);

		$main = $form->section('main');
		$main->input('text', User::F_NAME)
		('rows', 10);
		$main->input('checkboxes', User::F_STATUS)
		('options', [
			User::STATUS_ACTIVE   => 'aktív',
			User::STATUS_INACTIVE => 'inaktív',
		]);

		return $form;
	}

}