<?php namespace Eternity2\RedFox\Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class CreateEntityCliCommand extends Command {

	/** @var SymfonyStyle */
	protected $output;

	protected function configure() {
		$this
			->setName('create-entity')
			->setAliases(['create'])
			->setDescription('Creates new entity')
			->addArgument('name', InputArgument::REQUIRED)
			->addArgument('table')
			->addArgument('database')
			->addOption("recreate", "r", InputOption::VALUE_NONE, "Delete and recreate the entity")
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) { Creator::Service()->execute($input, $output, $this->getApplication()); }

}
