<?php namespace Eternity2\Attachment;


class AttachmentSystem {

	protected $basePath;
	protected $baseUrl;

	public function __construct($basePath, $baseUrl) {
		$this->basePath = $basePath;
		$this->baseUrl = $baseUrl;
	}

	public function getBasePath() { return $this->basePath; }
	public function getBaseUrl() { return $this->baseUrl; }

	public function getAttachmentManager(AttachmentOwnerInterface $owner) {
		return new AttachmentManager($owner, $this);
	}
}