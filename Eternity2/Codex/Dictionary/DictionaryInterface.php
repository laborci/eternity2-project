<?php namespace Eternity2\Codex\Dictionary;

interface DictionaryInterface{
	public function __invoke($key):string;
	public function getDictionary():array;
}