<?php namespace Eternity2\Ghost;

use Eternity2\System\AnnotationReader\AnnotationReader;
use Eternity2\System\ServiceManager\ServiceContainer;
abstract class Ghost{

	/** @var \Eternity2\DBAccess\PDOConnection\AbstractPDOConnection */
	public static $connection = null;
	protected static $table = null;
	protected static $initialized = false;

	static public function initialize($connection, $table, ...$params){
		if(static::$initialized) return;
		/** @var AnnotationReader $reader */
		$reader = ServiceContainer::get(AnnotationReader::class);
		$annotations = $reader->getClassAnnotations(get_called_class());
		self::$table = $annotations->get('ghost-table');
		static::$connection = ServiceContainer::get($annotations->get('ghost-database'));
		static::$initialized = true;
	}


	public function save(){

	}

}