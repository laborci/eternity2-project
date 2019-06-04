<?php namespace Eternity2\System\StartupSequence;

use Eternity2\System\Env\Env;
use Eternity2\System\ServiceManager\ServiceContainer;

class StartupSequence {

	public function __construct($root, $env_file = "etc/ini/env", $env_cache = "etc/env/") {

		Env::Service();

		setenv('root', realpath($root) . '/');
		setenv('env-cache', env('root') . $env_cache);
		setenv('context', (http_response_code() ? 'WEB' : 'CLI'));
		setenv('ini-path', realpath(dirname(env('root') . $env_file)) . '/');
		Env::Service()->store(basename(env('root') . $env_file));

		if(env('output-buffering')) ob_start();

		date_default_timezone_set(env('timezone'));

		foreach (env('boot-sequence') as $sequence) {
			/** @var BootSequnece $service */
			$service = ServiceContainer::get($sequence);
			$service->run();
		}
	}
}

