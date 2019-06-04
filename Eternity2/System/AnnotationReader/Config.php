<?php namespace Eternity2\System\AnnotationReader;


use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {
	protected $env = 'annotation-reader';
	public function cache(){ return env('root') .$this->config['cache'];}
}