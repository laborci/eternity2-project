<?php namespace Eternity2\Ghost;

use Eternity2\DBAccess\Filter\Filter;
use Eternity2\DBAccess\Finder\AbstractFinder;
/**
 * @mixin Ghost
 */
trait GhostRepositoryFacadeTrait{
	static public function pick($id): ?self{
		if($id instanceof AbstractFinder) return $id->pick();
		else return static::$model->repository->pick($id);
	}
	/** @return self[] */
	static public function collect($ids): array{
		if($ids instanceof AbstractFinder) return $ids->collect();
		else return static::$model->repository->collect($ids);
	}

	static public function search(Filter $filter = null): AbstractFinder{ return static::$model->repository->search($filter); }
}