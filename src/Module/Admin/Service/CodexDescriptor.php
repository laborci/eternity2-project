<?php namespace Application\Module\Admin\Service;

use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;

abstract class CodexDescriptor implements SharedService{

	use Service;

	protected $permission = 'admin';
	protected $headerIcon = 'fal fa-infinite';
	protected $headerTitle = 'Eternity Form';
	protected $fields = [];
	protected $urlBase = null;
	/** @var CodexDataProvider */
	protected $dataProvider;

	public function __construct(){
		if (count($this->fields) === 0) trigger_error('Fields are not defined for ' . get_called_class());
		if (is_null($this->urlBase)) $this->urlBase = (new \ReflectionClass($this))->getShortName();
		$this->dataProvider = $this->createDataProvider();
	}

	abstract protected function createDataProvider(): CodexDataProvider;
	public function getDataProvider(): CodexDataProvider{ return $this->dataProvider; }
	public function getGlobalPermission(){ return $this->permission; }
	public function getUrlBase(){ return $this->urlBase; }
	public function getHeader(){ return ['icon' => $this->headerIcon, 'title' => $this->headerTitle]; }

	public function getFieldLabel($name){ return $this->fields[$name]; }

	abstract protected function listDescriptor(CodexList $codexList): CodexList;

	public function getListDescriptor(): CodexList{ return $this->listDescriptor(new CodexList($this)); }

}