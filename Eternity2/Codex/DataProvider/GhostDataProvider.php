<?php namespace Eternity2\Codex\DataProvider;

use Eternity2\Codex\ItemDataImporterInterface;
use Eternity2\Ghost\Ghost;
use Eternity2\Thumbnail\Thumbnail;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GhostDataProvider implements DataProviderInterface{

	protected $ghost;
	/** @var \Eternity2\Ghost\Model model */
	protected $model;

	public function __construct($ghost){
		$this->ghost = $ghost;
		$this->model = $this->ghost::$model;
	}

	public function getList($page, $sorting, $filter, $pageSize, &$count): array{
		$finder = $this->model->repository->search()->orderIf(!is_null($sorting), $sorting['field'] . ' ' . $sorting['dir']);
		return $finder->collectPage($pageSize, $page, $count);
	}

	public function convertItem($item): array{
		/** @var Ghost $item */
		return $item->export();
	}

	public function createFilter($filter){ return null; }

	public function getItem($id): ?Ghost{ return $this->model->repository->pick($id); }

	public function getNewItem(): Ghost{ return $this->model->createGhost(); }

	public function deleteItem($id){ return $this->model->repository->delete($id); }

	public function updateItem($id, array $data, ItemDataImporterInterface $itemDataImporter){
		/** @var Ghost $item */
		$item = $this->getItem($id);
		$item = $itemDataImporter->importItemData($item, $data);
		return $item->save();
	}

	public function createItem(array $data, ItemDataImporterInterface $itemDataImporter){
		/** @var Ghost $item */
		$item = $this->getNewItem();
		$item = $itemDataImporter->importItemData($item, $data);
		return $item->save();
	}

	public function importItemData($item, $data){
		/** @var Ghost $item */
		$item->import($data);
		return $item;
	}

	public function uploadAttachment($id, $category, UploadedFile $file){
		$item = $this->getItem($id);
		$categoryManager = $item->getAttachmentCategoryManager($category);
		$categoryManager->addFile($file);
	}

	public function getAttachments($id): array{
		$item = $this->getItem($id);
		$categories = $item->getAttachmentCategories();
		$collection = [];
		foreach ($categories as $category){
			$attachments = $item->getAttachmentCategoryManager($category->getName())->all;
			$collection[$category->getName()] = [];
			foreach ($attachments as $attachment){
				$record = $attachment->getRecord();
				if ($record['mime-base'] === 'image'){
					$record['thumbnail'] = in_array($record['mime-detail'], ['png', 'gif', 'jpg', 'jpeg']) ? $attachment->thumbnail->crop(100, 100)->png : $attachment->url;
				}
				$collection[$category->getName()][] = $record;
			}
		}
		return $collection;
	}
}

