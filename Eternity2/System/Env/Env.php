<?php namespace Eternity2\System\Env;


use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;
use Symfony\Component\Yaml\Yaml;

class Env implements SharedService {

	use Service;

	protected $env = [];

	function store($file) {
		$env = $this->load($file);
		$this->env = array_replace_recursive($this->env, $env);
	}

	function get($key = null) { return is_null($key) ? $this->env : (array_key_exists($key, $this->env) ? $this->env[$key] : null); }
	function set($key, $value) { $this->env[$key] = $value; }
	function unset($key) { unset ($this->env[$key]); }

	function load($file): array {
		$env = env('ini-path') . $file . '.yml';
		$env_local = env('ini-path') . $file . '.local.yml';
		$cache_file = env('env-cache') . '/' . $file . '.php';

		if (!file_exists($env)) trigger_error($file . '.yml not found!');

		if (!file_exists($cache_file) || filemtime($env)>filemtime($cache_file) || file_exists($env_local) && filemtime($env_local)>filemtime($cache_file) ) {
			$values = [];
			$loaded = Yaml::parseFile($env);
			if (is_array($loaded)) $values = array_replace_recursive($values, $loaded);
			if (file_exists($env_local)){
				$loaded = Yaml::parseFile($env_local);
				if (is_array($loaded)) $values = array_replace_recursive($values, $loaded);
			}

			$output = "<?php return [\n";
			foreach ($values as $key=>$value){
				if (substr($key, -5) === '@file') {
					$key = substr($key, 0, -5);
					$value = "file_get_contents('".env('root').$value."')";
				}else{
					$value = var_export($value, true);
				}
				$output .= "'$key'=>$value,\n";
			}
			$output .= '];';
			file_put_contents($cache_file, $output);
		}
		return include $cache_file;
	}

	function parseValues($values) {
		foreach ($values as $key => $value) {
			if (substr($key, -5) === '@file') {
				$values[substr($key, 0, -5)] = include(env('root') . $value);
				unset($values[$key]);
			}
		}
		return $values;
	}

}

include "env-facades.php";