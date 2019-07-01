<?php namespace Eternity2\Ghost;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge{

	protected $attachmentPath;
	protected $attachmentMetaFilePath;
	protected $attachmentMetaDBPath;
	protected $ghostPath;
	protected $ghostNamespace;

	protected function onConstruct(){
		$this->config['attachment']['path'] = env('root') . $this->config['attachment']['path'];
		$this->config['attachment']['meta-db-path'] = env('root') . $this->config['attachment']['meta-db-path'];

		$this->ghostPath = env('root') . $this->config['generator']['ghost-path'];
	}

	public function defaultDatabase(){ return $this->config['default-database']; }
	public function attachment(){ return $this->config['attachment']; }
	public function thumbnail(){ return $this->config['thumbnail']; }
	public function ghostNamespace(){ return $this->config['generator']['ghost-namespace']; }
	public function ghostPath(){ return $this->ghostPath; }

}