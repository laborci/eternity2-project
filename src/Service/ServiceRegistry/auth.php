<?php use Eternity2\System\ServiceManager\ServiceContainer;

ServiceContainer::shared(\Eternity2\Zuul\AuthSessionInterface::class)->service(\Eternity2\Zuul\AuthSession::class);
ServiceContainer::shared(\Eternity2\Zuul\AuthenticableRepositoryInterface::class)->service(\Application\Service\Auth\AuthRepository::class);