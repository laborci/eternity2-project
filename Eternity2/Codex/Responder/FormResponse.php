<?php namespace Eternity2\Codex\Responder;


class FormResponse implements \JsonSerializable {

	protected $response = [];

	public function set($key, $value) {
		$this->response[ $key ] = $value;
	}

	public function addMessage($message) {
		if (!array_key_exists('messages', $this->response))
			$this->response[ 'messages' ] = [];
		$this->response[ 'messages' ][] = $message;
	}

	public function jsonSerialize() {
		return $this->response;
	}
}