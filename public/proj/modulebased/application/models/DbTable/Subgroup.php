<?php

class Application_Model_DbTable_Subgroup extends Zend_Db_Table_Abstract
{
    protected $_name = 'subgroup';
    protected $_dependentTables = array ('Application_Model_DbTable_User');
}
