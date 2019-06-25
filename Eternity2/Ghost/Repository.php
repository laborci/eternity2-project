<?php namespace Eternity2\Ghost;


use Eternity2\DBAccess\Filter\Filter;
use Eternity2\DBAccess\Finder\AbstractFinder;
use Eternity2\System\Cache\MemoryCache;

class Repository {

	/** @var Model */
	protected $model;
	protected $ghost;
	/** @var MemoryCache  */
	protected $cache;
	/** @var  */
	protected $dbRepository;

	public function __construct($ghost, Model $model) {
		$this->ghost = $ghost;
		$this->model = $model;
		$this->cache = new MemoryCache();
		$this->dbRepository = $model->connection->createRepository($model->table);
	}
	private function addToCache(Ghost $object) { $this->cache->add($object, $object->id); }

	public function pick($id):?Ghost{
		if($id === null) return null;
		$object = $this->cache->get($id);
		if (is_null($object)){
			$record = $this->dbRepository->pick($id);
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
			$records = $this->dbRepository->collect($ids);
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

	protected function count(Filter $filter = null) { return $this->dbRepository->count($filter); }

	public function insert(Ghost $object) {
		$record = $object->record();
		return $this->dbRepository->insert($record);
	}

	public function update(Ghost $object) {
		$record = $object->record();
		return $this->dbRepository->update($record);
	}

	public function delete(Ghost $object) {
		$this->cache->delete($object->id);
		return $this->dbRepository->delete($object->id);
	}

	public function search(Filter $filter = null):AbstractFinder {
		$finder = $this->dbRepository->search($filter);
		$finder->setConverter(function ($record) {
			/** @var Ghost $object */
			$object = new $this->ghost();
			$object->record($record);
			$this->addToCache($object);
			return $object;
		});
		return $finder;
	}
}