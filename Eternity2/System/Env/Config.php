<?php namespace Eternity2\System\Env;


class Config {

	public function iniPath(){return getenv('ini-path');}
	public function iniFile(){return getenv('ini-file');}
	public function envPath(){return getenv('env-path');}
	public function envBuildFile(){return getenv('env-build-file');}

}