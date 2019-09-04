<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;
use Throwable;

class CodexAttachmentDelete extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{
		$formHandler = $this->adminDescriptor->getFormHandler();
		$id = $this->getPathBag()->get('id');
		return $formHandler->getAttachments($id);
		try{

		}catch (Throwable $exception){
			$this->getResponse()->setStatusCode(400);
			return['message'=>$exception->getMessage()];
		}
		return [];
	}

}

