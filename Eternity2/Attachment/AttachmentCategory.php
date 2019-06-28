<?php namespace Eternity2\Attachment;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentCategory {

	protected $name;
	protected $acceptedExtensions = [];
	protected $maxFileSize = INF;
	protected $maxFileCount = INF;

	function __construct($name) {
		$this->name = $name;
	}

	public function acceptExtensions(...$extensions): self {
		$this->acceptedExtensions = array_map(function ($ext) { return strtolower($ext); }, $extensions);
		return $this;
	}

	public function maxFileSize(int $maxFileSizeInBytes): self {
		$this->maxFileSize = $maxFileSizeInBytes;
		return $this;
	}

	public function maxFileCount(int $maxFileCount): self {
		$this->maxFileCount = $maxFileCount;
		return $this;
	}

	/** @return string[] */
	public function getAcceptedExtensions() { return $this->acceptedExtensions; }

	/** @return int */
	public function getMaxFileSize() { return $this->maxFileSize; }

	/** @return string */
	public function getName(): string { return $this->name; }

	public function isValidUpload(File $upload) {
		if ($upload->getSize() > $this->maxFileSize) return false;
		$ext = $upload instanceof UploadedFile ? $upload->getClientOriginalExtension() : $upload->getExtension();
		if (!is_null($this->acceptedExtensions) && !in_array($ext, $this->acceptedExtensions)) return false;
		return true;
	}

	/** @return int */
	public function getMaxFileCount() { return $this->maxFileCount; }

}