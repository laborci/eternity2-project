<?php namespace Application\Ghost;

use Eternity2\Ghost\Ghost;

class User extends Ghost{

	protected $id;
	public $name;
	public $email;



}

User::initialize();

$user = new User();

$user->email;