<?php namespace Entity\{{name}}\Helpers;
/**
 * @method static \Entity\{{name}}\{{name}}Repository repository()
{{fields}}
 */
trait EntityTrait{

	/** @return \Entity\{{name}}\{{name}}Model */
	public static function model() { return \Entity\{{name}}\{{name}}Model::instance(\Entity\{{name}}\{{name}}::class); }
}