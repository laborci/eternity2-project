<?php namespace Eternity2\RedFox\PDOEntityDTOConverter;

use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;
use Eternity2\RedFox\Model;

class PDOEntityDTOConverterFactory {

	static function factory(AbstractPDOConnection $connection, Model $model):AbstractPDOEntityDTOConverter{
		$driver = $connection->getAttribute(\PDO::ATTR_DRIVER_NAME);
		switch ($driver){
			case 'mysql':
				return new MysqlPDOEntityDTOConverter($model);
				break;
		}
	}

}