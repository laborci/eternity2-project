<?php namespace Eternity2\WebApplication;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

	protected $env = 'web-appication';

	protected $twigSources = [];
	protected $outputCache;
	protected $clientVersion;

	public function __construct() {
		parent::__construct();
		$sources = $this->config['twig']['sources'];
		if (is_array($sources)) $this->twigSources = array_map(function ($source) { return env('root') . $source; }, $sources);
		dump($this->twigSources);
		$this->outputCache = env('root') . $this->config['output-cache'];
		$clientVersionFile = env('root') . $this->config['client-version'];
		$this->clientVersion = file_exists($clientVersionFile) ? file_get_contents($clientVersionFile) : 0;
	}
	function root() { return env('root') . $this->config['cache']; }
	function twigCache() { return env('root') . $this->config['twig']['cache']; }
	function twigDebug() { return $this->config['twig']['debug']; }
	function twigSources() { return $this->twigSources; }
	function clientVersion() { return $this->clientVersion; }
	function outputCache() { return $this->outputCache; }
}