<?php namespace Application\Service;

use Eternity2\DBAccess\ConnectionFactory;
use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\StartupSequence\BootSequnece;
use Symfony\Component\HttpFoundation\Request;

class ServiceRegistry implements BootSequnece{
	function run(){

		//database
		class_alias(AbstractPDOConnection::class, \DefaultDBConnection::class);
		ServiceContainer::shared(\DefaultDBConnection::class)->factory(function (){ return ConnectionFactory::factory(env('database')['default']); });

		// request
		ServiceContainer::shared(Request::class)->factoryStatic([Request::class, 'createFromGlobals']);

		include 'ServiceRegistry/config.php';
		include 'ServiceRegistry/ghost.php';

	}
}