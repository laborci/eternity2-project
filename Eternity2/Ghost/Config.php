<?php namespace Eternity2\Ghost;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $env = 'ghost';

	protected $attachmentPath;
	protected $attachmentMetaFilePath;
	protected $attachmentMetaDBPath;
	protected $ghostPath;
	protected $ghostNamespace;

	public function __construct() {
		parent::__construct();
		$this->attachmentPath = env('root') . $this->config['attachment']['path'];
		$this->attachmentMetaDBPath = env('root') . $this->config['attachment']['meta-db-path'];
		$this->ghostPath = env('root').$this->config['generator']['ghost-path'];
	}

	public function defaultDatabase() { return $this->config['default-database']; }
	public function attachmentUrl() { return $this->config['attachment']['url']; }
	public function attachmentPath() { return $this->attachmentPath; }
	public function attachmentMetaDBPath() { return $this->attachmentMetaDBPath; }
	public function ghostNamespace() { return $this->config['generator']['ghost-namespace']; }
	public function ghostPath() { return $this->ghostPath; }

}