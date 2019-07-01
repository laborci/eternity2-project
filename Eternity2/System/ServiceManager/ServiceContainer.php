<?php namespace Eternity2\System\ServiceManager;


class ServiceContainer {

	/** @var ServiceFactory[] */
	protected $services = [];

	protected static $instance;
	protected static function instance() { return is_null(static::$instance) ? static::$instance = new static() : static::$instance; }
	protected function __construct() { }

	public static function bind($name): ServiceFactory { return static::instance()->bindService($name); }
	public static function shared($name): ServiceFactory { return static::instance()->bindService($name)->shared(); }
	public static function get($name) { return static::instance()->getService($name); }

	protected function bindService($serviceName) {
		$service = new ServiceFactory($serviceName);
		$this->services[$serviceName] = $service;
		return $service;
	}

	protected function getService($name) {
		echo 'get: '.$name."\n";

		if (array_key_exists($name, $this->services)) {
			$serviceFactory = $this->services[$name];
		} else {
			$serviceFactory = $this->bindService($name)->service($name);
			try {
				$reflection = new \ReflectionClass($name);
				if ($reflection->implementsInterface(SharedService::class)) {
					$serviceFactory->shared();
				}
			} catch (\ReflectionException $e) {
				trigger_error('Service or Class as a service "'.$name.'" not found');
			}
		}
		return $serviceFactory->get();
	}

	public static function dump(){
		return static::instance()->services;
	}
}
