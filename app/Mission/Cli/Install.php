<?php namespace Application\Mission\Cli;

use DefaultDBConnection;
use Eternity2\System\ServiceManager\ServiceContainer;
use Ghost\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Install extends Command{

	protected function configure(){ $this->setName('install'); }

	protected function execute(InputInterface $input, OutputInterface $output){
		$style = new SymfonyStyle($input, $output);

		/** @var \Eternity2\DBAccess\PDOConnection\AbstractPDOConnection $db */
		$db = ServiceContainer::get(DefaultDBConnection::class);

		$db->query("CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL COMMENT 'password',
  `created` datetime DEFAULT NULL,
  `roles` set('admin','super') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=341 DEFAULT CHARSET=utf8;");

		$db->query("CREATE TABLE `user_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `userId` int(11) unsigned NOT NULL,
  `event` varchar(32) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `details` text COLLATE utf8_hungarian_ci COMMENT 'json',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;");

		$user = new User();
		$user->password = "vegas";
		$user->email = "elvis@elvis.hu";
		$user->name = "elvis";
		$user->roles = [USER::ROLES_ADMIN];
		$user->status = User::STATUS_ACTIVE;

		$user->save();

	}

}
