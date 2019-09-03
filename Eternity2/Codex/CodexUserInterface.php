<?php namespace Eternity2\Codex;

use Eternity2\Zuul\AuthenticableInterface;

interface CodexUserInterface extends AuthenticableInterface{
	public function getCodexAvatar();
}