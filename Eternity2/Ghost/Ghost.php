<?php namespace Eternity2\Ghost;


abstract class Ghost {

	/** @var Model */
	public static $model = null;

	static public function initialize(string $connection, string $table) {
		if (static::$model !== null) return;
		$model = static::createModel($connection, $table);
		static::$model = $model;

	}

	static public function pick($id) { return self::$model->repository->pick($id); }
	abstract static protected function createModel(string $connection, string $table);

	public function __get(string $name) {
		$field = array_key_exists($name, self::$model->fields) ? self::$model->fields[$name] : null;
		if ($field) {
			if ($field->getter === null) {
				return $this->$name;
			} else {
				$getter = $field->getter;
				return $this->$getter();
			}
		}
		return null;
	}

	public function __set($name, $value) {
		$field = array_key_exists($name, self::$model->fields) ? self::$model->fields[$name] : null;
		if ($field && $field->setter !== false) {
			$setter = $field->setter;
			echo '***' . $name;
			$this->$setter($value);
			return;
		}
	}


	public function save() { }

	public function record($record = null) {
		if ($record === null) {
			$record = [];
			foreach (static::$model->fields as $fieldName => $field) {
				$record[$fieldName] = $field->writeRecord($this->$fieldName);
			}
			return $record;
		} else {
			foreach (static::$model->fields as $fieldName => $field) {
				if (array_key_exists($fieldName, $record)) {
					$this->$fieldName = $field->readRecord($record[$fieldName]);
				}
			}
		}
		return null;
	}


}