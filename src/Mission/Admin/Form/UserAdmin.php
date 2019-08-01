<?php namespace Application\Mission\Admin\Form;

use Eternity2\Codex\AdminDescriptor;
use Eternity2\Codex\DataProvider\DataProviderInterface;
use Eternity2\Codex\DataProvider\GhostDataProvider;
use Eternity2\Codex\Dictionary\Dictionary;
use Eternity2\Codex\FormHandler\FormHandler;
use Eternity2\Codex\ItemConverterInterface;
use Eternity2\Codex\ItemDataImporterInterface;
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

	protected $dict = [
		User::F_STATUS => [
			User::STATUS_ACTIVE   => 'aktív',
			User::STATUS_INACTIVE => 'inaktív',
		],
		User::F_ROLES  => [
			User::ROLES_ADMIN => 'admin',
			User::ROLES_SUPER => 'super',
		],
	];

	protected function createDataProvider(): DataProviderInterface{ return new GhostDataProvider(User::class); }

	protected function listHandler(ListHandler $list): ListHandler{
		$list->add(User::F_ID)->visible(false);
		$list->add(User::F_NAME);
		$list->add(User::F_EMAIL);
		$list->add(User::F_ROLES)->visible(false);
		$list->add(User::F_STATUS)->dictionary(new Dictionary($this->dict[User::F_STATUS]));
		$list->add(User::F_ROLES)->dictionary(new Dictionary($this->dict[User::F_ROLES]));
		$list->add('userType', '<i class="fas fa-user"></i>')->clientOnly()->sortable(false);

		$list->addJSPlugin('ListPreprocessUser');
		$list->addJSPlugin('ListButtonAddNew');
		$list->addJSPlugin('ListButtonReload');
		$list->addJSPlugin('ListButtonSearch');

		return $list;
	}

	protected function formHandler(FormHandler $form): FormHandler{

		$form->setLabelField(User::F_NAME);
		$form->addJSPlugin('FormButtonSave');
		$form->addJSPlugin('FormButtonDelete');
		$form->addJSPlugin('FormButtonReload');
		$form->addJSPlugin('FormButtonFiles');
		$form->setItemConverter(new class implements ItemConverterInterface{
			public function convertItem($item): array{
				/** @var User $item */
				$data = $item->export();
				//$data['name'] = strtoupper($data['name']);
				return $data;
			}
		});

		$form->setItemDataImporter(new class implements ItemDataImporterInterface{
			public function importItemData($item, $data){
				/** @var User $item */
				$item->import($data);
				if ($data['newpassword']) $item->password = $data['newpassword'];
				return $item;
			}
		});

		$main = $form->section('Adatok');
		$main->input('string', User::F_NAME);
		$main->input('string', User::F_EMAIL);
		$main->input('string', 'newpassword', 'új jelszó');
		$main->input('radio', User::F_STATUS)
		('options', $this->dict[User::F_STATUS]);
		$main->input('radio', User::F_ROLES)
		('options', $this->dict[User::F_ROLES]);

		return $form;
	}

}
