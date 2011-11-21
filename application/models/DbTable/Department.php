<?php

class Application_Model_DbTable_Department extends Zend_Db_Table_Abstract
{
    protected $_name = 'department';
    protected $_dependentTables = array ('Application_Model_DbTable_User', 'Application_Model_DbTable_Request');
}
