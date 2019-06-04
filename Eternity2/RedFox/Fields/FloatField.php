<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;
/**
 * @datatype "float"
 */
class FloatField extends Field {

	public function getDataType(){return 'float';}

	public function set($value) { return floatval($value); }

}