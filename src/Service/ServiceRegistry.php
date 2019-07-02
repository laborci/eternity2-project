<?php namespace Application\Service;

use Eternity2\DBAccess\ConnectionFactory;
use Eternity2\DBAccess\PDOConnection\AbstractPDOConnection;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\StartupSequence\BootSequnece;

use Symfony\Component\HttpFoundation\Request;

class ServiceRegistry implements BootSequnece {
	function run() {
		class_alias(AbstractPDOConnection::class, \DefaultDBConnection::class);
		ServiceContainer::shared(\DefaultDBConnection::class)->factory(function () { return ConnectionFactory::factory(env('database')['default']); });
		ServiceContainer::shared(Request::class)->factoryStatic([Request::class, 'createFromGlobals']);

		ServiceContainer::shared(\Eternity2\System\Module\Config::class)->factory(function(){return \Eternity2\System\Module\Config::factory('module-runner');});
		ServiceContainer::shared(\Eternity2\System\AnnotationReader\Config::class)->factory(function(){return \Eternity2\System\AnnotationReader\Config::factory('annotation-reader');});
		ServiceContainer::shared(\Eternity2\System\VhostGenerator\Config::class)->factory(function(){return \Eternity2\System\VhostGenerator\Config::factory('vhost-generator');});
		ServiceContainer::shared(\Eternity2\Redfox\Generator\Config::class)->factory(function(){return \Eternity2\Redfox\Generator\Config::factory('redfox');});
		ServiceContainer::shared(\Eternity2\Redfox\Attachment\Config::class)->factory(function(){return \Eternity2\Redfox\Attachment\Config::factory('redfox');});
		ServiceContainer::shared(\Eternity2\CliApplication\Config::class)->factory(function(){return \Eternity2\CliApplication\Config::factory('cli-application');});
		ServiceContainer::shared(\Eternity2\WebApplication\Config::class)->factory(function(){return \Eternity2\WebApplication\Config::factory('web-application');});
		ServiceContainer::shared(\Eternity2\RemoteLog\Config::class)->factory(function(){return \Eternity2\RemoteLog\Config::factory('remote-log');});

		#region Ghost
		ServiceContainer::shared(\Eternity2\Ghost\Config::class)->factory(function(){return \Eternity2\Ghost\Config::factory('ghost');});

		class_alias(\Eternity2\Attachment\Config::class, \GhostAttachmentConfig::class);
		ServiceContainer::shared(\GhostAttachmentConfig::class)->factory(function(){return \GhostAttachmentConfig::factory('ghost-attachment');});

		class_alias(\Eternity2\Thumbnail\Config::class, \GhostThumbnailConfig::class);
		ServiceContainer::shared(\GhostThumbnailConfig::class)->factory(function(){return \GhostThumbnailConfig::factory('ghost-thumbnail');});

		class_alias(\Eternity2\Thumbnail\ThumbnailResponder::class, \GhostThumbnailResponder::class);
		ServiceContainer::shared(\GhostThumbnailResponder::class)->factory(function(){return new \GhostThumbnailResponder(ServiceContainer::get(\GhostThumbnailConfig::class));});
		#endregion
	}
}