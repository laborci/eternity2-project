<?php namespace Eternity2\DBAccess\PDOConnection;

use PDO;

abstract class AbstractPDOConnection extends \PDO implements PDOConnectionInterface {

	protected $sqlHook;
	public function setSqlHook(callable $hook){$this->sqlHook = $hook;}

	public function query($statement, $mode = PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = []) {
		if(!is_null($this->sqlHook)){
			($this->sqlHook)($statement);
		}
		return parent::query($statement);
	}

}