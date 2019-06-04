<?php namespace Entity\User\Helpers;
/**
 * @method static \Entity\User\UserRepository repository()
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $login
 * @property bool $status
 * @property string $displayNameHu
 * @property string $displayNameEn
 * @property string $neptun
 */
trait EntityTrait{

	/** @return \Entity\User\UserModel */
	public static function model() { return \Entity\User\UserModel::instance(\Entity\User\User::class); }
}