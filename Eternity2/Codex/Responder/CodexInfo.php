<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;

class CodexInfo extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{
		return [
			'header' => $this->adminDescriptor->getHeader(),
			'list'   => $this->adminDescriptor->getListDescriptor()->descriptor(),
			'urlBase'=> $this->adminDescriptor->getUrlBase()
		];
	}

}

