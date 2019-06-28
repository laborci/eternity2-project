<?php namespace Eternity2\Attachment;

use mysql_xdevapi\Exception;

class AttachmentDescriptor {

	/** @var AttachmentCategory[] */
	private $categories = [];

	private $path;
	private $url;
	private $metaFile;

	/** @var AttachmentMetaManager */
	private $metaManager;

	public function __construct($path, $url, $metaFile) {
		$this->path = $path;
		$this->url = $url;
		$this->metaFile = $metaFile;
	}

	public function addCategory(AttachmentCategory $category) {	$this->categories[$category->getName()] = $category;}
	public function getPath() { return $this->path; }
	public function getUrl() { return $this->url; }
	public function getCategories() { return $this->categories; }

	public function getMetaManager() {
		if (is_null($this->metaManager))$this->metaManager = new AttachmentMetaManager($this->metaFile);
		return $this->metaManager;
	}

	public function getCategory($category) {
		if (array_key_exists($category, $this->categories)) return $this->categories[$category];
		else throw new Exception("Attachment category not found");
	}

}