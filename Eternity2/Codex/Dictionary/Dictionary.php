<?php namespace Eternity2\Codex\Dictionary;

class Dictionary implements DictionaryInterface{
	protected $dictionary;
	public function __construct($dictionary){
		$this->dictionary = $dictionary;
	}
	public function __invoke($key):string{
		return array_key_exists($key, $this->dictionary) ? $this->dictionary[$key] : $key;
	}
	public function getDictionary():array{
		return $this->dictionary;
	}
}