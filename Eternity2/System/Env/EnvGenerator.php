<?php namespace Eternity2\System\Env;


class EnvGenerator {

	protected $env;
	protected $config;

	public function __construct(Env $env, Config $config) {
		$this->env = $env;
		$this->config = $config;
	}

	public function generate(){
		$env = $this->env->loadIni($this->config->iniFile());
		$cwd = getcwd();
		chdir($this->config->iniPath());
		$files = glob('*.yml');
		chdir($cwd);

		foreach ($files as $file){
			$file = substr($file, 0, -4);
			if(substr($file, -6) !=='.local' && $file !== $this->config->iniFile()) {
				$env[$file] = $this->env->loadIni($file);
			}
		}

		$this->env->persistCache($env, $this->config->envPath().$this->config->envBuildFile());

	}

}