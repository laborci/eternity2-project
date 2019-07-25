<?php namespace Eternity2\Codex\DataProvider;

interface DataProviderInterface{

	public function getList($page, $sorting, $filter, $pageSize, &$count):array ;
	public function getItem($id);
	public function getNewItem();
	public function deleteItem($id);
	public function updateItem($id, array $data);
	public function createItem(array $data);

}