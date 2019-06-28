<?php namespace Eternity2\RedFox\Generator;

use Eternity2\System\Config\ConfigBridge;

class Config extends ConfigBridge {

	protected $env = 'redfox';

	protected $entityPath;

	public function __construct() {
		parent::__construct();
		$this->entityPath = env('root').$this->config['generator']['entity-path'];
	}

	public function entityPath() { return $this->entityPath; }
	public function databases() { return $this->config['generator']['databases']; }
	public function defaultDatabaseName() { return $this->config['generator']['default-database-name']; }

}