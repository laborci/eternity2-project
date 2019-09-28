<?php namespace Application\Mission\Cli;

class Missionary extends \Eternity2\Mission\Cli\Application {

	protected function addCustomCommands(){
		$this->application->add(new Command\Test());
		$this->application->add(new Command\Install());
	}
}