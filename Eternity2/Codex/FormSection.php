<?php namespace Eternity2\Codex;

use JsonSerializable;

class FormSection implements JsonSerializable{
	/** @var FormInput[] */
	protected $inputs = [];
	protected $label;
	protected $adminDescriptor;

	public function __construct($label, AdminDescriptor $adminDescriptor) {
		$this->label = $label;
		$this->adminDescriptor = $adminDescriptor;
	}

	public function input($type, $field, $label = null){
		if(is_null($label)){
			$label = $this->adminDescriptor->getFieldLabel($field);
		}
		$input = new FormInput($type, $label, $field);
		$this->inputs[] = $input;
		return $input;
	}

	public function get(){
//		$output = [
//			'label' => $this->label,
//			'inputs' => []
//		];
//		foreach ($this->inputs as $input){
//			$output['inputs'][] = $input->get();
//		}
//		return $output;
	}

	public function findInput($field){
//		foreach ($this->inputs as $input){
//			$inputDescriptor = $input->get();
//			if($inputDescriptor['field'] === $field) return $inputDescriptor;
//		}
//		return false;
	}
	/**
	 * Specify data which should be serialized to JSON
	 * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize(){
		return [
			'label' => $this->label,
			'inputs' => $this->inputs
		];
	}
}
