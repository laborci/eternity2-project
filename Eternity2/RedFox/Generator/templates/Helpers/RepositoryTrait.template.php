<?php namespace Entity\{{name}}\Helpers;

/**
 * @method \Entity\{{name}}\{{name}} pick(int $id, bool $strict = true)
 * @method \Entity\{{name}}\{{name}}[] collect(array $id_list, bool $strict = true)
 * @method \Entity\{{name}}\Helpers\Finder search(\RedFox\Database\Filter\Filter $filter = null)
 */

trait RepositoryTrait {
	/** @return \Entity\{{name}}\{{name}} */
	protected function createEntity($dto, $repository = null) {
		return new \Entity\{{name}}\{{name}}($dto, $repository);
	}
}