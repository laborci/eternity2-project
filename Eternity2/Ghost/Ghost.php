<?php namespace Eternity2\Ghost;

use Eternity2\Attachment\AttachmentOwnerInterface;
use Eternity2\System\ServiceManager\ServiceContainer;
use JsonSerializable;

/**
 * @property-read int id
 */
abstract class Ghost implements JsonSerializable, AttachmentOwnerInterface {

	use GhostRepositoryFacadeTrait;
	use GhostAttachmentTrait;

	private $deleted;
	protected $id;

	final public function isExists(): bool { return (bool)$this->id; }
	final public function isDeleted(): bool { return $this->deleted; }
	function __toString() { return get_called_class() . ' ' . $this->id; }

#region Model Creation

	/** @var Model */
	public static $model;

	static final public function model(string $table, string $connection = null) {
		if (static::$model === null) {
			if ($connection === null) {
				/** @var Config $config */
				$config = ServiceContainer::get(Config::class);
				$connection = $config->defaultDatabase();
			}
			$model = static::createModel($connection, $table);
			static::$model = $model;
		}
	}

	abstract static protected function createModel(string $connection, string $table): Model;

#endregion

#region Magic Methods

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
		if ($relation) {
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

	public function __call(string $name, $arguments) {
		$relation = array_key_exists($name, static::$model->relations) ? static::$model->relations[$name] : null;
		if ($relation && $relation->type === Relation::TYPE_HASMANY) {
			list($order, $limit, $offset) = array_pad($arguments, 3, null);
			return $relation->get($this, $order, $limit, $offset);
		}
		return null;
	}

#endregion

#region Data Packing

	final public function compose($record) {
		foreach (static::$model->fields as $fieldName => $field) {
			if (array_key_exists($fieldName, $record)) {
				$this->$fieldName = $field->compose($record[$fieldName]);
			}
		}
	}

	final public function decompose() {
		$record = [];
		foreach (static::$model->fields as $fieldName => $field) {
			$record[$fieldName] = $field->decompose($this->$fieldName);
		}
		return $record;
	}

	final public function jsonSerialize() {
		$record = [];
		foreach (static::$model->fields as $fieldName => $field) {
			$record[$fieldName] = $field->export($this->$fieldName);
		}
		return $record;
	}

#endregion

#region CRUD
	final public function delete() {
		if ($this->isExists()) {
			if ($this->on(self::EVENT___BEFORE_DELETE) === false)
				return false;
			static::$model->repository->delete($this);
			$this->deleted = true;
			$this->on(self::EVENT___AFTER_DELETE);
		}
		return true;
	}

	final public function save() {
		if ($this->deleted)
			$this->record->set('id', null);
		if ($this->isExists()) {
			return $this->update();
		} else {
			return $this->insert();
		}
	}

	final private function update() {
		if ($this->on(self::EVENT___BEFORE_UPDATE) === false)
			return false;
		static::$model->repository->update($this);
		$this->on(self::EVENT___AFTER_UPDATE);
		return true;
	}

	final private function insert() {
		if ($this->on(self::EVENT___BEFORE_INSERT) === false)
			return false;
		$this->id = static::$model->repository->insert($this);
		$this->on(self::EVENT___AFTER_INSERT);
		return $this->id;
	}

#endregion

#region Events
	const EVENT___BEFORE_DELETE = 'before_delete';
	const EVENT___AFTER_DELETE = 'after_delete';
	const EVENT___BEFORE_UPDATE = 'before_update';
	const EVENT___AFTER_UPDATE = 'after_update';
	const EVENT___BEFORE_INSERT = 'before_insert';
	const EVENT___AFTER_INSERT = 'after_insert';
	const EVENT___ATTACHMENT_ADDED = 'attachment_added';

	protected function on($event, $data = null) { return true; }
#endregion
}