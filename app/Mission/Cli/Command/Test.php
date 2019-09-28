<?php namespace Application\Mission\Cli\Command;

use Eternity2\System\Env\EnvLoader;
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
		$time = microtime(true);


		echo EnvLoader::checkCache();

		$arr = EnvLoader::load();


		$style->success('runtime: ' . (microtime(true) - $time));
	}

}
