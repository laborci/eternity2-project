<?php namespace Eternity2\Attachment;

use Symfony\Component\HttpFoundation\File\File;


class AttachmentCategoryManager {

//	/** @var  Attachment[] */
//	protected $attachments = null;
//
//	/** @var Config */
//	protected $config;
//
//	protected $path;
//	protected $pathId;
//	protected $urlBase;
//	protected $owner;
//	protected $descriptor;
//
//	public function getPath(): string { return $this->path; }
//	public function getDescriptor(): string { return $this->descriptor; }
//	public function getPathId(): string { return $this->pathId; }
//	public function getUrlBase(): string { return $this->urlBase; }
//	public function getOwner(): string { return $this->owner; }
//

	protected $ownerPath;
	protected $path;
	protected $url;

	/** @var Attachment[] */
	protected $attachments = null;
	/** @var AttachmentDescriptor */
	private $descriptor;
	/** @var \Eternity2\Attachment\AttachmentCategory */
	private $category;

	public function __construct(AttachmentCategory $category, $ownerPath){
		$this->category = $category;
		$this->ownerPath = $ownerPath;
		$this->descriptor = $category->getDescriptor();
		$this->category = $category;
		$this->path = $this->descriptor->getPath() . $ownerPath;
		$this->url = $this->descriptor->getUrl() . $ownerPath;
	}

	public function addFile(File $file){

	}

	public function removeFile($filename){

	}

	public function collect(){

	}

//	public function getFiles(): array {
//		$files = glob($this->path . '/*');
//		$attachments = [];
//		foreach ($files as $file) {
//			$attachment = new Attachment($file);
//			$attachments[$attachment->getFilename()] = $attachment;
//		}
//		return $attachments;
//	}

	public function addFile(File $file, $category) {
		$category = $this->descriptor->getCategory($category);

//		if ($category->getAttachmentCount() >= $this->descriptor->getMaxFileCount() && !$replace) {
//			throw new Exception("Too many files", Exception::FILE_COUNT_ERROR);
//		} else if ($file->getSize() > $this->descriptor->getMaxFileSize()) {
//			throw new Exception("Too big file", Exception::FILE_SIZE_ERROR);
//		} else if (is_array($this->descriptor->getAcceptedExtensions()) && !in_array($file->getExtension(), $this->descriptor->getAcceptedExtensions())) {
//			throw new Exception("File type is not accepted", Exception::FILE_TYPE_ERROR);
//		} else {
//		if ($this->descriptor->getMaxFileCount() == 1 && $this->getAttachmentCount() == 1 && $replace) {
//			$this->first->delete();
//		}


		if (!is_dir($this->path)) mkdir($this->path, 0777, true);
		copy($file->getPath() . '/' . $file->getFilename(), $this->path . $file->getFilename());
		$this->attachments = null;

		$attachment = new Attachment($file->getFilename(), $this->ownerPath, $this->descriptor, [$category->getName()], $file->getSize());
		$attachment->storeMeta();

//		$this->owner->attachmentAdded($file->getFilename());
		return true;
	}

