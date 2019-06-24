<?php namespace Eternity2\Ghost;


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

	public function pick($id){
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
}