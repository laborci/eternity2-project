<?php namespace Eternity2\Attachment;

interface AttachmentOwnerInterface {

	public function getStoragePath():string;
	public function getAttachmentDescriptor():AttachmentDescriptor;
	public function getMetaFileName():string;
	public function createAttachmentManager():AttachmentManager;

}