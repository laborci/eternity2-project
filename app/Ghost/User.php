<?php namespace Ghost;

use Eternity2\DBAccess\Filter\Filter;
use Eternity2\Module\Zuul\Interfaces\AuthenticableInterface;

class User extends Helper\GhostUser implements AuthenticableInterface{

	public $status = 'inactive';

	protected function setPassword($value){ $this->password = password_hash($value, PASSWORD_BCRYPT); }

// region AuthenticableInterface
	public function getId(): int{ return $this->id; }
	public function checkPassword($password): bool{
		return password_verify($password, $this->password);
	}
	public function checkPermission($permission = null): bool{
		return
			$this->status === self::STATUS_ACTIVE &&
			(is_null($permission) || in_array($permission, $this->getPermissions()));
	}
// endregion

	protected function getPermissions(){ return $this->roles; }

	public static function authLookup($id){ return User::pick($id); }
	public static function authLoginLookup($login){ return User::search(static::getActiveFilter()->and(User::F_EMAIL . '=$1', $login))->pick(); }
	public static function getActiveFilter(): Filter{ return Filter::where('status=$1', User::STATUS_ACTIVE); }

	public function getCodexAvatar(){ return $this->avatar->count ? $this->avatar->first->thumbnail->crop(64, 64)->png : ''; }
}

User::init();
User::$model->hasAttachment('avatar')->maxFileCount(1);
User::$model->protectField('password', false, true);
