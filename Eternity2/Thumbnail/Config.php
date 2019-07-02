<?php namespace Eternity2\Thumbnail;

use Eternity2\System\Config\ConfigBridge;
class Config extends ConfigBridge{

	public function path(){ return $this->config['path']; }
	public function url(){ return $this->config['url']; }
	public function sourcePath(){ return realpath($this->config['source-path']); }
	public function secret(){ return $this->config['secret']; }

}