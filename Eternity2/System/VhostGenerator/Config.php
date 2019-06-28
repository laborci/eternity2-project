<?php namespace Eternity2\System\VhostGenerator;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $env = 'vhost-generator';

	public function templates() { return $this->config['templates']; }
	public function domain() { return env('domain'); }
	public function root() { return env('root'); }

}