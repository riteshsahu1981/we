<?php

class Application_Model_DbTable_DontLeaveWithout extends Zend_Db_Table_Abstract {
	
	protected $_name = 'dont_leave_without';
	
	protected $_referenceMap = array (
    'Destination'=> array (
    'columns'=>'destination_id',
    'refTableClass'=>'Application_Model_DbTable_Destination',
    'refColumns'=>'id'
    )
  
    );
    
}