<?php namespace Eternity2\Attachment;

class Config{

	protected $config;

	public function __construct($config){ $this->config = $config; }

	public function getPath(){ return $this->config['path']; }
	public function getUrl(){ return $this->config['url']; }
	public function getMetaDBPath(){ return $this->config['meta-db-path']; }

}