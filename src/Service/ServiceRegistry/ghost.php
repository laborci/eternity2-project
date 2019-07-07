<?php use Eternity2\System\ServiceManager\ServiceContainer;

class_alias(\Eternity2\Attachment\Config::class, \GhostAttachmentConfig::class);
class_alias(\Eternity2\Thumbnail\Config::class, \GhostThumbnailConfig::class);
class_alias(\Eternity2\Thumbnail\ThumbnailResponder::class, \GhostThumbnailResponder::class);

ServiceContainer::shared(\Eternity2\Ghost\Config::class)->factory(function (){ return \Eternity2\Ghost\Config::factory('ghost'); });
ServiceContainer::shared(\GhostAttachmentConfig::class)->factory(function (){ return \GhostAttachmentConfig::factory('ghost-attachment'); });
ServiceContainer::shared(\GhostThumbnailConfig::class)->factory(function (){ return \GhostThumbnailConfig::factory('ghost-thumbnail'); });
ServiceContainer::shared(\GhostThumbnailResponder::class)->factory(function (){ return new \GhostThumbnailResponder(ServiceContainer::get(\GhostThumbnailConfig::class)); });