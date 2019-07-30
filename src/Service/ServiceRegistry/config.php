<?php use Eternity2\System\ServiceManager\ServiceContainer;

ServiceContainer::shared(\Eternity2\System\Mission\Config::class)->factory(function (){ return \Eternity2\System\Mission\Config::factory('mission-runner'); });
ServiceContainer::shared(\Eternity2\System\AnnotationReader\Config::class)->factory(function (){ return \Eternity2\System\AnnotationReader\Config::factory('annotation-reader'); });
ServiceContainer::shared(\Eternity2\System\VhostGenerator\Config::class)->factory(function (){ return \Eternity2\System\VhostGenerator\Config::factory('vhost-generator'); });
ServiceContainer::shared(\Eternity2\CliApplication\Config::class)->factory(function (){ return \Eternity2\CliApplication\Config::factory('cli-application'); });
ServiceContainer::shared(\Eternity2\WebApplication\Config::class)->factory(function (){ return \Eternity2\WebApplication\Config::factory('web-application'); });
ServiceContainer::shared(\Eternity2\RemoteLog\Config::class)->factory(function (){ return \Eternity2\RemoteLog\Config::factory('remote-log'); });

//ServiceContainer::shared(\Eternity2\Redfox\Generator\Config::class)->factory(function(){return \Eternity2\Redfox\Generator\Config::factory('redfox');});
//ServiceContainer::shared(\Eternity2\Redfox\Attachment\Config::class)->factory(function(){return \Eternity2\Redfox\Attachment\Config::factory('redfox');});
