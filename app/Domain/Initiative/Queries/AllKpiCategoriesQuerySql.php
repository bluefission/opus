<?php
namespace App\Domain\Initiative\Queries;

use BlueFission\Connections\Database\MysqlLink;
use App\Domain\Initiative\Models\KpiCategoryModel as Model;

use App\Domain\Initiative\Queries\IAllKpiCategoriesQuery;

class AllKpiCategoriesQuerySql implements IAllKpiCategoriesQuery {
	private $_model;

	public function __construct( MysqlLink $link, Model $model )
	{
		$link->open();

		$this->_model = $model;
	}

	public function fetch() 
	{
		$model = $this->_model;
		$model->read();
		$data = $model->result()->toArray();
		return $data;
	}
}