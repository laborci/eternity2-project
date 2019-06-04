<?php namespace Eternity2\RedFox\Generator;

use Eternity2\System\Config\ConfigBuilder;

class Config extends ConfigBuilder {

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