<?php namespace Eternity2\CliApplication;

use Eternity2\System\Mission\Mission;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\System\ServiceManager\SharedService;

class Application implements Mission, SharedService {

	/** @var \Symfony\Component\Console\Application  */
	protected $application;


	protected $config;

	public function __construct() {
		$this->application = new \Symfony\Component\Console\Application('plx', '2');
		$this->addCommands();
		$this->addCustomCommands();
	}

	private function addCommands(){
		/** @var Config $config */
		$config = ServiceContainer::get(Config::class);
		$commands = $config->commands();
		foreach ($commands as $command){
			$this->application->add(new $command());
		}
	}

	protected function addCustomCommands(){}

	public function run() { $this->application->run(); }
}