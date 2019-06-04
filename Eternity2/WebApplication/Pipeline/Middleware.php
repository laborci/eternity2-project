<?php namespace Eternity2\WebApplication\Pipeline;

abstract class Middleware extends Segment {
	final public function __invoke($method = 'run') {
		if (method_exists($this, 'shutDown')) register_shutdown_function([$this, 'shutDown']);
		$this->$method();
	}
}