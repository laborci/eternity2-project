<?php namespace Eternity2\System\Module;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {
	public function modules() { return $this->config['modules']; }
}