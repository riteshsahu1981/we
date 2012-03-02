<?php

class Application_Model_DbTable_Practicalities extends Zend_Db_Table_Abstract {
	
	protected $_name = 'practicalities';
	
	protected $_referenceMap = array (
    'Destination'=> array (
    'columns'=>'destination_id',
    'refTableClass'=>'Application_Model_DbTable_Practicalities',
    'refColumns'=>'id'
    )
  
    );
    
}