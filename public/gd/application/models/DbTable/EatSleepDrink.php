<?php

class Application_Model_DbTable_EatSleepDrink extends Zend_Db_Table_Abstract {
	
	protected $_name = 'eat_sleep_drink';
	
	protected $_referenceMap = array (
    'Destination'=> array (
    'columns'=>'destination_id',
    'refTableClass'=>'Application_Model_DbTable_EatSleepDrink',
    'refColumns'=>'id'
    )
  
    );
    
}