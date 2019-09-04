<?php namespace Eternity2\Codex\Responder;

use Eternity2\Codex\AdminDescriptor;
use Throwable;

class CodexAttachmentGet extends Responder{

	protected function getRequiredPermissionType(): ?string{ return AdminDescriptor::PERMISSION; }

	protected function codexRespond(): ?array{
		$formHandler = $this->adminDescriptor->getFormHandler();
		try{
			$id = $this->getPathBag()->get('id');
			return $formHandler->getAttachments($id);
		}catch (Throwable $exception){
			$this->getResponse()->setStatusCode(400);
			return['message'=>$exception->getMessage()];
		}
		return [];
	}

}

