<?php namespace Eternity2\Codex;

use Eternity2\RedFox\Entity;

class FormDataManager {

	/** @var Field[] */
	protected $fields = [];
	/** @var Entity */
	protected $entityClass;

	public function __construct(AdminDescriptor $adminDescriptor) {
		$this->entityClass = $adminDescriptor->getEntityClass();
	}

	public function addField($fieldName, $label = null, $default = null): Field {
		$field = new Field($fieldName, $label, $default);
		$this->fields[$fieldName] = $field;
		return $field;
	}

	public function getField($name) { return $this->fields[$name]; }

	public function validate($data) {
		$result = new Validation\ValidationResult();
		foreach ($this->fields as $fieldName => $field) {
			if (array_key_exists($fieldName, $data)) {
				$result->addValidatorResults(...$field->validate($data[$fieldName]));
			}
		}
		return $result;
	}

	public function get($id) {
		$item = $this->pick($id);
		$data = $this->extract($item);
		return [
			'id' => $id,
			'record' => $data,
		];
	}

	protected function mapEntityArray($items) {
		return array_map(function (Entity $item) { return ['key'=>$item->id, 'value'=>$item->__toString()]; }, $items);
	}

	protected function idListEntityArray($items){
		return array_map(function(Entity $item){return $item->id;}, $items);
	}

	public function pick($id): Entity {
		if($id === 'new'){
			/** @var Entity $item */
			$item = new $this->entityClass();
			foreach ($this->fields as $field){
				$fieldname = $field->field;
				if(!is_null($field->default)) $item->$fieldname = $field->default;
			}
			return $item;
		}else{
			return $this->entityClass::repository()->pick($id);
		}
	}

	protected function extract(Entity $item): array {
		return $item->getDTO();
	}

	protected function pack(Entity $item, $data) {
		$item->setDTO($data);
	}

	protected function persist(Entity $item, $data){
		$item->save();
		return $item->id;
	}

	public function delete($id) {
		$item = $this->pick($id);
		$item->delete();
	}

	public function save($id, $data) {

		$result = [
			'validationResult' => $this->validate($data),
			'id' => false,
		];

		if ($result['validationResult']->getStatus() === false) return $result;

		$item = $this->pick($id);
		$this->pack($item, $data);
		$result['id'] = $this->persist($item, $data);

		return $result;
	}
}