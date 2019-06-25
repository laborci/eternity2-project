<?php namespace Application\Module\Cli;

use Eternity2\DBAccess\Filter\Filter;
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

		/*
				$user = User::pick(1);

				var_export($user);
				var_export($user->record());
				echo json_encode($user);


				$style->success( $user->boss->name);

				$style->success('Done');*/
//
//		User::createBulk(User::search(Filter::where('id=5')))[0]->boss;
//		User::create(User::search(Filter::where('1=1')))->name;


		echo User::search(Filter::where('id=5'))->pick()->name;

//		$query = User::$model->connection->query('SELECT * FROM user join article as art on art.authorId = user.id');
//		$record = $query->fetchAll(\PDO::FETCH_NUM);
//		$cc = $query->columnCount();
//		print_r($cc);
//		for($i = 0; $i<$cc; $i++){
//			$meta = $query->getColumnMeta($i);
//			print_r($meta);
//		}
//		print_r($record);

	}

}
