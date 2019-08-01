<?php namespace Eternity2\Codex\DataProvider;

use Eternity2\Codex\ItemDataImporterInterface;
use Eternity2\Ghost\Ghost;

class GhostDataProvider implements DataProviderInterface{

	protected $ghost;
	/** @var \Eternity2\Ghost\Model model */
	protected $model;

	public function __construct($ghost){
		$this->ghost = $ghost;
		$this->model = $this->ghost::$model;
	}

	public function getList($page, $sorting, $filter, $pageSize, &$count): array{
		$finder = $this->model->repository->search()->orderIf(!is_null($sorting), $sorting['field'] . ' ' . $sorting['dir']);
		return $finder->collectPage($pageSize, $page, $count);
	}

	public function convertItem($item): array{
		/** @var Ghost $item */
		return $item->export();
	}

	public function createFilter($filter){ return null; }

	public function getItem($id): ?Ghost{ return $this->model->repository->pick($id); }

	public function getNewItem(): Ghost{ return $this->model->createGhost(); }

	public function deleteItem($id){ return $this->model->repository->delete($id); }

	public function updateItem($id, array $data, ItemDataImporterInterface $itemDataImporter){
		/** @var Ghost $item */
		$item = $this->getItem($id);
		$item = $itemDataImporter->importItemData($item, $data);
		return $item->save();
	}

	public function createItem(array $data, ItemDataImporterInterface $itemDataImporter){
		/** @var Ghost $item */
		$item = $this->getNewItem();
		$item = $itemDataImporter->importItemData($item, $data);
		return $item->save();
	}

	public function importItemData($item, $data){
		/** @var Ghost $item */
		$item->import($data);
		return $item;
	}
}

