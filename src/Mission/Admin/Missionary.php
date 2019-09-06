<?php namespace Application\Mission\Admin;

use Application\Codex\UserCodex;

use Eternity2\Module\Codex\Module;
use Eternity2\System\Module\ModuleLoader;
use Eternity2\Mission\Web\Application;

class Missionary extends Application{
	public function __construct(){
		/** @var Module $codex */
		$codex = ModuleLoader::Service()->get(Module::class);
		$codex->register(UserCodex::class);
	}
}
