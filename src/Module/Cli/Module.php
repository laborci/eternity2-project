<?php namespace Application\Module\Cli;

use Eternity2\CliApplication\Application;

class Module extends Application {

	protected function addCustomCommands(){
		$this->application->add(new Test());
	}
}