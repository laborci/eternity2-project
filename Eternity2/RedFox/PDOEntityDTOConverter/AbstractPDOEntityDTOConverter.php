<?php namespace Eternity2\RedFox\PDOEntityDTOConverter;


use Eternity2\RedFox\Model;

abstract class AbstractPDOEntityDTOConverter {

	protected $model;

	public function __construct(Model $model) {
		$this->model = $model;
	}

	public function convertToPDO($record): array {
		$dto = [];
		$fields = $this->model->getFields();
		foreach($fields as $field) {
			$dto[$field] = is_null($record[$field]) ? null : $this->toPDO($record[$field], get_class($this->model->getField($field)));
		}
		return $dto;
	}

	public function convertToDTO($record): array {
		$dto = [];
		$fields = $this->model->getFields();
		foreach($fields as $field) {
			$dto[$field] = is_null($record[$field]) ? null : $this->toDTO($record[$field], get_class($this->model->getField($field)));
		}
		return $dto;
	}


	abstract protected function toPDO($value, $type);

	abstract protected function toDTO($value, $type);

}


