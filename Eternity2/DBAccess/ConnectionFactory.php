<?php namespace Eternity2\DBAccess;

use Eternity2\DBAccess\PDOConnection\MysqlPDOConnection;
use Eternity2\DBAccess\PDOConnection\PDOConnectionInterface;
use PDO;

class ConnectionFactory{

	static function factory($config, $sqlHook=null): PDOConnectionInterface {
		switch ($config['scheme']) {
			case 'mysql':
				$connection = static::mysql($config);
				break;
			default:
				$connection = null;
		}
		if(!is_null($sqlHook)) $connection->setSqlHook($sqlHook);
		return $connection;
	}

	static function mysql($config): PDOConnectionInterface {

		$host = $config['host'];
		$database = $config['database'];
		$user = $config['user'];
		$password = $config['password'];
		$port = $config['port'];
		$charset = $config['charset'];

		$dsn = 'mysql:host=' . $host . ';dbname=' . $database . ';port=' . $port . ';charset=' . $charset;

		$connection = new MysqlPDOConnection($dsn, $user, $password);

		$connection->setAttribute(PDO::ATTR_PERSISTENT, true);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$connection->query("SET CHARACTER SET $charset");

		return $connection;
	}

}