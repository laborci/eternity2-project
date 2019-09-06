<?php

use Eternity2\RemoteLog\RemoteLog;
use Eternity2\System\Env\Env;
use Eternity2\System\StartupSequence\StartupSequence;

include __DIR__.'/../vendor/autoload.php';

RemoteLog::loadFacades();
Env::loadFacades();

new StartupSequence(__DIR__.'/..');