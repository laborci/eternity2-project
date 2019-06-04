<?php namespace Eternity2\System\Module;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'module-runner';

	public function modules() { return $this->config['modules']; }
}