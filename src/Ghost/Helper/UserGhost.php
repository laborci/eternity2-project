<?php namespace Application\Ghost\Helper;

use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;
use Eternity2\System\ServiceManager\ServiceContainer;


/**
 * @property-read mixed id
 */

class UserGhost extends Ghost{

	protected $id;
	public $name;
	public $birthday;
	public $regdate;
	public $status;
	public $data;

	static protected function createModel(string $connection, string $table){
		$model = new Model(ServiceContainer::get($connection), $table, get_called_class());
		$model->addField('id', Field::TYPE_ID);
		$model->addField('name', Field::TYPE_STRING);
		$model->addField('birthday', Field::TYPE_DATE);
		$model->addField('regdate', Field::TYPE_DATETIME);
		$model->addField('status', Field::TYPE_BOOl);
		$model->addField('data', Field::TYPE_JSON);
		$model->protectField('id');
		return $model;
	}

}