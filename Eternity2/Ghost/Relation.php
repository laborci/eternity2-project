<?php namespace Eternity2\Ghost;


use Eternity2\DBAccess\Filter\Filter;
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

	public function get(Ghost $object, $order=null, $limit=null, $offset = null){
		switch ($this->type){
			case self::TYPE_BELONGSTO:
				$targetGhost = $this->descriptor['ghost'];
				$field = $this->descriptor['field'];
				return $targetGhost::pick($object->$field);
				break;
			case self::TYPE_HASMANY:
				$targetGhost = $this->descriptor['ghost'];
				$field = $this->descriptor['field'];
				/** @var \Eternity2\Ghost\Repository $repository */
				$repository = $targetGhost::$model->repository;
				return $repository->search(Filter::where($field.'=$1', $object->id))->orderIf(!is_null($order), $order)->collect($limit, intval($offset));
				break;
		}
		return null;
	}
}