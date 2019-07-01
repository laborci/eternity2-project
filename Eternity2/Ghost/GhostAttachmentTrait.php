<?php namespace Eternity2\Ghost;

use Eternity2\Attachment\AttachmentCategoryManager;
use mysql_xdevapi\Exception;

/**
 * @mixin Ghost
 */
trait GhostAttachmentTrait {

	private $path;

	public function getPath() {
		if (is_null($this->path)) {
			$id36 = str_pad(base_convert($this->id, 10, 36), 6, '0', STR_PAD_LEFT);
			$this->path = '/' . substr($id36, 0, 2) .
				'/' . substr($id36, 2, 2) .
				'/' . substr($id36, 4, 2) . '/';
		}
		return $this->path;
	}

	public function getAttachmentCategoryManager($categoryName): AttachmentCategoryManager {
		if (!$this->isExists()) throw new Exception('Ghost not exists yet!');
		return static::$model->getAttachmentDescriptor()->getCategory($categoryName)->getCategoryManager($this);
	}

}