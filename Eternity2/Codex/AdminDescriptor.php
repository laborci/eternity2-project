<?php namespace Eternity2\Codex;

use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;

abstract class AdminDescriptor implements SharedService{

	use Service;

	const PERMISSION = 'permission';

	protected $permissions = [
		self::PERMISSION => 'admin'
	];

	protected $headerIcon = 'fal fa-infinite';
	protected $headerTitle = 'Eternity Form';
	protected $fields = [];
	protected $urlBase = null;
	/** @var DataProviderInterface */
	protected $dataProvider;

	public function __construct(){
		if (is_null($this->urlBase)) $this->urlBase = (new \ReflectionClass($this))->getShortName();
		$this->dataProvider = $this->createDataProvider();
	}

	abstract protected function createDataProvider(): DataProviderInterface;
	public function getDataProvider(): DataProviderInterface{ return $this->dataProvider; }
	public function getPermission($type){ return $this->permissions[$type]; }
	public function getUrlBase(){ return $this->urlBase; }
	public function getHeader(){ return ['icon' => $this->headerIcon, 'title' => $this->headerTitle]; }

	public function getFieldLabel($name){ return $this->fields[$name]; }

	abstract protected function listDescriptor(ListHandler $codexList): ListHandler;

	public function getListDescriptor(): ListHandler{ return $this->listDescriptor(new ListHandler($this)); }

}