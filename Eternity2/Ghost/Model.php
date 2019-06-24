<?php

namespace Eternity2\Ghost;

use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;

class Model {

	/** @var AbstractPDOConnection */
	public $connection;
	public $table;
	/** @var Field[] */
	public $fields = [];
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
	 * @param $field
	 * @param $getter false: no getter; null: passThrough; true: get'Field'() method; string: your method name
	 * @param $setter false: no setter; true: set'Field'() method; string: your method name
	 */
	public function protectField($field, $getter=null, $setter = false){
		if($getter === true) $getter = 'get'.ucfirst($field);
		if($setter === true || $setter === null) $setter = 'set'.ucfirst($field);
		$this->fields[$field]->protect($getter, $setter);
	}
	public function hasMany(){return null;}
	public function belongsTo(){ return null; }
	public function hasAttachment(){return null;}

	public function addField($name, $type){
		$this->fields[$name] = new Field($name, $type);
	}


}