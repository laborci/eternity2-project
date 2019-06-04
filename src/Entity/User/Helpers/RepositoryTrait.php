<?php namespace Entity\User\Helpers;

/**
 * @method \Entity\User\User pick(int $id, bool $strict = true)
 * @method \Entity\User\User[] collect(array $id_list, bool $strict = true)
 * @method \Entity\User\Helpers\Finder search(\RedFox\Database\Filter\Filter $filter = null)
 */

trait RepositoryTrait {
	/** @return \Entity\User\User */
	protected function createEntity($dto, $repository = null) {
		return new \Entity\User\User($dto, $repository);
	}
}