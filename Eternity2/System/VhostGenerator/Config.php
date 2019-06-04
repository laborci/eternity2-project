<?php namespace Eternity2\System\VhostGenerator;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'vhost-generator';

	public function template() { return env('root').$this->config['template']; }
	public function vhost() { return env('root').$this->config['vhost']; }
	public function domain() { return env('domain'); }
	public function root() { return env('root'); }

}