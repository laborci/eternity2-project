<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;

class CodexGetFormItem extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{

		$formHandler = $this->adminDescriptor->getFormHandler();
		$id = $this->getPathBag()->get('id');
		return [
			'descriptor'=>$formHandler,
			'data'=>$formHandler->get($id)
		];
	}

}

