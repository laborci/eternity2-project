<?php namespace Application\Module\Cli;

use Eternity2\DBAccess\Filter\Filter;
use Ghost\Article;
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


//
//		$article->setfield = Article::SETFIELD_BETA;

		$user = User::pick(5);
		$user->password = 'galaga';
		$user->save();

		$style->writeln($user->name);

		$article = Article::pick(1);
		$style->writeln($article->title);


		//		$user->save();

//
//		$user->avatar->addFile(new File(env('root').'assets/web/img/0.jpg'));
//		$user->gallery->addFile($user->avatar->first);
//
//		$user->avatar->get('0.jpg');
//		$user->avatar->first->store();

//		$user->avatar->first->remove();
//		$user->gallery->first->remove();

//		echo "\n";
//		print_r($user->avatar->first->url);
//		echo "\n";
//		print_r($user->avatar->get('0.jpg')->thumbnail->box(320,320)->jpg);
//		echo "\n";
//
//		$user->avatar->get('0.jpg')->thumbnail->purge();
//
//		echo $user->name;
//

		$style->success('runtime: '. (microtime(true) - $time));

	}

}
