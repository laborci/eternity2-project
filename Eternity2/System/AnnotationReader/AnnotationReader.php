<?php namespace Eternity2\System\AnnotationReader;

use Minime\Annotations\Cache\FileCache;
use Minime\Annotations\Parser;
use Minime\Annotations\Reader;

class AnnotationReader extends Reader {
	public function __construct(Config $config) {
		parent::__construct(new Parser(), new FileCache($config->cache()));
	}
}