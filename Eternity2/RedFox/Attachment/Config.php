<?php namespace Eternity2\RedFox\Attachment;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $attachmentPath;
	protected $thumbnailPath;

	protected function onConstruct(){
		$this->attachmentPath = env('root').$this->config['attachment']['attachment-path'];
		$this->thumbnailPath = env('root').$this->config['attachment']['thumbnail-path'];
	}

	public function attachmentPath() { return $this->attachmentPath; }
	public function attachmentUrl() { return $this->config['attachment']['attachment-url']; }
	public function thumbnailPath() { return $this->thumbnailPath; }
	public function thumbnailSecret() { return $this->config['attachment']['thumbnail-secret']; }
	public function thumbnailUrl() { return $this->config['attachment']['thumbnail-url']; }

}