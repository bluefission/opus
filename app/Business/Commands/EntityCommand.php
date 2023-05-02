<?php
namespace App\Business\Commands;

use BlueFission\Framework\Command\BaseCommand;
use BlueFission\Bot\NaturalLanguage\EntityExtractor;

class EntityCommand extends BaseCommand
{
    private $_extractor;

    protected $_name = 'entity';
    protected $_actions = ['do', 'list', 'get', 'find', 'help'];

    public function __construct()
    {
        $this->_extractor = new EntityExtractor();
        parent::__construct();
    }

    protected function execute($args)
    {
        $statement = implode(' ', $args);

        $extractor = $this->_extractor;
        $methods = [
            'hex',
            'email',
            'web',
            'phone',
            'date',
            'time',
            'name',
            'object',
            'number',
            'adverb',
            'mentions',
            'tags',
            'values',
            'operation'
        ];

        $entities = [];
        $found = [];

        foreach ($methods as $method) {
             $found = $extractor->$method($statement);

             if (!empty($found)) {
                $entities[$method] = $found;
             }
        }

        $this->_entries = $entities;

        var_dump($this->_entries);
        $this->store();

        $this->_response = "Collected ".count($entities)." classes of entity.".PHP_EOL;
    }
}