<?php namespace Application\Module\Cli;

use Ghost\User;
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


		$user = User::pick(1);

		var_export($user);
		var_export($user->record());
		echo json_encode($user);


		$style->success( $user->boss->name);

		$style->success('Done');
	}

}
