<?php namespace Ghost;

use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Zuul\AuthenticableInterface;

class User extends Helper\GhostUser implements AuthenticableInterface{

	protected function setPassword($value){ $this->password = password_hash($value, PASSWORD_BCRYPT); }

	public function getId(): int{ return $this->id; }
	public function checkPassword($password): bool{ return password_verify($password, $this->password); }
	public function checkPermission($permission = null): bool{ return is_null($permission) || in_array($permission, $this->getPermissions()); }

	protected function getPermissions(){ return $this->roles; }

	public static function authLookup($id){ return User::search(static::getActiveFilter()->and('id=$1', $id))->pick(); }
	public static function authLoginLookup($login){ return User::search(static::getActiveFilter()->and('login=$1', $login))->pick(); }
	public static function getActiveFilter(): Filter{ return Filter::where('status=$1', User::STATUS_ACTIVE); }

}

User::init();
User::$model->hasAttachment('avatar');
User::$model->hasAttachment('gallery');
User::$model->protectField('password', false, true);
