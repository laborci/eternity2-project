<?php namespace Entity\User;

class User extends \Eternity2\RedFox\Entity implements Helpers\EntityInterface{

	use Helpers\EntityTrait;

	public function __toString(){ return (string) $this->id; }

}