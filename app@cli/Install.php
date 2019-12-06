<?php namespace Application\Cli;

use DateTime;
use DefaultDBConnection;
use Eternity2\System\ServiceManager\ServiceContainer;
use Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Install extends Command{

	protected function configure(){
		$this->setName('install');
		$this->addOption("tables", "t", InputOption::VALUE_NONE, "Creates user and user_log tables");
		$this->addOption("add-user", "u", InputOption::VALUE_NONE, "Adds a user");
		//$this->addOption("create-dirs", "d", InputOption::VALUE_NONE, "Creates working directories");
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);

		if ($input->getOption('tables') !== false){
			/** @var \Eternity2\DBAccess\PDOConnection\AbstractPDOConnection $db */
			$db = ServiceContainer::get(DefaultDBConnection::class);
			$style->writeln("Creating table: user");
			$db->query("CREATE TABLE IF NOT EXISTS `user` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	         `name` varchar(255) DEFAULT NULL,
				`email` varchar(255) DEFAULT NULL,	
				`password` varchar(60) DEFAULT NULL COMMENT 'password',
				`created` datetime DEFAULT NULL,
				`roles` set('admin','super') DEFAULT NULL,
				`status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
		}

		if ($input->getOption('add-user') !== false){
			$style->writeln("Creating default user: elvis@eternity / vegas");
			$user = new User();
			$user->password = "vegas";
			$user->email = "elvis@eternity";
			$user->name = "elvis";
			$user->created = new DateTime();
			$user->roles = [USER::ROLES_ADMIN];
			$user->status = User::STATUS_ACTIVE;
			$user->save();
		}

		if($input->getOption('create-dirs') !== false){
			foreach ([
				         env('annotation-reader.cache'),
				         env('web-responder.output-cache'),
				         env('twig.cache'),
				         env('thumbnail.path'),
				         env('vhost-generator.path.vhost'),
				         env('attachment.path'),
				         env('attachment.meta-db-path'),
			         ] as $dir){
				$style->writeln("Creating directory: " . $dir);
				if (!is_dir($dir)) mkdir($dir, 0777, true);
			}
		}
	}

}
