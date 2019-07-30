<?php namespace Eternity2\System\Mission;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {
	public function missions() { return $this->config['missions']; }
}