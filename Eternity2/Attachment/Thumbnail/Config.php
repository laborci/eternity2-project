<?php namespace Eternity2\Attachment\Thumbnail;

class Config{

	protected $config;

	public function __construct($config){ $this->config = $config; }

	public function getPath(){ return $this->config['path']; }
	public function getUrl(){ return $this->config['url']; }
	public function getSourcePath(){ return realpath($this->config['source-path']); }
	public function getSecret(){ return $this->config['secret']; }

}