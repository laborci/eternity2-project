<?php namespace Ghost\Helper;

use Eternity2\Attachment\AttachmentCategoryManager;
use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;

/**
 * @method static GhostUserFinder search(Filter $filter = null)
 * @property-read $id
 * @property-write $password
 * @property-read AttachmentCategoryManager $avatar
 * @property-read AttachmentCategoryManager $gallery
 */
abstract class GhostUser extends Ghost{

	/** @var Model */
	public static $model;
	public static $table = "user";
	public static $connectionName = "DefaultDBConnection";



	const F_ID = "id";
	const F_NAME = "name";
	const F_BIRTHDAY = "birthday";
	const F_REGDATE = "regdate";
	const F_STATUS = "status";
	const F_DATA = "data";
	const F_BOSSID = "bossId";

	protected $id;
	public $name;
	public $email;
	protected $password;
	public $roles;
	public $status;

	abstract protected function setPassword($value);

	final static protected function createModel(): Model{
		$model = new Model(static::$connectionName, static::$table, get_called_class());
		$model->addField("id", Field::TYPE_ID);
		$model->addField("name", Field::TYPE_STRING);
		$model->addField("birthday", Field::TYPE_DATE);
		$model->addField("regdate", Field::TYPE_DATETIME);
		$model->addField("status", Field::TYPE_BOOL);
		$model->addField("data", Field::TYPE_JSON);
		$model->addField("bossId", Field::TYPE_ID);
		$model->protectField("id");
		return $model;
	}
}

/**
 * Nobody uses this class, it exists only to help the code completion
 * @method \Ghost\User[] collect($limit = null, $offset = null)
 * @method \Ghost\User[] collectPage($pageSize, $page, &$count = 0)
 * @method \Ghost\User pick()
 */
abstract class GhostUserFinder extends \Eternity2\DBAccess\Finder\AbstractFinder {}