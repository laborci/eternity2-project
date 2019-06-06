<?php include __DIR__.'/../vendor/autoload.php';

\Eternity2\RemoteLog\RemoteLog::loadFacades();
\Eternity2\System\Env\Env::loadFacades();

new \Eternity2\System\StartupSequence\StartupSequence(__DIR__.'/..');