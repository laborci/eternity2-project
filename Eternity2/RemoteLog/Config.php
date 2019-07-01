<?php namespace Eternity2\RemoteLog;


use Eternity2\System\Config\ConfigBridge;

class Config  extends ConfigBridge {

	protected $host;

	protected function onConstruct(){
		if (array_key_exists('host', $this->config)) $this->host = $this->config['host'];
		if (env('context') === 'CLI' && array_key_exists('host@cli', $this->config)) $this->host = $this->config['host@cli'];
		if (env('context') === 'WEB' && array_key_exists('host@web', $this->config)) $this->host = $this->config['host@web'];
	}

	public function host() { return $this->host; }
}