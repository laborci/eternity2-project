<?php namespace Application\Module\Admin\Form;

use Application\Module\Admin\Service\CodexDataProvider;
use Application\Module\Admin\Service\CodexDescriptor;
use Application\Module\Admin\Service\CodexGhostDataProvider;
use Application\Module\Admin\Service\CodexList;
use Application\Module\Admin\Service\CodexListingResult;
use Eternity2\Ghost\Ghost;
use Ghost\User;

class UserAdmin extends CodexDescriptor{

	protected $permission = 'admin';
	protected $headerIcon = 'fal fa-user';
	protected $headerTitle = 'Felhasználók';
	protected $fields = [
		User::F_NAME  => 'név',
		User::F_EMAIL => 'e-mail',
		User::F_ROLES => 'szerepkörök',
	];

	protected function createDataProvider(): CodexDataProvider{ return new CodexGhostDataProvider(User::class); }

	protected function listDescriptor(CodexList $list): CodexList{
		$list->add(User::F_NAME);
		$list->add(User::F_EMAIL);
		$list->add(User::F_ROLES);

		$list->setRowConverter(new class() implements CodexItemConverterInterface{
			public function convert(Ghost $item):array{
				$row = $item->decompose();
				$row['email'] = strtoupper($row['email']);
				return $row;
			}
		});

//		$list->setRowConverter(function (Ghost $row){
//			$row = $row->decompose();
//			$row['email'] = strtoupper($row['email']);
//			return $row;
//		});
		return $list;
	}

}