<?php namespace Application\Module\Admin\Service;

use Application\Module\Admin\Service\CodexDescriptor;
use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;
class CodexRegistry implements SharedService{

	use Service;

	protected $forms = [];

	public function registerForm($form){
		$this->forms[(new \ReflectionClass($form))->getShortName()] = $form;
	}

	public function get($name):CodexDescriptor{
		$form = $this->forms[$name];
		return $form::Service();
	}
}