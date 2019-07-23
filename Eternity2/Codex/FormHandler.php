<?php namespace Eternity2\Codex;

use JsonSerializable;
class FormHandler implements JsonSerializable{

	/** @var AdminDescriptor */
	protected $admin;

	/** @var \Eternity2\Codex\DataProviderInterface */
	protected $dataProvider;

	/** @var ItemConverterInterface */
	private $itemConverter;

	/** @var \Eternity2\Codex\FormSection[] */
	protected $sections;

	protected $JSplugins = [];
	protected $idField = "id";
	protected $labelField = "id";

	public function __construct(AdminDescriptor $admin){
		$this->admin = $admin;
		$this->dataProvider = $admin->getDataProvider();
		$this->itemConverter = $this->dataProvider;
	}

	public function addJSPlugin($plugin){ $this->JSplugins[] = $plugin; }
	public function setIdField($field){ $this->idField = $field; }
	public function setLabelField($field){ $this->labelField = $field; }
	public function setItemConverter(ItemConverterInterface $itemConverter){ $this->itemConverter = $itemConverter; }

	public function section($label){
		$section = new FormSection($label, $this->admin);
		$this->sections[] = $section;
		return $section;
	}

	public function jsonSerialize(){
		return [
			'sections'=>$this->sections,
			'plugins'=>$this->JSplugins,
			'idField'=>$this->idField,
			'labelField'=>$this->labelField,
		];
	}

}
