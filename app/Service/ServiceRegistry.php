<?php namespace Application\Service;

use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\StartupSequence\BootSequnece;
use Eternity2\DBAccess\ConnectionFactory;
use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;

class ServiceRegistry implements BootSequnece{
	function run(){
		class_alias(AbstractPDOConnection::class, \DefaultDBConnection::class);
		ServiceContainer::shared(\DefaultDBConnection::class)->factory(function (){ return ConnectionFactory::factory(env('database.default')); });
	}
}