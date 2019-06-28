<?php namespace Eternity2\Attachment;

class Attachment {

	protected $filename;
	protected $ownerPath;
	/** @var AttachmentDescriptor */
	protected $descriptor;
	/** @var string */
	protected $category = [];
	public $meta;
	public $description;
	protected $size;

	public function __construct(
		$filename,
		$ownerPath,
		$descriptor,
		$category,
		$size,
		$meta = [],
		$description = ''
	) {
		$this->filename = $filename;
		$this->ownerPath = $ownerPath;
		$this->descriptor = $descriptor;
		$this->category = $category;
		$this->size = $size;
		$this->meta = $meta;
		$this->description = $description;
	}

	public function __get($name) {
		switch ($name) {
			case 'path':
				return $this->descriptor->getPath() . $this->ownerPath . '/' . $this->filename;
			case 'url':
				return $this->descriptor->getUrl() . $this->ownerPath . '/' . $this->filename;
		}
	}

	public function storeMeta(){
		$this->descriptor->getMetaManager()->store(
			$this->ownerPath,
			$this->filename,
			$this->size,
			$this->meta,
			$this->description,
			$this->category
		);
	}

}