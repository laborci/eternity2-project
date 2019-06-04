<?php namespace Eternity2\Codex\Validation;

use Eternity2\Codex\Field;

abstract class Validator {

	/** @var Field */
	protected $field;

	public function setField($field) { $this->field = $field; }

	abstract function validate($data): ValidatorResult;

	protected function ok(): ValidatorResult {
		return ValidatorResult::ok();
	}

	protected function warning($message): ValidatorResult {
		return ValidatorResult::warning($this->field->field, $this->field->label, $message);
	}

	protected function error($message): ValidatorResult {
		return ValidatorResult::error($this->field->field, $this->field->label, $message);
	}

}