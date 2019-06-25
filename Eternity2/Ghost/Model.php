<?php

namespace Eternity2\Ghost;

use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;

class Model {

	/** @var AbstractPDOConnection */
	public $connection;
	public $table;
	/** @var Field[] */
	public $fields = [];
	/** @var Relation[] */
	public $relations = [];
	public $ghost;
	/** @var Repository */
	public $repository;

	public function __construct($connection, $table, $ghost) {
		$this->connection = $connection;
		$this->table = $table;
		$this->ghost = $ghost;
		$this->repository = new Repository($ghost, $this);
	}

	/**
	 * @param string $field
	 * @param null|bool|string $getter false: no getter; null: passThrough; true: get'Field'() method; string: your method name
	 * @param bool|string $setter false: no setter; true: set'Field'() method; string: your method name
	 */
	public function protectField($field, $getter = null, $setter = false) {
		if ($getter === true) $getter = 'get' . ucfirst($field);
		if ($setter === true || $setter === null) $setter = 'set' . ucfirst($field);
		$this->fields[$field]->protect($getter, $setter);
	}

	public function hasMany($target, $ghost, $field): Relation {
		return $this->relations[$target] = new Relation($target, Relation::TYPE_HASMANY, ['ghost' => $ghost, 'field' => $field]);
	}

	public function belongsTo($target, $ghost, $field=null): Relation {
		if($field === null) $field = $target.'Id';
		return $this->relations[$target] = new Relation($target, Relation::TYPE_BELONGSTO, ['ghost' => $ghost, 'field' => $field]);
	}

	public function hasAttachment() { return null; }

	public function addField($name, $type): Field {
		return $this->fields[$name] = new Field($name, $type);
	}

}