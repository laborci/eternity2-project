<?php namespace Eternity2\RedFox\Relation;

use RedFox\Database\Filter\Filter;
use Redfox\Entity\Entity;

class BackReference {

	protected $class;
	protected $field;

	public function __construct(string $class, string $field) {
		$this->class = $class;
		$this->field = $field;
	}

	public function __invoke(Entity $object, $order=null, $limit=null, $offset = 0):array{
		$class = $this->class;
		$field = $this->field;
		/** @var \Eternity2\RedFox\Repository $repository */
		$repository = $class::repository();
		return $repository->search(Filter::where($field.'=$1', $object->id))->orderIf(!is_null($order), $order)->collect($limit, $offset);
	}


	public function getRelatedClass(): string {
		return '\\'.$this->class.'[]';
	}
}