<?php namespace Eternity2\System\AnnotationReader;


use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {
	public function cache(){ return env('root') .$this->config['cache'];}
}