<?php namespace Eternity2\RedFox;

class Record {

	protected $dto = [];
	protected $data = [];
	protected $model;
	protected $fields;

	public function __construct(Model $model, $dto = null) {
		$this->model = $model;
		$this->fields = $this->model->getFields();
		foreach ($this->fields as $field) {
			$this->dto[$field] = is_array($dto) && array_key_exists($field,$dto) ? $dto[$field] : null;
		}
		$this->importFromDTO();
	}

	public function getDTO() {
		$this->flush();
		return $this->dto;
	}

	public function setDTO($dto){
		foreach ($this->fields as $field){
			if(array_key_exists($field, $dto)) $this->dto[$field] = $dto[$field];
		}
		$this->importFromDTO();
	}

	protected function flush(){
		foreach ($this->fields as $field) if(array_key_exists($field, $this->data)){
			$this->dto[$field] = $this->model->$field->exportToDTO($this->data[$field]);
		}
	}

	public function get($name) {
		return $this->data[$name];
	}

	public function set($name, $value) {
		$field = $this->model->getField($name);
		$this->data[$name] = $field->set($value);
	}

	protected function importFromDTO(){
		foreach ($this->fields as $field){
			$this->data[$field] = $this->model->$field->importFromDTO($this->dto[$field]);
		}
	}

}