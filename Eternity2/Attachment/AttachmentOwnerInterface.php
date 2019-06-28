<?php namespace Eternity2\Attachment;

interface AttachmentOwnerInterface {

	public function getAttachmentManager():AttachmentManager;
	public function attachmentAdded($filename);

}