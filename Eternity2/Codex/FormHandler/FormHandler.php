<?php namespace Eternity2\Codex\FormHandler;

use Eternity2\Codex\AdminDescriptor;
use Eternity2\Codex\FormHandler\FormSection;
use Eternity2\Codex\ItemConverterInterface;
use JsonSerializable;
class FormHandler implements JsonSerializable{

	/** @var AdminDescriptor */
	protected $admin;

	/** @var \Eternity2\Codex\DataProvider\DataProviderInterface */
	protected $dataProvider;

	/** @var ItemConverterInterface */
	private $itemConverter;

	/** @var \Eternity2\Codex\FormHandler\FormSection[] */
	protected $sections;

	protected $JSplugins = [];
//	protected $idField = "id";
	protected $labelField = null;

	public function __construct(AdminDescriptor $admin){
		$this->admin = $admin;
		$this->dataProvider = $admin->getDataProvider();
		$this->itemConverter = $this->dataProvider;
	}

	public function addJSPlugin($plugin){ $this->JSplugins[] = $plugin; }
//	public function setIdField($field){ $this->idField = $field; }
	public function setLabelField($field){ $this->labelField = $field; }
	public function setItemConverter(ItemConverterInterface $itemConverter){ $this->itemConverter = $itemConverter; }

	public function section($label){
		$section = new FormSection($label, $this->admin);
		$this->sections[] = $section;
		return $section;
	}

	public function jsonSerialize(){
		return [
			'sections'   => $this->sections,
			'plugins'    => $this->JSplugins,
//			'idField'    => $this->idField,
			'labelField' => $this->labelField,
			'headerIcon' => $this->admin->getFormIcon(),
			'tabIcon' => $this->admin->getTabIcon(),
		];
	}

	public function get($id){
		$item = $this->dataProvider->getItem($id);
		$row = $this->itemConverter->convertItem($item);
		$data = [];
		foreach ($this->sections as $section) foreach ($section->getInputs() as $input){
			$data[$input->getField()] = $row[$input->getField()];
		}
		return [
			"id"   => $id,
			"fields" => $data,
		];
	}

}
