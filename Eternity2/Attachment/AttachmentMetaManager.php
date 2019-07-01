<?php namespace Eternity2\Attachment;


use SQLite3;
use Symfony\Component\HttpFoundation\File\File;

class AttachmentMetaManager {

	/** @var SQLite3 */
	private $connection;
	private $metaFile;

	public function __construct($metaFile) {
		$this->metaFile = $metaFile;
	}

	protected function getConnection() {
		if (is_null($this->connection)) {
			if (!file_exists($this->metaFile)) {
				$this->connection = new SQLite3($this->metaFile);
				$this->connection->exec("
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
			}else{
				$this->connection = new SQLite3($this->metaFile);
			}
		}
		return $this->connection;
	}

	public function store($ownerPath, $file, $size, $meta, $description, $category){
		$statement = $this->getConnection()->prepare(
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

	public function collect($ownerPath, $category = null){

	}

	public function remove($ownerPath, $file, $category){

	}

}
