<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;

class CodexGetList extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{
		$result = $this->adminDescriptor->getListDescriptor()->get(1);
		return [
			'rows'=>$result->rows,
			'count'=>$result->count,
			'page'=>$result->page
		];
	}

}

