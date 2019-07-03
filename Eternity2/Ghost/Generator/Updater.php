<?php namespace Eternity2\RedFox\Generator;

use Eternity2\System\ServiceManager\Service;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Updater {

	use Service;

	/** @var Config  */
	protected $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function execute(InputInterface $input, OutputInterface $output, Application $application) {
		$style = new SymfonyStyle($input, $output);

		$style->title('Updating all entites');
		$folders = glob($this->config->entityPath().'*');
		foreach ($folders as $folder) {
			if (is_dir($folder)) {
				$name = basename($folder);
				$command = $application->find('create-entity');
				$updateInput = new ArrayInput(['command' => 'create-entity', 'name' => $name, '--update']);
				$command->run($updateInput, $output);
			}
		}
	}

}