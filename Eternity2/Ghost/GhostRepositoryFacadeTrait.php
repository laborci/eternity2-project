<?php namespace Eternity2\Ghost;

/**
 * @mixin Ghost
 */
trait GhostRepositoryFacadeTrait {
	static public function pick($id):?self { return self::$model->repository->pick($id); }
	/** @return self[] */
	static public function collect($ids):array { return self::$model->repository->collect($ids); }
}