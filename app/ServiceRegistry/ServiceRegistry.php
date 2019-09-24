<?php namespace Application\ServiceRegistry;

use Eternity2\System\StartupSequence\BootSequnece;

class ServiceRegistry implements BootSequnece{
	function run(){
		include 'packages/sys.php';
	}
}