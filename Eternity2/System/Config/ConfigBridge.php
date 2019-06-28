<?php namespace Eternity2\System\Config;


use Eternity2\System\Env\Env;
use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;

abstract class ConfigBridge implements SharedService {

	use Service;

	protected $config;
	protected $env = null;

	public function __construct() {
		if ($this->env) {
			if (is_array(env($this->env))) $this->config = env($this->env);
			else if (is_string(env($this->env))) $this->config = Env::Service()->load(env($this->env));
			else $this->config = Env::Service()->load($this->env);
		}
	}

}