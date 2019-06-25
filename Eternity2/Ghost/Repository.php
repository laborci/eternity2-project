<?php namespace Eternity2\Ghost;


use Eternity2\DBAccess\Filter\Filter;
use Eternity2\System\Cache\MemoryCache;

class Repository {

	/** @var Model */
	protected $model;
	protected $ghost;
	/** @var MemoryCache  */
	protected $cache;

	public function __construct($ghost, $model) {
		$this->ghost = $ghost;
		$this->model = $model;
		$this->cache = new MemoryCache();
	}
	private function addToCache(Ghost $object) { $this->cache->add($object, $object->id); }

	public function pick($id):?Ghost{
		if($id === null) return null;
		$object = $this->cache->get($id);
		if (is_null($object)){
			$record = $this->model->connection->createRepository($this->model->table)->pick($id);
			if($record){
				/** @var Ghost $object */
				$object = new $this->ghost();
				$object->record($record);
				$this->addToCache($object);
			}else return null;
		}
		return $object;
	}

	public function collect(array $ids):array {
		$objects = [];
		$ids = array_unique($ids);
		$requested = count($ids);
		if ($requested == 0) return [];

		foreach ($ids as $index => $id) {
			$cached = $this->cache->get($id);
			if (!is_null($cached)) {
				$objects[] = $cached;
				unset($ids[$index]);
			}
		}
		if (count($ids)) {
			$records = $this->model->connection->createRepository($this->model->table)->collect($ids);
			foreach ($records as $record) {
				/** @var Ghost $object */
				$object = new $this->ghost();
				$object->record($record);
				$this->addToCache($object);
				$objects[] = $object;
			}
		}
		return $objects;
	}

	protected function count(Filter $filter = null) { return $this->repository->count($filter); }

	public function insert(Entity $object) {
		$dto = $object->getDTO();
		$record = $this->PDODTOConverter->convertToPDO($dto);
		return $this->repository->insert($record);
	}

	public function update(Entity $object) {
		$dto = $object->getDTO();
		$record = $this->PDODTOConverter->convertToPDO($dto);
		return $this->repository->update($record);
	}

	public function delete(Entity $object) {
		$this->cache->delete($object->id);
		return $this->repository->delete($object->id);
	}

	public function search(Filter $filter = null) {
		$finder = $this->repository->search($filter);
		return $finder->setConverter(function ($record) {
			$dto = $this->PDODTOConverter->convertToDTO($record);
			$object = $this->createEntity($dto, $this);
			$this->addToCache($object);
			return $object;
		});
	}
}