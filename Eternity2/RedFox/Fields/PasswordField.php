<?php namespace Eternity2\RedFox\Fields;

/**
 * @datatype "string"
 */
class PasswordField extends StringField {

	public function set($value) { return $this->hash($value); }
	public function check($password, $hash) {
		$result = password_verify($password, $hash);
		return $result;
	}
	protected function hash($password) {
		return password_hash( $password, PASSWORD_BCRYPT); }

	public function importFromDTO($value) {
		if(is_null($value)) return null;
		if(password_needs_rehash($value, PASSWORD_BCRYPT)){
			return $this->hash($value);
		}
		return $value;
	}

}