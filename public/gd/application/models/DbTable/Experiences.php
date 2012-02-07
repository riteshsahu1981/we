<?php

class Application_Model_DbTable_Experiences extends Zend_Db_Table_Abstract {
	
	protected $_name = 'experiences';
	
	protected $_referenceMap = array (
    'Destination'=> array (
    'columns'=>'destination_id',
    'refTableClass'=>'Application_Model_DbTable_Destination',
    'refColumns'=>'id'
    )
  
    );
    
}