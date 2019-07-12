<?php namespace Application\Module\Admin\Form;

use Application\Module\Admin\Service\CodexDataProvider;
use Application\Module\Admin\Service\CodexDescriptor;
use Application\Module\Admin\Service\CodexGhostDataProvider;
use Application\Module\Admin\Service\CodexList;
use Ghost\User;

class UserAdmin extends CodexDescriptor{

	protected $permission = 'admin';
	protected $headerIcon = 'fal fa-user';
	protected $headerTitle = 'Felhasználók';
	protected $fields = [
		User::F_NAME  => 'név',
		User::F_EMAIL => 'e-mail',
	];

	protected function createDataProvider():CodexDataProvider{ return new CodexGhostDataProvider(User::class); }

	protected function listDescriptor(CodexList $list): CodexList{
		$list->add(User::F_NAME);
		$list->add(User::F_EMAIL);
		return $list;
	}

}