<?php
class Security_Model_DbTable_SystemMapping extends Zend_Db_Table_Abstract {
    /**
     * @var string Name of the database table
     */
	protected $_name = 'system_mapping';
        protected $_primary = array('map_code', 'map_id1', 'map_id2');
	
}
