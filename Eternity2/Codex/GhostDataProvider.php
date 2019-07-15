<?php namespace Eternity2\Codex;

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
		$finder = $this->model->repository->search()->order($sorting['field'] . ' ' . $sorting['order']);
		return $finder->collectPage($pageSize, $page, $count);
	}

	public function convertItem($item): array{
		/** @var Ghost $item */
		$item = ($item);
		return $item->export();
	}

	public function createFilter($filter){ return null; }

	public function getItem($id){ return $this->model->repository->pick($id); }
	public function deleteItem($id){ return $this->model->repository->delete($id); }
	public function updateItem($id, $data){
		// TODO: Implement updateItem() method.
	}
	public function createItem($id, $data){
		// TODO: Implement createItem() method.
	}

}

