<?php namespace Application\Mission\Cli;

use Eternity2\CliApplication\Application;

class Missionary extends Application {

	protected function addCustomCommands(){
		$this->application->add(new Test());
	}
}