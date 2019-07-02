<?php namespace Eternity2\RemoteLog;


use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	public function host() { return $this->config['host']; }

}