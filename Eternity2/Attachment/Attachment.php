<?php namespace Eternity2\Attachment;

use Eternity2\Attachment\Thumbnail\Thumbnail;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @property-read $url
 * @property-read $path
 * @property-read $category
 * @property-read Thumbnail $thumbnail
 */

class Attachment extends File {

	/** @var AttachmentCategoryManager */
	private $categoryManager;
	public $description;
	public $ordinal;
	public $meta;

	public function __construct(
		$filename,
		AttachmentCategoryManager $categoryManager,
		$description = '',
		$ordinal = 0,
		$meta = []
	) {
		parent::__construct($categoryManager->getPath() . '/' . $filename);
		$this->categoryManager = $categoryManager;
		$this->description = $description;
		$this->ordinal = $ordinal;
		$this->meta = $meta;
	}

	public function getCategory(): AttachmentCategory { return $this->categoryManager->getCategory(); }

	public function __get($name) {
		switch ($name) {
			case 'path':
				return $this->categoryManager->getPath() . $this->getFilename();
			case 'url':
				return $this->categoryManager->getUrl() .  $this->getFilename();
			case 'category':
				return $this->getCategory()->getName();
			case 'thumbnail':
				return new Thumbnail($this, $this->getCategory()->getAttachmentStorage()->getThumbnailConfig());
		}
		return null;
	}

	public function getRecord() {
		return [
			'path'        => $this->categoryManager->getOwner()->getPath(),
			'file'        => $this->getFilename(),
			'size'        => $this->getSize(),
			'meta'        => $this->meta,
			'description' => $this->description,
			'ordinal'     => $this->ordinal,
			'category'    => $this->categoryManager->getCategory()->getName(),
		];
	}

	public function store() { $this->categoryManager->store($this); }
	public function remove() { $this->categoryManager->remove($this); }


}