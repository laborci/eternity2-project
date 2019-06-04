<?php namespace Eternity2\WebApplication;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'twig-page-responder';

	protected $sources = [];
	protected $clientVersion;
	public function __construct() {
		parent::__construct();
		$sources = $this->config['sources'];
		if(is_array($sources)) $this->sources = array_map(function ($source) { return env('root') . $source; }, $sources);

		$this->clientVersion =
			file_exists(env('root').$this->config['client-version']) ?
			json_decode(file_get_contents(env('root').$this->config['client-version']), true)['build'] :
			0;
	}
	function root() { return env('root') . $this->config['cache']; }
	function cache() { return env('root') . $this->config['cache']; }
	function debug() { return $this->config['debug']; }
	function sources() { return $this->sources; }
	function clientVersion() { return $this->clientVersion; }
}