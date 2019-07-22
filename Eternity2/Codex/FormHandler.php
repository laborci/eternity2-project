<?php namespace Eternity2\Codex;

class FormHandler{

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

	public function getDescriptor(){
		return [$this->sections];
	}


//
//	public function add($name, $label = null): ListField{
//		if (is_null($label)) $label = !is_null($this->admin->getFieldLabel($name)) ? $this->admin->getFieldLabel($name) : $name;
//		$field = new ListField($name, $label);
//		$this->fields[] = $field;
//		return $field;
//	}
//
//	public function get($page, $sorting = null, $filter = null): ListingResult{
//		$items = $this->dataProvider->getList($page, $sorting, $filter, $this->pageSize, $count);
//		$rows = [];
//		foreach ($items as $item) $rows[] = $this->itemConverter->convertItem($item);
//		foreach ($rows as $key => $row){
//			$rows[$key] = [];
//			foreach ($this->fields as $field){
//				if (!$field->isClientOnly()) $rows[$key][$field->getName()] = $row[$field->getName()];
//			}
//		}
//		return new ListingResult($rows, $count, $page);
//	}
//
//	public function descriptor(){
//		return [
//			'plugins'  => $this->JSplugins,
//			'pageSize' => $this->pageSize,
//			'fields'   => $this->fields,
//			'idField'  => $this->idField,
//		];
//	}

}
