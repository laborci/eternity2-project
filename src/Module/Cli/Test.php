<?php namespace Application\Module\Cli;

use Application\Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Test extends Command{

	protected function configure(){
		$this
			->setName('test');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);

		$user = new User();

		$u = User::$connection->createSmartAccess()->getRows('SELECT * FROM user limit 1');

		print_r($u);


		$style->success('Done');
	}

}
