<?php namespace Eternity2\RemoteLog;

use Eternity2\System\StartupSequence\BootSequnece;

class RemoteLogBoot implements BootSequnece {
	public function run() {
		RemoteLog::Service()->registerErrorHandlers();
	}
}
