<?php namespace Eternity2\System\Env;


use Eternity2\System\ServiceManager\Service;
use Eternity2\System\ServiceManager\SharedService;
use Symfony\Component\Yaml\Yaml;

class Env implements SharedService {

	use Service;

	protected $env = [];
	protected $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function store($env) { $this->env = array_replace_recursive($this->env, $env); }

	public function storeFile($file) { $this->store($this->load($file)); }


	public function get($key = null) { return is_null($key) ? $this->env : (array_key_exists($key, $this->env) ? $this->env[$key] : null); }
	public function set($key, $value) { $this->env[$key] = $value; }
	public function unset($key) { unset ($this->env[$key]); }

	public function load($file): array {

		$env = $this->config->iniPath() . $file . '.yml';
		$env_local = $this->config->iniPath() . $file . '.local.yml';
		$cache_file = $this->config->envPath() . '/' . $file . '.php';

		if (!file_exists($env)) trigger_error($file . '.yml not found!');

		if (!file_exists($cache_file) || filemtime($env) > filemtime($cache_file) || (file_exists($env_local) && filemtime($env_local) > filemtime($cache_file))) {
			$values = $this->loadIni($file);
			$this->persistCache($values, $cache_file);
		}
		return include $cache_file;
	}

	public function parseValues($values) {
		foreach ($values as $key => $value) {
			if (substr($key, -5) === '@file') {
				$values[substr($key, 0, -5)] = include(getenv('root') . $value);
				unset($values[$key]);
			}
		}
		return $values;
	}

	public function loadIni($file) {
		$env = $this->config->iniPath() . $file . '.yml';
		$env_local = $this->config->iniPath() . $file . '.local.yml';
		$values = [];
		$loaded = Yaml::parseFile($env);
		if (is_array($loaded)) $values = array_replace_recursive($values, $loaded);
		if (file_exists($env_local)) {
			$loaded = Yaml::parseFile($env_local);
			if (is_array($loaded)) $values = array_replace_recursive($values, $loaded);
		}
		return $values;
	}

	public function persistCache($values, $cache_file) {
		$output = "<?php return [\n";
		foreach ($values as $key => $value) {
			if (substr($key, -5) === '@file') {
				$key = substr($key, 0, -5);
				$value = "file_get_contents('" . env('root') . $value . "')";
			} else {
				$value = var_export($value, true);
			}
			$output .= "'$key'=>$value,\n";
		}
		$output .= '];';
		file_put_contents($cache_file, $output);
	}

	static public function loadFacades() { include "facades.php"; }


}