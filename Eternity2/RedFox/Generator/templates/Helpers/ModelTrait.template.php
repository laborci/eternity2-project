<?php namespace Entity\{{name}}\Helpers;
/**
{{fields}}
 */
trait ModelTrait{
	private $repositoryInstance = null;
	private $entityShortName = '{{name}}';

	/** @return \Entity\{{name}}\{{name}}Repository */
	public function repository(){
		if(is_null($this->repositoryInstance)) $this->repositoryInstance = new \Entity\{{name}}\{{name}}Repository($this, ...(include('source.php')));
		return $this->repositoryInstance;
	}

	public function fields():array { return include("fields.php"); }
}