<?php namespace Application\Module\Cli;

use Application\Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Test extends Command{

	protected function configure(){
		$this->setName('test');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);

//		$u = User::$model->connection->createSmartAccess()->getRows('SELECT * FROM user limit 1');

		$user = User::pick(1);

		var_export($user);
		var_export($user->record());

		//var_export(User::$model);

		$style->success('Done');
	}

}
