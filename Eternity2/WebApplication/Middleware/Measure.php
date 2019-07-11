<?php namespace Eternity2\WebApplication\Middleware;

use Eternity2\WebApplication\Pipeline\Middleware;

class Measure extends Middleware {

	public function run(){
		$time = microtime(1);
		$this->next();
		dump('runtime: '.(microtime(1)-$time));
	}

}