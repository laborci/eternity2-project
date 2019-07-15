<?php namespace Application\Module\Admin\Form;

use Eternity2\Codex\AdminDescriptor;
use Eternity2\Codex\DataProviderInterface;
use Eternity2\Codex\GhostDataProvider;
use Eternity2\Codex\ListHandler;
use Ghost\User;

class UserAdmin extends AdminDescriptor{

	protected $permission = 'admin';

	protected $headerIcon = 'fal fa-user';
	protected $headerTitle = 'Felhasználók';
	protected $fields = [
		User::F_ID    => 'id',
		User::F_NAME  => 'név',
		User::F_EMAIL => 'e-mail',
		User::F_ROLES => 'szerepkörök',
	];

	protected function createDataProvider(): DataProviderInterface{ return new GhostDataProvider(User::class); }

	protected function listDescriptor(ListHandler $list): ListHandler{

		$list->add(User::F_ID)->visible(false);
		$list->add(User::F_NAME);
		$list->add(User::F_EMAIL);
		$list->add(User::F_ROLES);
		return $list;

	}

}