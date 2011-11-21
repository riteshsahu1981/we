<?php

class Application_Model_DbTable_AppriciationType extends Zend_Db_Table_Abstract
{
    protected $_name = 'appriciation_type';
    protected $_dependentTables = array ('Application_Model_DbTable_Appriciation');
}
