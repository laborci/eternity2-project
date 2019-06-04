<?php namespace Eternity2\RedFox\Attachment;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @property-read array $meta
 * @property-read Thumbnail $thumbnail
 * @property-read string $url
 * @property-read string $pathId
 */
class Attachment extends File {

	/** @var AttachmentManager  */
	protected $manager;
	protected $meta = null;

	public function __construct(string $file, AttachmentManager $manager) {
		parent::__construct($file);
		$this->manager = $manager;
	}

	public function __toString() { return $this->getUrl(); }
	public function getUrl(){ return $this->manager->getUrlBase().$this->getFilename(); }

	public function delete(){
		$this->deleteMetaFile();
		$this->thumbnail->purge();
		unlink($this->getPathname());
	}

	#region Meta
	public function getMeta($key){
		if(is_null($this->meta)) $this->loadMeta();
		if(array_key_exists($key, $this->meta)) return $this->meta[$key];
		else return null;
	}

	public function setMeta($key, $value){
		if(is_null($this->meta)) $this->loadMeta();
		if($value === '' || $value === null){
			$this->deleteMeta($key);
		}else{
			$this->meta[$key] = $value;
		}
		$this->saveMeta();
	}

	public function deleteMeta($key){
		unset($this->meta[$key]);
	}

	protected function deleteMetaFile(){
		$metafile = $this->getMetaFilepath();
		if(file_exists($metafile))unlink($metafile);
	}

	protected function loadMeta(){
		$metafile = $this->getMetaFilepath();
		if(!file_exists($metafile)){
			$this->meta = [];
		}else{
			$this->meta = json_decode(file_get_contents($metafile), true);
		}
	}

	protected function saveMeta(){
		$metafile = $this->getMetaFilepath();
		if(count($this->meta)) file_put_contents($metafile, json_encode($this->meta));
		elseif(file_exists($metafile)) unlink($metafile);
	}

	protected function getMetaFilepath(){
		return $this->getPath().'.'.$this->getFilename().'.json';
	}

	#endregion

	public function __get($name) {
		switch ($name) {
			case 'url':
				return $this->getUrl();
				break;
			case 'thumbnail':
				return new Thumbnail($this);
				break;
			case 'meta':
				if(is_null($this->meta)) $this->loadMeta();
				return $this->meta;
				break;
			case 'pathId':
				return $this->manager->getPathId();
				break;
		}
	}

	public function __isset($name) {
		return in_array($name, ['url', 'thumbnail', 'meta', 'pathId']);
	}
}
