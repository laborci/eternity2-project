<?php namespace Eternity2\Attachment;

interface AttachmentOwnerInterface {

	public function getStoragePath():string;
	public function getAttachmentDescriptor():AttachmentDescriptor;

}