<?php namespace Eternity2\Ghost;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge{


	protected $ghostPath;

	protected function onConstruct(){
		$this->ghostPath = env('root') . $this->config['generator']['ghost-path'];
	}

	public function defaultDatabase(){ return $this->config['default-database']; }
	public function ghostNamespace(){ return $this->config['generator']['ghost-namespace']; }
	public function ghostPath(){ return $this->ghostPath; }

	public function attachmentConfig(){ return $this->config['attachment-config']; }
}