<?php namespace Eternity2\Codex;

class ListingResult{

	public $rows = [];
	public $count;
	public $page;

	public function __construct($rows, $count, $page){
		$this->count = $count;
		$this->page = $page;
		$this->rows = $rows;
	}

}