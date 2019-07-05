<?php namespace Ghost\Helper;

use Eternity2\Attachment\AttachmentCategoryManager;
use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Ghost\Field;
use Eternity2\Ghost\Ghost;
use Eternity2\Ghost\Model;

/**
 * @method static GhostArticleFinder search(Filter $filter = null)
 * @property-read $id
 */
abstract class GhostArticle extends Ghost{
	
	/** @var Model */
	public static $model;
	public static $table = "article";
	public static $connectionName = "DefaultDBConnection";
	
	const SETFIELD_ALFA = "alfa";
	const SETFIELD_BETA = "beta";
	const SETFIELD_GAMMA = "gamma";
	const E_ALBERT = "albert";
	const E_BERTHA = "bertha";
	const E_CECIL = "cecil";

	protected $id;
	public $title;
	public $body;
	public $authorId;
	public $setfield;
	public $e;



	final static protected function createModel(): Model{
		$model = new Model(static::$connectionName, static::$table, get_called_class());
		$model->addField("id", Field::TYPE_ID);
		$model->addField("title", Field::TYPE_STRING);
		$model->addField("body", Field::TYPE_STRING);
		$model->addField("authorId", Field::TYPE_ID);
		$model->addField("setfield", Field::TYPE_SET);
		$model->addField("e", Field::TYPE_ENUM);
		$model->protectField("id");
		return $model;
	}
}

/**
 * Nobody uses this class, it exists only to help the code completion
 * @method \Ghost\Article[] collect($limit = null, $offset = null)
 * @method \Ghost\Article[] collectPage($pageSize, $page, &$count = 0)
 * @method \Ghost\Article pick()
 */
abstract class GhostArticleFinder extends \Eternity2\DBAccess\Finder\AbstractFinder {}