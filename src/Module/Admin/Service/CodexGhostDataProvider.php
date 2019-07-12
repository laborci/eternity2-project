<?php namespace Application\Module\Admin\Service;

use Eternity2\Ghost\Ghost;
class CodexGhostDataProvider implements CodexDataProvider{

	protected $ghost;
	/** @var \Eternity2\Ghost\Model model */
	protected $model;

	public function __construct($ghost){
		$this->ghost = $ghost;
		/** @var \Eternity2\Ghost\Model model */
		$this->model = $this->ghost::$model;
	}

	public function getList($page, $sorting, $filter, $pageSize, $fields, $rowConverter){
		/** @var \Eternity2\Ghost\Ghost[] $items */
		$items = $this->model->repository->search()->collectPage($pageSize, $page, $count);
		$rows = [];

		// convert items to array
		foreach ($items as $item) $rows[$item->id] = $rowConverter ? $rowConverter($item) : $this->convertRow($item);

		// filter fields
		foreach ($rows as $key => $row){
			$rows[$key] = [];
			foreach ($fields as $field) $rows[$key][$field] = $row[$field];
		}

		return new CodexListingResult($rows, $count, $page);
	}

	protected function convertRow(Ghost $item): array{ return $item->decompose(); }

}

