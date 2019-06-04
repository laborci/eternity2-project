<?php namespace Eternity2\RedFox;

use Eternity2\RedFox\Attachment\AttachmentManager;
use Eternity2\RedFox\Relation\BackReference;

/**
 * Class Entity
 * @package RedFox\Entity
 * @property-read int $id
 */
abstract class Entity implements \JsonSerializable {

	/** @var  Record */
	private $record;
	private $deleted = false;
	private $repository = null;

	public static function repository(): Repository { return static::model()->repository(); }

	/** @return Model */
	abstract static function model();

	public function isExists(): bool { return (bool)$this->record->get('id'); }
	public function isDeleted(): bool { return $this->deleted; }

	public function delete() {
		if ($this->isExists()) {
			if ($this->onBeforeDelete() === false) return false;
			$this->repository->delete($this);
			$this->deleted = true;
			$this->onDelete();
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
		if ($this->onBeforeUpdate() === false) return false;
		$this->repository->update($this);
		$this->onUpdate();
		return true;
	}

	private function insert() {
		if ($this->onBeforeInsert() === false) return false;
		$id = $this->repository->insert($this);
		$this->record->set('id', $id);
		$this->onInsert();
		return $this->id;
	}

	public function getDTO() { return $this->record->getDTO(); }
	public function setDTO($dto) { $this->record->setDTO($dto); }

	public function __construct($data = null, Repository $repository = null) {
		$this->repository = is_null($repository) ? static::repository() : $repository;
		$this->record = new Record($this->model(), $data);
		if (is_null($data)) {
			static::model()->setDefaults($this);
		}
	}

	#region Evenet Handlers
	public function onBeforeInsert() { return true; }
	public function onBeforeUpdate() { return true; }
	public function onBeforeDelete() { return true; }
	public function onInsert() { }
	public function onUpdate() { }
	public function onDelete() { }
	#endregion

	private $attachmentManagers = [];


	public function getAttachmentManager($group): AttachmentManager { return static::model()->isAttachmentGroupExists($group) ? static::model()->getAttachmentManager($group, $this) : null; }

	public function __get($name) {
		if (method_exists($this, $method = '__get' . ucfirst($name))) {
			return $this->$method();
		} else if (static::model()->fieldExists($name)) {
			return $this->record->get($name);
		} else if (static::model()->isRelationExists($name)) {
			return static::model()->getRelation($name)($this);
		} else if (array_key_exists($name, $this->attachmentManagers)) {
			return $this->attachmentManagers[$name];
		} else if (static::model()->isAttachmentGroupExists($name)) {
			return static::model()->getAttachmentManager($name, $this);
		}
		return null;
	}

	public function __isset($name) {
		return
			static::model()->fieldExists($name) ||
			static::model()->isRelationExists($name) ||
			array_key_exists($name, $this->attachmentManagers) ||
			static::model()->isAttachmentGroupExists($name) ||
			method_exists($this, $method = '__get' . ucfirst($name));
	}

	public function __call($name, $arguments) {
		if (static::model()->isRelationExists($name)) {
			/** @var BackReference $relation */
			$relation = static::model()->getRelation($name);
			if ($relation instanceof BackReference) {
				list($order, $limit, $offset) = $arguments;
				return $relation($this, $order, $limit, $offset);
			}
		}
		trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
	}

	public function __set($name, $value) {
		if (method_exists($this, $method = '__set' . ucfirst($name))) {
			$this->$method($value);
		} else if (static::model()->fieldWritable($name)) {
			$this->record->set($name, $value);
		}
	}

	function __toString() { return $this->id; }
	function jsonSerialize() { return $this->getDTO(); }

	public function attachmentAdded(AttachmentManager $attachmentManager, $filename){}

}