<?php namespace Eternity2\Attachment;

interface AttachmentOwnerInterface {

	public function getStoragePath();
	public static function wakeup($params);
	public function getWakeupParams();

}