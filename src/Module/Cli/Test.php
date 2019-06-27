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

		$connection = new \SQLite3(env('root').'var/attachment-metadata/User.sqlite');

		$statement = $connection->prepare('INSERT INTO file (path, file) VALUES (:path, :file)');

		$time = microtime(true);

		$result = $connection->query("select * from file where path = '00/cc/14'");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) var_dump($row);

		$result = $connection->query("select * from file where path = '00/ac/14'");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) var_dump($row);

		$result = $connection->query("select * from file where path = '00/bc/14'");
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) var_dump($row);


//
//		$start = 1;
//		$step = 820000;
//
//		$connection->exec('begin');
//		for($i=$start;$i<$start + $step; $i++){
//			$path = str_pad(base_convert($i, 10, 36), 6, '0', STR_PAD_LEFT);
//			$path = substr($path, 0, 2).'/'.substr($path, 2, 2).'/'.substr($path, 4, 2);
//			$file = uniqid().'.txt';
//			$statement->bindValue(':path', $path);
//			$statement->bindValue(':file', $file);
//			$statement->execute();
//			//			$connection->query("INSERT INTO file (path, file) VALUES ('".$path."','file.txt')");
//			if($i % 1000 === 0){
//				$connection->exec('commit');
//				$connection->exec('begin');
//				echo $i.' ';
//			}
//		}
//		$connection->exec('commit');


		$style->success(microtime(true) - $time);
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


//		echo User::search(Filter::where('id=5'))->pick()->workers()[0]->name;

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
