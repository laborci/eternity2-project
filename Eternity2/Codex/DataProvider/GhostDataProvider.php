<?php namespace Eternity2\Codex\DataProvider;

use Eternity2\Codex\DataProvider\DataProviderInterface;
use Eternity2\Codex\FilterCreatorInterface;
use Eternity2\Codex\ItemConverterInterface;
use Eternity2\Ghost\Ghost;
class GhostDataProvider implements DataProviderInterface, ItemConverterInterface, FilterCreatorInterface{

	protected $ghost;
	/** @var \Eternity2\Ghost\Model model */
	protected $model;

	public function __construct($ghost){
		$this->ghost = $ghost;
		/** @var \Eternity2\Ghost\Model model */
		$this->model = $this->ghost::$model;
	}

	public function getList($page, $sorting, $filter, $pageSize, &$count): array{
		$finder = $this->model->repository->search()->orderIf(!is_null($sorting), $sorting['field'] . ' ' . $sorting['dir']);
		return $finder->collectPage($pageSize, $page, $count);
	}

	public function convertItem($item): array{
		/** @var Ghost $item */
		$item = ($item);
		return $item->export();
	}

	public function createFilter($filter){ return null; }

	public function getItem($id):Ghost{ return $this->model->repository->pick($id); }

	public function getNewItem():Ghost{
		$this->model->createGhost();
		$this->createItem(1);
	}

	public function deleteItem($id){ return $this->model->repository->delete($id); }

	public function updateItem($id, array $data){
		$this->getItem($id)->import($data);
	}

	public function createItem(array $data):int{
		$id = 1;
		return $id;
	}

}

