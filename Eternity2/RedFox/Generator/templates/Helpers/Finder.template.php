<?php namespace Entity\{{name}}\Helpers;
/**
 * Nobody uses this class, it exists only to help the IDE code completion
 * @method \Entity\{{name}}\{{name}}[] collect($limit = null, $offset = null)
 * @method \Entity\{{name}}\{{name}}[] collectPage($pageSize, $page, &$count = 0)
 * @method \Entity\{{name}}\{{name}} pick()
 */
class Finder extends \Eternity2\DBAccess\Finder\AbstractFinder {
	protected function collectRecords($limit = null, $offset = null, &$count = false): array {}
	public function count(): int {}
	public function buildSQL($doCounting = false): string {}
	public function fetch($fetchmode = \PDO::FETCH_ASSOC): array {}
}