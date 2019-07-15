<?php namespace Eternity2\Codex;

class ListField implements \JsonSerializable{

	const FIELD_TYPE_TEXT = 'text';

	private $name;
	private $label;
	private $sortable = true;
	private $type = 'text';
	private $visible = true;

	public function __construct($name, $label){
		$this->name = $name;
		$this->label = $label;
	}

	public function sortable($mode = true): self{
		$this->sortable = $mode;
		return $this;
	}

	public function visible($mode = true): self{
		$this->visible = $mode;
		return $this;
	}

	public function type($type): self{
		$this->type = $type;
		return $this;
	}

	public function jsonSerialize(){
		return [
			'name'     => $this->name,
			'label'    => $this->label,
			'sortable' => $this->sortable,
			'type'     => $this->type,
			'visible'  => $this->visible,
		];
	}

	public function getName(){ return $this->name; }

}