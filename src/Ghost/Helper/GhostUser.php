<?php namespace Ghost\Helper;

use Eternity2\Attachment\AttachmentCategoryManager;
use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;

/**
 * @method static GhostUserFinder search(Filter $filter = null)
 * @property-read $id
 * @property-read AttachmentCategoryManager $avatar
 * @property-read AttachmentCategoryManager $gallery
 * @property-read \Ghost\User $boss
 * @property-read \Ghost\User[] $workers
 * @method \Ghost\User[] workers($order = null, $limit = null, $offset = null)
 */
abstract class GhostUser extends Ghost{

	/** @var Model */
	public static $model;
	public static $table = "user";
	public static $connectionName = "DefaultDBConnection";

	const PERMISSIONS_ADMIN = "admin";
	const PERMISSIONS_SUPER = "super";
	const STATUS_ACTIVE = "active";
	const STATUS_INACTIVE = "inactive";

	protected $id;
	public $name;
	public $email;
	public $password;
	public $permissions;
	public $status;



	final static protected function createModel(): Model{
		$model = new Model(static::$connectionName, static::$table, get_called_class());
		$model->addField("id", Field::TYPE_ID);
		$model->addField("name", Field::TYPE_STRING);
		$model->addField("email", Field::TYPE_STRING);
		$model->addField("password", Field::TYPE_STRING);
		$model->addField("permissions", Field::TYPE_SET);
		$model->addField("status", Field::TYPE_ENUM);
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