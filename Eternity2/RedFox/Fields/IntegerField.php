<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;
/**
 * @datatype "int"
 */
class IntegerField extends Field{
	public function set($value){ return intval($value); }
}