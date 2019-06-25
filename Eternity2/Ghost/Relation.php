<?php namespace Eternity2\Ghost;


class Relation {

	const TYPE_HASMANY = 'hasMany';
	const TYPE_BELONGSTO = 'belongsTo';

	public $name;
	public $type;
	public $descriptor;

	public function __construct($name, $type, $descriptor) {
		$this->name = $name;
		$this->type = $type;
		$this->descriptor = $descriptor;
	}

	public function get(Ghost $object){
		switch ($this->type){
			case self::TYPE_BELONGSTO:
				$targetGhost = $this->descriptor['ghost'];
				$field = $this->descriptor['field'];
				return $targetGhost::pick($object->$field);
				break;
			case self::TYPE_HASMANY:
//				$targetGhost = $this->descriptor['ghost'];
//				$field = $this->descriptor['field'];
//				return $targetGhost::pick($object->$field);
				break;
		}
		return null;
	}
}