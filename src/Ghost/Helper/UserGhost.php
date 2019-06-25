<?php namespace Ghost\Helper;

use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;
use Eternity2\System\ServiceManager\ServiceContainer;
use Ghost\User;

/**
 * @property-read int    id
 * @property-read User   boss
 * @property-read User[] workers
 * @method static UserFinder search(Filter $filter = null)
 */
class UserGhost extends Ghost{
	protected $id;
	public $name;
	public $birthday;
	public $regdate;
	public $status;
	public $data;
	public $bossId;

	static protected function createModel(string $connection, string $table): Model{
		$model = new Model(ServiceContainer::get($connection), $table, get_called_class());
		$model->addField('id', Field::TYPE_ID);
		$model->addField('name', Field::TYPE_STRING);
		$model->addField('birthday', Field::TYPE_DATE);
		$model->addField('regdate', Field::TYPE_DATETIME);
		$model->addField('status', Field::TYPE_BOOl);
		$model->addField('data', Field::TYPE_JSON);
		$model->addField('bossId', Field::TYPE_ID);
		$model->protectField('id');
		return $model;
	}
}

/**
 * Nobody uses this class, it exists only to help the code completion
 * @method \Ghost\User[] collect($limit = null, $offset = null)
 * @method \Ghost\User[] collectPage($pageSize, $page, &$count = 0)
 * @method \Ghost\User pick()
 */
abstract class UserFinder extends \Eternity2\DBAccess\Finder\AbstractFinder {}