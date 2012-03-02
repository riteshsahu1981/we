<?php

class Application_Model_DbTable_Group extends Zend_Db_Table_Abstract
{
    protected $_name = 'group';
    protected $_dependentTables = array ('Application_Model_DbTable_User');
}
