<?php namespace Eternity2\WebApplication\Responder;

abstract class SmartPageResponder extends TwigPageResponder {

	protected $title;
	protected $bodyclass;
	protected $language;

	public function __construct() {
		parent::__construct();
		/** @var \Twig_Loader_Filesystem $loader */
		$loader = $this->getTwig()->getLoader();
		$loader->addPath(__DIR__ . '/smartpage_template', 'smartpage');
	}

	protected function getViewModelData() { return $this->getDataBag()->all(); }

	protected function createViewModel() {
		return [
			'data'      => $this->getViewModelData(),
			'smartpage' => $this->getViewModelSmartPageComponents(),
		];
	}

	private function getViewModelSmartPageComponents() {
		return [
			'clientversion' => $this->config->clientVersion(),
			'title'         => $this->title ? $this->title : $this->annotations->get('title'),
			'language'      => $this->language ? $this->language : $this->annotations->get('language', env('LANGUAGE')),
			'bodyclass'     => $this->bodyclass ? $this->bodyclass : $this->annotations->get('bodyclass'),
			'css'           => $this->annotations->getAsArray('css'),
			'js'            => $this->annotations->getAsArray('js'),
		];
	}

}





