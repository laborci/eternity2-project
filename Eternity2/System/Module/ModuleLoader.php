<?php namespace Eternity2\System\Module;

use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\ServiceManager\SharedService;

class ModuleLoader implements SharedService{
	use Service;

	protected $modules = [];

	/**
	 * @param $modules
	 */
	public function loadModules(array $modules){
		foreach ($modules as $module){
			if(is_string($module)) $this->loadModule($module, []);
			else foreach ($module as $moduleName=>$config){
				$this->loadModule($moduleName, $config);
				break;
			}
		}
	}

	public function loadModule(string $module, $config){
		$moduleInstance = ServiceContainer::get($module);
		$key = get_class($moduleInstance);
		if(array_key_exists($key, $this->modules)) throw new \Exception('Module already loaded: '.$key);

		/** @var \Eternity2\System\Module\ModuleInterface $moduleInstance */
		$moduleInstance = ServiceContainer::get($module);
		$this->modules[$key] = $moduleInstance;
		$moduleInstance($config);
	}

	public function get($module): ModuleInterface{
		return $this->modules[$module];
	}
}