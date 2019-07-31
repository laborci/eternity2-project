<?php namespace Ghost\Helper;

use Eternity2\Attachment\AttachmentCategoryManager;
use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;

/**
 * @method static GhostUserLogFinder search(Filter $filter = null)
 * @property-read $id
 * @property-read \Ghost\User $user
 */
abstract class GhostUserLog extends Ghost{

	/** @var Model */
	public static $model;
	public static $table = "user_log";
	public static $connectionName = "DefaultDBConnection";



	const F_ID = "id";
	const F_DATETIME = "datetime";
	const F_USERID = "userId";
	const F_EVENT = "event";
	const F_DETAILS = "details";

	protected $id;
	public $datetime;
	public $userId;
	public $event;
	public $details;



	final static protected function createModel(): Model{
		$model = new Model(static::$connectionName, static::$table, get_called_class());
		$model->addField("id", Field::TYPE_ID);
		$model->addField("datetime", Field::TYPE_DATETIME);
		$model->addField("userId", Field::TYPE_ID);
		$model->addField("event", Field::TYPE_STRING);
		$model->addField("details", Field::TYPE_STRING);
		$model->protectField("id");
		return $model;
	}
}

/**
 * Nobody uses this class, it exists only to help the code completion
 * @method \Ghost\UserLog[] collect($limit = null, $offset = null)
 * @method \Ghost\UserLog[] collectPage($pageSize, $page, &$count = 0)
 * @method \Ghost\UserLog pick()
 */
abstract class GhostUserLogFinder extends \Eternity2\DBAccess\Finder\AbstractFinder {}