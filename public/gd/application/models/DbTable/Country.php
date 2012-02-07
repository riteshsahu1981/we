<?php

class Application_Model_DbTable_Country extends Zend_Db_Table_Abstract {
	
	protected $_name = 'country';
	protected $_dependentTables = array ('Application_Model_DbTable_Region');
	
	protected $_referenceMap = array (
    'Continent'=> array (
    'columns'=>'continent_id',
    'refTableClass'=>'Application_Model_DbTable_Continent',
    'refColumns'=>'id'
    )
    
    );
    
}