<?php namespace Entity\User\Helpers;
/**
 * Nobody uses this class, it exists only to help the IDE code completion
 * @method \Entity\User\User[] collect($limit = null, $offset = null)
 * @method \Entity\User\User[] collectPage($pageSize, $page, &$count = 0)
 * @method \Entity\User\User pick()
 */
class Finder extends \Eternity2\DBAccess\Finder\AbstractFinder {
	protected function collectRecords($limit = null, $offset = null, &$count = false): array {}
	public function count(): int {}
	public function buildSQL($doCounting = false): string {}
	public function fetch($fetchmode = \PDO::FETCH_ASSOC): array {}
}