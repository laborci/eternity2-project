<?php namespace Eternity2\RedFox\Generator;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateEntitiesCliCommand extends Command {

	protected function configure() {
		$this
			->setName('update-entities')
			->setAliases(['update'])
			->setDescription('Updates model from database table');
	}

	protected function execute(InputInterface $input, OutputInterface $output) { Updater::Service()->execute($input, $output, $this->getApplication()); }

}
