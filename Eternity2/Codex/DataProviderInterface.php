<?php namespace Eternity2\Codex;

interface DataProviderInterface{

	public function getList($page, $sorting, $filter, $pageSize, &$count):array ;
	public function getItem($id);
	public function deleteItem($id);
	public function updateItem($id, $data);
	public function createItem($id, $data);

}