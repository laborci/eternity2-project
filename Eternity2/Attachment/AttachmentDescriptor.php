<?php namespace Eternity2\Attachment;

use mysql_xdevapi\Exception;
use SQLite3;

class AttachmentDescriptor {

	/** @var AttachmentCategory[] */
	private $categories = [];
	/** @var SQLite3 */
	private $metaDBConnection;

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

	public function addCategory($name) {
		$category = new AttachmentCategory($name, $this);
		$this->categories[$category->getName()] = $category;
	}

	public function getPath() { return $this->path; }
	public function getUrl() { return $this->url; }
	public function getCategories() { return $this->categories; }

	public function getMetaManager() {
		if (is_null($this->metaManager))$this->metaManager = new AttachmentMetaManager($this->metaFile);
		return $this->metaManager;
	}

	public function getCategory($category):AttachmentCategory {
		if (array_key_exists($category, $this->categories)) return $this->categories[$category];
		else throw new Exception("Attachment category not found");
	}

	public function hasCategory($category){
		return array_key_exists($category, $this->categories);
	}

	public function getMetaDBConnection() {
		if (is_null($this->metaDBConnection)) {
			if (!file_exists($this->metaFile)) {
				$connection = new SQLite3($this->metaFile);
				$connection->exec("
						begin;
						create table file
						(
							path text,
							file text,
							size int,
							meta text,
							description text,
							category text,
							constraint file_pk
								primary key (path, file)
						);
						
						create index path_index
							on file (path);
						commit;");
				$connection->close();
			}
			$this->metaDBConnection = new SQLite3($this->metaFile);
		}
		return $this->metaDBConnection;
	}

}