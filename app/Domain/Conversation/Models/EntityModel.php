<?php
namespace App\Domain\Conversation\Models;

use BlueFission\Framework\Model\ModelSql as Model;

class EntityModel extends Model {
	
	protected $_table = 'entities';
	protected $_fields = [
		'entity_id',
		'name',
		'label',
	];
}