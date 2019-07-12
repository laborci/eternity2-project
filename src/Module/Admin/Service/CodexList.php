<?php namespace Application\Module\Admin\Service;

class CodexList{

	const FIELD_TYPE_TEXT = 'text';
	const SORT_ASC = 'asc';
	const SORT_DESC = 'desc';

	protected $fields = [];

	/** @var \Application\Module\Admin\Service\CodexDescriptor */
	protected $admin;

	protected $pageSize = 50;
	protected $JSplugins = [];

	protected $urlBase;
	protected $sorting;
	/** @var \Application\Module\Admin\Service\CodexDataProvider */
	protected $dataProvider;
	/** @var callable */
	private $rowConverter;

	public function __construct(CodexDescriptor $admin){
		$this->admin = $admin;
		$this->dataProvider = $admin->getDataProvider();
		$this->urlBase = $admin->getUrlBase();
	}

	public function setPageSize(int $pageSize){ $this->pageSize = $pageSize; }
	public function addJSPlugin($plugin){ $this->JSplugins[] = $plugin; }

	public function add($name, $sortable = true, $type = null, $label = null){
		if (is_null($type)) $type = static::FIELD_TYPE_TEXT;
		if (is_null($label)) $label = $this->admin->getFieldLabel($name);
		$this->fields[$name] = [
			"name"     => $name,
			"sortable" => $sortable,
			"label"    => $label,
			"type"     => $type,
		];
		if (is_null($this->sorting) && $sortable === true) $this->sorting = ['field' => $name, 'order' => 'asc'];
		if ($sortable === self::SORT_ASC || $sortable === self::SORT_DESC) $this->sorting = ['field' => $name, 'order' => $sortable];
	}

	public function get($page, $sorting=null, $filter=null): CodexListingResult{
		return $this->dataProvider->getList($page, $sorting, $filter, $this->pageSize, array_keys($this->fields), $this->rowConverter);
	}

	public function setRowConverter(callable $rowConverter){ $this->rowConverter = $rowConverter; }

}