<?php namespace Application\HTTP\Site\Middleware;



use Eternity2\System\Cache\FileCache;
use Eternity2\System\ServiceManager\ServiceContainer;
use Eternity2\WebApplication\Config;
use Eternity2\WebApplication\Pipeline\Middleware;
use Symfony\Component\HttpFoundation\Request;

class Cache extends Middleware {

	public function run(){

		/** @var Config $config */
		$config = ServiceContainer::get(Config::class);

		if($this->getRequest()->getMethod() !== Request::METHOD_GET) $this->next();
		else{
			$cache = new FileCache($config->outputCache());
			$cachekey = crc32($this->getRequest()->getRequestUri());
			if($cache->isValid($cachekey)){
				$this->setResponse(unserialize($cache->get($cachekey)));
				$this->getResponse()->headers->set('x-cached-until', $cache->getAge($cachekey)*-1);
			}else {
				$this->next();
				if($this->getRequest()->attributes->getBoolean('cache', false)){
					$cacheInterval = $this->getRequest()->attributes->getInt('cache-interval', 60);
					$cache->set($cachekey, serialize($this->getResponse()), $cacheInterval);
					$this->getResponse()->headers->set('x-cache-interval', $cacheInterval);
				}
			}
		}
	}

}