<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;

/**
 * @datatype "string"
 */
class StringField extends Field {

	public function set($value) { return (string)$value; }

}