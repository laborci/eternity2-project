<?php namespace Eternity2\CliApplication;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'cli-application';

	function commands() { return $this->config['commands']; }
}