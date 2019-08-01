<?php namespace Eternity2\Codex\DataProvider;

use Eternity2\Codex\FilterCreatorInterface;
use Eternity2\Codex\ItemConverterInterface;
use Eternity2\Codex\ItemDataImporterInterface;

interface DataProviderInterface extends ItemDataImporterInterface, ItemConverterInterface, FilterCreatorInterface{

	public function getList($page, $sorting, $filter, $pageSize, &$count):array ;
	public function getItem($id);
	public function getNewItem();
	public function deleteItem($id);
	public function updateItem($id, array $data, ItemDataImporterInterface $itemDataImporter);
	public function createItem(array $data, ItemDataImporterInterface $itemDataImporter);

}