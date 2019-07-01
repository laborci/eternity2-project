<?php namespace Application\Module\Cli;

use Eternity2\DBAccess\Filter\Filter;
use Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\File;

class Test extends Command{

	protected function configure(){
		$this->setName('test');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);
		$time = microtime(true);

		echo realpath('/etc/');

		$user = User::pick(5);
		$user->avatar->addFile(new File(env('root').'/todo.txt'));
		$user->gallery->addFile($user->avatar->first);

		$user->avatar->first->description = "FASZA";
		$user->avatar->first->store();

//		$user->avatar->first->remove();
//		$user->gallery->first->remove();

		echo "\n";
		print_r($user->avatar->first->url);
		echo "\n";
		print_r($user->avatar->first->thumbnail->box(10,1020)->gif);
		echo "\n";

		echo $user->name;


		$style->warning('runtime: '. (microtime(true) - $time));

	}

}
