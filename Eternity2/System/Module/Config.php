<?php namespace Eternity2\System\Module;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $env = 'module-runner';

	public function modules() { return $this->config['modules']; }
}