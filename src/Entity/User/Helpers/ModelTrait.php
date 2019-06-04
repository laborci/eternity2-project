<?php namespace Entity\User\Helpers;
/**
 * px: @property-read Eternity2\RedFox\Fields\IdField $id
 * px: @property-read Eternity2\RedFox\Fields\StringField $name
 * px: @property-read Eternity2\RedFox\Fields\StringField $email
 * px: @property-read Eternity2\RedFox\Fields\StringField $login
 * px: @property-read Eternity2\RedFox\Fields\BoolField $status
 * px: @property-read Eternity2\RedFox\Fields\StringField $displayNameHu
 * px: @property-read Eternity2\RedFox\Fields\StringField $displayNameEn
 * px: @property-read Eternity2\RedFox\Fields\StringField $neptun

 */
trait ModelTrait{
	private $repositoryInstance = null;
	private $entityShortName = 'User';

	/** @return \Entity\User\UserRepository */
	public function repository(){
		if(is_null($this->repositoryInstance)) $this->repositoryInstance = new \Entity\User\UserRepository($this, ...(include('source.php')));
		return $this->repositoryInstance;
	}

	public function fields():array { return include("fields.php"); }
}