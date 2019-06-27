<?php namespace Eternity2\Attachment;

class AttachmentSystem{

	protected $basePath;
	protected $baseUrl;
	protected $metaFilePath;

	public function __construct($basePath, $baseUrl, $metaFilePath){
		$this->basePath = $basePath;
		$this->baseUrl = $baseUrl;
		$this->metaFilePath = $metaFilePath;
	}

	public function getBasePath(){ return $this->basePath; }
	public function getBaseUrl(){ return $this->baseUrl; }
	public function getMetaFilePath(){ return $this->metaFilePath; }

	public function getAttachmentManager(AttachmentOwnerInterface $owner){
		return new AttachmentManager($owner, $this);
	}
}