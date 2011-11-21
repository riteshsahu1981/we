<?php

class Application_Model_DbTable_Designation extends Zend_Db_Table_Abstract
{
    protected $_name = 'designation';
    protected $_dependentTables = array ('Application_Model_DbTable_User');
}
