<?php
namespace BlueFission\Framework\Model;

use BlueFission\Framework\Model\BaseModel;
use BlueFission\Data\Storage\MysqlBulk;

class ModelSql extends BaseModel {

	protected $_table = '';
	protected $_fields = [];

	protected $_autojoin = false;

	public function __construct( )
	{
		$this->_type = get_class($this);
		$this->_dataObject = new MysqlBulk([
			'name'=>$this->_table,
			'fields'=>$this->_fields,
			'auto_join'=>$this->_autojoin
		]);
		$this->init();
	}

	protected function init()
	{
		// With inheritance, configure the model here 
	}

	public function result()
	{
		return $this->_dataObject->result();
	}

	public function query()
	{
		return $this->_dataObject->query();
	}
}