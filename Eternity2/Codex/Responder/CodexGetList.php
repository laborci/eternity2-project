<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;

class CodexGetList extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{
		$page = $this->getPathBag()->get('page', 1);
		$sort = $this->getJsonParamBag()->get('sort');
		$listHandler = $this->adminDescriptor->getListHandler();
		$result = $listHandler->get($page, $sort);

		return [
			'rows'  => $result->rows,
			'count' => $result->count,
			'page'  => $result->page,
		];
	}

}

