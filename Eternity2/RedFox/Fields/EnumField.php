<?php namespace Eternity2\RedFox\Fields;
use Eternity2\RedFox\Field;
/**
 * @datatype "string"
 */
class EnumField extends Field {

	protected $options;

	public function __construct($name, $options) {
		parent::__construct($name);
		$this->options = $options;
	}

	public function getOptions(){ return $this->options; }
	public function set($value) {
		if(!in_array($value, $this->options)) {
			throw new \Exception('Enum Field type set error');
		}
		return $value;
	}

}