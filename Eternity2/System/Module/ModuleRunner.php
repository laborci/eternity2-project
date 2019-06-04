<?php namespace Eternity2\System\Module;

use Eternity2\System\Env\Env;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\StartupSequence\BootSequnece;
use Symfony\Component\HttpFoundation\Request;

class ModuleRunner implements BootSequnece {

	protected $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	function run() {
		$modules = $this->config->modules();

		$host = Request::createFromGlobals()->getHttpHost();

		foreach ($modules as $module) {
			$patterns = is_array($module['pattern']) ? $module['pattern'] : [$module['pattern']];
			foreach ($patterns as $pattern) {
				$pattern = str_replace('{domain}', env('domain'), $pattern);
				if (fnmatch($pattern, $host)) {
					if (array_key_exists('reroute', $module)) {
						die(header('location:' . Request::createFromGlobals()->getScheme() . '://' . str_replace('{domain}', env('domain'), $module['reroute'])));
					}
					/** @var Module $moduleHandler */
					$moduleHandler = ServiceContainer::get($module['handler']);
					$moduleHandler->run();
					die();
				}
			}
		}
		die('No module');
	}
}