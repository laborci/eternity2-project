<?php namespace Eternity2\RedFox;

abstract class Field {

	private $readonly = false;
	private $name;

	public function __construct($name) {
		$this->name = $name;
	}

	public function getName(){ return $this->name; }

	public function readonly(bool $set = false){
		if($set) $this->readonly = true;
		return $this->readonly;
	}

	public function importFromDTO($value) { return $value; }
	public function exportToDTO($value) { return $value; }
	public function set($value) { return $value; }

	//public function setValue($value){ return $this->set($value); }

}