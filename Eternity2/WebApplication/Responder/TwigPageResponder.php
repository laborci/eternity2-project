<?php namespace Eternity2\WebApplication\Responder;

use Eternity2\System\AnnotationReader\AnnotationReader;
use Eternity2\System\Event\EventManager;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\WebApplication\Config;
use Minime\Annotations\Interfaces\AnnotationsBagInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class TwigPageResponder extends PageResponder {

	const EVENT_TWIG_ENVIRONMENT_CREATED = 'EVENT_TWIG_ENVIRONMENT_CREATED';

	/** @var Environment */
	private $twig;
	/** @var AnnotationsBagInterface  */
	protected $annotations;
	/** @var Config  */
	protected $config;

	private $template;

	protected function getTwig(): Environment { return $this->twig; }

	public function __construct() {
		$this->config = ServiceContainer::get(Config::class);
		$this->twig = $this->getTwigEnvironment();
		/** @var AnnotationReader $annotationReader */
		$annotationReader = ServiceContainer::get(AnnotationReader::class);
		$this->annotations = $annotationReader->getClassAnnotations(get_called_class());
		$this->template = $this->annotations->get('template');
	}
	protected function respond(): string { return $this->twig->render($this->template, $this->createViewModel()); }
	protected function createViewModel() { return $this->getDataBag()->all(); }

	static protected $twigEnvironment = null;

	function getTwigEnvironment() {
		if (is_null(static::$twigEnvironment)) {
			$loader = new FilesystemLoader();
			foreach ($this->config->twigSources() as $namespace => $path){
				if(is_dir($path))	$loader->addPath($path, $namespace);
			}
			$twigEnvironment = new Environment($loader, ['cache' => $this->config->twigCache(), 'debug' =>$this->config->twigDebug()]);
			if ($this->config->twigDebug()) $twigEnvironment->addExtension(new DebugExtension());
			EventManager::fire(self::EVENT_TWIG_ENVIRONMENT_CREATED, $twigEnvironment);
			static::$twigEnvironment = $twigEnvironment;
		}
		return static::$twigEnvironment;
	}

}