	/**
	 * @return \Eternity2\Attachment\Attachment[]
	 */
	public function getAttachments(): array{
		if(is_null($this->attachments)){
			$records = $this->descriptor->getMetaManager()->collect($this->ownerPath);
			$this->attachments = [];
			foreach ($records as $record){

			}
		}
		return $this->attachments;
	}

//
//
//	/**
//	 * @return Attachment[]
//	 */
//	public function getAttachments() {
//		if (is_null($this->attachments)) $this->collect();
//		return $this->attachments;
//	}
//
//	/**
//	 * @param $filename
//	 * @return null|Attachment
//	 */
//	public function getAttachment($filename) {
//		$attachments = $this->getAttachments();
//		foreach ($attachments as $attachment) {
//			if ($attachment->getFilename() === $filename) return $attachment;
//		}
//		return null;
//	}
//
//	public function getAttachmentCount() {
//		return count($this->getAttachments());
//	}
//
//	public function hasAttachments() {
//		return (bool)count($this->getAttachments());
//	}
//
//
//	public function uploadFile(UploadedFile $file, $replace = false) {
//		if ($this->getAttachmentCount() >= $this->descriptor->getMaxFileCount() && !$replace) {
//			throw new Exception("Max number of files: " . $this->descriptor->getMaxFileCount(), Exception::FILE_COUNT_ERROR);
//		} else if ($file->getClientSize() > $this->descriptor->getMaxFileSize()) {
//			throw new Exception("Max size of files: " . $this->descriptor->getMaxFileSize() . 'bytes', Exception::FILE_SIZE_ERROR);
//		} else if (is_array($this->descriptor->getAcceptedExtensions()) && !in_array($file->getClientOriginalExtension(), $this->descriptor->getAcceptedExtensions())) {
//			throw new Exception("Acceptable filetypes are: " . join(', ', $this->descriptor->getAcceptedExtensions()), Exception::FILE_TYPE_ERROR);
//		} else {
//			if ($this->descriptor->getMaxFileCount() == 1 && $this->getAttachmentCount() == 1 && $replace) {
//				$this->first->delete();
//			}
//			$file->move($this->path, $file->getClientOriginalName());
//			$this->owner->attachmentAdded($this, $file->getClientOriginalName());
//			$this->attachments = null;
//			return true;
//		}
//	}
//
//	public function addFile(File $file, $replace = false) {
//		if ($this->getAttachmentCount() >= $this->descriptor->getMaxFileCount() && !$replace) {
//			throw new Exception("Too many files", Exception::FILE_COUNT_ERROR);
//		} else if ($file->getSize() > $this->descriptor->getMaxFileSize()) {
//			throw new Exception("Too big file", Exception::FILE_SIZE_ERROR);
//		} else if (is_array($this->descriptor->getAcceptedExtensions()) && !in_array($file->getExtension(), $this->descriptor->getAcceptedExtensions())) {
//			throw new Exception("File type is not accepted", Exception::FILE_TYPE_ERROR);
//		} else {
//			if ($this->descriptor->getMaxFileCount() == 1 && $this->getAttachmentCount() == 1 && $replace) {
//				$this->first->delete();
//			}
//			copy($file->getPath() . '/' . $file->getFilename(), $this->path . $file->getFilename());
//			$this->owner->attachmentAdded($this, $file->getFilename());
//			$this->attachments = null;
//			return true;
//		}
//	}
//
//	//public function copyAttachment(Attachment $attachment) {
//	//	//TODO: should check like upload
//	//	copy($attachment->getFile(), $this->path.$attachment->getFilename());
//	//	$this->attachments = null;
//	//}
//
//
//	public function deleteFile($filename) {
//		$attachments = $this->getAttachments();
//		if (array_key_exists($filename, $attachments)) {
//			$attachments[$filename]->delete();
//			unset($attachments[$filename]);
//		}
//	}
//
//	protected function collect() {
//		$files = glob($this->getPath() . '/*');
//		$attachments = [];
//		foreach ($files as $file) {
//			$attachment = new Attachment($file, $this);
//			$attachments[$attachment->getFilename()] = $attachment;
//		}
//		$this->attachments = $attachments;
//		return $attachments;
//	}
//
//	public function __get($name) {
//		$attachments = $this->getAttachments();
//		switch ($name) {
//			case 'name':
//				return $this->descriptor->getName();
//				break;
//			case 'files':
//				return $attachments;
//				break;
//			case 'first':
//				if ($this->hasAttachments()) return reset($attachments);
//				else return null;
//				break;
//		}
//	}
//
//	public function __isset($name) {
//		return in_array($name, ['files', 'first']);
//	}



	public function DBstore($ownerPath, $file, $size, $meta, $description, $category){
		$statement = $this->descriptor->getMetaDBConnection()->prepare(
			"INSERT OR REPLACE INTO file (path, file, size, meta, description, category) 
						VALUES (:path, :file, :size, :meta, :description, :category)");
		$statement->bindParam(':path', $ownerPath);
		$statement->bindParam(':file', $file);
		$statement->bindParam(':size', $size, SQLITE3_INTEGER);
		$statement->bindParam(':description', $description);
		$statement->bindParam(':meta', json_encode($meta));
		$statement->bindParam(':category', json_encode($category));
		$statement->execute();
	}

	public function DBcollect($ownerPath, $category = null){

	}

	public function DBremove($ownerPath, $file, $category){

	}

}

