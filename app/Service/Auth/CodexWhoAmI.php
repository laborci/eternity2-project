<?php namespace Application\Service\Auth;

use Eternity2\Module\Codex\CodexWhoAmIInterface;
use Eternity2\Module\Zuul\WhoAmI;
use Ghost\User;

class CodexWhoAmI extends WhoAmI implements CodexWhoAmIInterface{

	public function getName(): string{
		return User::pick($this())->name;
	}

	public function getAvatar(): string{
		return User::pick($this())->getCodexAvatar();
	}
}