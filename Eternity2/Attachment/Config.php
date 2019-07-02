<?php namespace Eternity2\Attachment;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge{

	protected function onConstruct(){
		$this->config['path'] = env('root') . $this->config['path'];
		$this->config['meta-db-path'] = env('root') . $this->config['meta-db-path'];
	}

	public function path(){ return $this->config['path']; }
	public function url(){ return $this->config['url']; }
	public function metaDBPath(){ return $this->config['meta-db-path']; }
	public function thumbnailConfig(){ return $this->config['thumbnail-config']; }

}