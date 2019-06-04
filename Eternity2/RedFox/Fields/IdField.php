<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;
/**
 * @datatype "int"
 */
class IdField extends Field {

	public function importFromDTO($value) { return is_null($value) || $value == 0 ? null : intval($value); }
	public function set($value) { return is_null($value) || $value == 0 ? null : intval($value); }

}