<?php
class Security_Model_DbTable_SystemMaster extends Zend_Db_Table_Abstract {
    /**
     * @var string Name of the database table
     */
	protected $_name = 'system_master';
        protected $_primary = array('master_id', 'master_code');
	
}
