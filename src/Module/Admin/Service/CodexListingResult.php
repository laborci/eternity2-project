<?php namespace Application\Module\Admin\Service;

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