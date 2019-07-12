<?php namespace Application\Module\Admin\Service;

class CodexGhostDataProvider implements CodexDataProvider{

	protected $ghost;
	/** @var \Eternity2\Ghost\Model model */
	protected $model;

	public function __construct($ghost){
		$this->ghost = $ghost;
		/** @var \Eternity2\Ghost\Model model */
		$this->model = $this->ghost::$model;
	}

	public function getList($page, $sorting, $filter, $pageSize){
		/** @var \Eternity2\Ghost\Ghost[] $items */
		$items = $this->model->repository->search()->collectPage($pageSize, $page, $count);
		$rows = [];
		foreach ($items as $item){
			$rows[$item->id] = [
				'data' => $item->decompose(),
				'item' => $item,
			];
		}
		return new CodexListingResult($rows, $count, $page);
	}
}

class CodexListingResult{

	public $rows;
	public $count;
	public $page;

	public function __construct($rows, $count, $page){
		$this->rows = $rows;
		$this->count = $count;
		$this->page = $page;
	}

}