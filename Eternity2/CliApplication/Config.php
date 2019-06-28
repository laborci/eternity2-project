<?php namespace Eternity2\CliApplication;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $env = 'cli-application';

	function commands() { return $this->config['commands']; }
}