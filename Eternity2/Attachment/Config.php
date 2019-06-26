<?php namespace Eternity2\Attachment;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'redfox';

	protected $attachmentPath;
	protected $thumbnailPath;

	public function __construct() {
		parent::__construct();
		$this->attachmentPath = env('root').$this->config['attachment']['attachment-path'];
		$this->thumbnailPath = env('root').$this->config['attachment']['thumbnail-path'];
	}

	public function attachmentPath() { return $this->attachmentPath; }
	public function attachmentUrl() { return $this->config['attachment']['attachment-url']; }
	public function thumbnailPath() { return $this->thumbnailPath; }
	public function thumbnailSecret() { return $this->config['attachment']['thumbnail-secret']; }
	public function thumbnailUrl() { return $this->config['attachment']['thumbnail-url']; }

}