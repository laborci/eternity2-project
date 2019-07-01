<?php namespace Eternity2\System\Config;

use Eternity2\System\Env\Env;
use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;

abstract class ConfigBridge implements SharedService{

	use Service;

	protected $config;

	static public function factory($env = null){ return new static($env); }

	protected function __construct($env){
		if ($env){
			if (is_array(env($env)))
				$this->config = env($env);
			else if (is_string(env($env)))
				$this->config = Env::Service()->load(env($env));
			else $this->config = Env::Service()->load($env);
		}
		$this->onConstruct();
	}

	protected function onConstruct(){}

}