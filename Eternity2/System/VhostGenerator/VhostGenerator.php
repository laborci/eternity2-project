<?php namespace Eternity2\System\VhostGenerator;

use Eternity2\System\ServiceManager\ServiceContainer;

class VhostGenerator {

	/** @var Config */
	protected $config;
	public function __construct() {
		$this->config = ServiceContainer::get(Config::class);
	}

	public function generate() {
		$template = file_get_contents($this->config->template());
		$template = str_replace('{{domain}}', $this->config->domain(), $template);
		$template = str_replace('{{root}}',$this->config->root(), $template);
		file_put_contents($this->config->vhost(), $template);
	}

}