<?php namespace Application\Module\Admin\Service;

interface CodexDataProvider{

	public function getList($page, $sorting, $filter, $pageSize, $fields, $rowConverter);

}