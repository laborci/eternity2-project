<?php namespace Eternity2\Ghost;

use Eternity2\Attachment\Attachment;
use Eternity2\Attachment\AttachmentCategory;
use Eternity2\Attachment\AttachmentManager;
use Eternity2\System\ServiceManager\ServiceContainer;
use mysql_xdevapi\Exception;

/**
 * @mixin Ghost
 */
trait GhostAttachmentTrait {

	private $attachmentManager;

	public function getAttachmentManager(): AttachmentManager {

		if ($this->attachmentManager === null) {
			if (!$this->isExists()) throw new Exception('Ghost not exists yet!');
			$descriptor = static::$model->getAttachmentDescriptor();

			$id36 = str_pad(base_convert($this->id, 10, 36), 6, '0', STR_PAD_LEFT);
			$path = '/' . substr($id36, 0, 2) .
				'/' . substr($id36, 2, 2) .
				'/' . substr($id36, 4, 2) . '/';

			$this->attachmentManager = new AttachmentManager(
				$this,
				$descriptor,
				$path
			);
		}
		return $this->attachmentManager;
	}

	public function attachmentAdded($filename) {
		$this->on(static::EVENT___ATTACHMENT_ADDED, $filename);
	}


}