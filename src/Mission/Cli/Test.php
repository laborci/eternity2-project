<?php namespace Application\Mission\Cli;

use Eternity2\DBAccess\Filter\Filter;
use Eternity2\System\Env\EnvLoader;
use Ghost\Article;
use Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Yaml\Yaml;

class Test extends Command{

	protected function configure(){
		$this->setName('test');
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);
		$time = microtime(true);


		$el = new EnvLoader();
		$config = $el->load();

		echo json_encode($config, JSON_PRETTY_PRINT);
		echo "\n\n";
		$style->success('runtime: ' . (microtime(true) - $time));

	}

}
