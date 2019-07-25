<?php namespace Eternity2\Codex;

use Eternity2\Codex\DataProvider\DataProviderInterface;
use Eternity2\Codex\FormHandler\FormHandler;
use Eternity2\Codex\ListHandler\ListHandler;
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

	public function getFieldLabel($name){ return array_key_exists($name, $this->fields) ? $this->fields[$name] : $name; }

	abstract protected function listHandler(ListHandler $codexList): ListHandler;
	abstract protected function formHandler(FormHandler $codexForm): FormHandler;

	public function getListHandler(): ListHandler{ return $this->listHandler(new ListHandler($this)); }
	public function getFormHandler(): FormHandler{ return $this->formHandler(new FormHandler($this)); }

}