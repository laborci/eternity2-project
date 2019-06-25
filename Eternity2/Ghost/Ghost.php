<?php namespace Eternity2\Ghost;

/**
 * @property-read int id
 */
abstract class Ghost implements \JsonSerializable {

	use GhostRepositoryFacadeTrait;

	/** @var Model */
	public static $model;
	private $deleted;
	protected $id;

	static public function model(string $connection, string $table) {
		if (static::$model === null) {
			$model = static::createModel($connection, $table);
			static::$model = $model;
		}
	}

	abstract static protected function createModel(string $connection, string $table):Model;

	public function __get(string $name) {
		$field = array_key_exists($name, static::$model->fields) ? static::$model->fields[$name] : null;
		if ($field) {
			if ($field->getter === null) {
				return $this->$name;
			} else {
				$getter = $field->getter;
				return $this->$getter();
			}
		}
		$relation = array_key_exists($name, static::$model->relations) ? static::$model->relations[$name] : null;
		if($relation){
			return $relation->get($this);
		}
		return null;
	}

	public function __set($name, $value) {
		$field = array_key_exists($name, static::$model->fields) ? static::$model->fields[$name] : null;
		if ($field && $field->setter !== false) {
			$setter = $field->setter;
			$this->$setter($value);
			return;
		}
	}

	public function record($record = null) {
		if ($record === null) {
			$record = [];
			foreach (static::$model->fields as $fieldName => $field) {
				$record[$fieldName] = $field->decompose($this->$fieldName);
			}
			return $record;
		} else {
			foreach (static::$model->fields as $fieldName => $field) {
				if (array_key_exists($fieldName, $record)) {
					$this->$fieldName = $field->compose($record[$fieldName]);
				}
			}
		}
		return null;
	}

	public function jsonSerialize() {
		$record = [];
		foreach (static::$model->fields as $fieldName => $field) {
			$record[$fieldName] = $field->export($this->$fieldName);
		}
		return $record;
	}


	public function isExists(): bool { return (bool)$this->id; }
	public function isDeleted(): bool { return $this->deleted; }
	function __toString() { return get_called_class().' '.$this->id; }

	const EVENT___BEFORE_DELETE = 1;
	const EVENT___AFTER_DELETE = 2;
	const EVENT___BEFORE_UPDATE = 3;
	const EVENT___AFTER_UPDATE = 4;
	const EVENT___BEFORE_INSERT = 5;
	const EVENT___AFTER_INSERT = 6;
	protected function on($event, $data=null){return true;}

	public function delete() {
		if ($this->isExists()) {
			if ($this->on(self::EVENT___BEFORE_DELETE) === false) return false;
			static::$model->repository->delete($this);
			$this->deleted = true;
			$this->on(self::EVENT___AFTER_DELETE);
		}
		return true;
	}

	public function save() {
		if ($this->deleted) $this->record->set('id', null);
		if ($this->isExists()) {
			return $this->update();
		} else {
			return $this->insert();
		}
	}

	private function update() {
		if ($this->on(self::EVENT___BEFORE_UPDATE) === false) return false;
		static::$model->repository->update($this);
		$this->on(self::EVENT___AFTER_UPDATE);
		return true;
	}

	private function insert() {
		if ($this->on(self::EVENT___BEFORE_INSERT) === false) return false;
		$this->id = static::$model->repository->insert($this);
		$this->on(self::EVENT___AFTER_INSERT);
		return $this->id;
	}
}