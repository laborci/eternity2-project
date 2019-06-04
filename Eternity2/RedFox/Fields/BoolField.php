<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;

/**
 * @datatype "bool"
 */
class BoolField extends Field {

	public function importFromDTO($value){
		return (bool)$value;
	}

	public function set($value){ return (bool)$value; }

}