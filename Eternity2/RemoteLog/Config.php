<?php namespace Eternity2\RemoteLog;


class Config {

	protected $host;

	public function __construct() {
		if (array_key_exists('host', env('remote-log'))) $this->host = env('remote-log')['host'];
		if (env('context') === 'CLI' && array_key_exists('host@cli', env('remote-log'))) $this->host = env('remote-log')['host@cli'];
		if (env('context') === 'WEB' && array_key_exists('host@web', env('remote-log'))) $this->host = env('remote-log')['host@web'];
	}

	public function host() { return $this->host; }
}