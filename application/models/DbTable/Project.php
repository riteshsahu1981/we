<?php

class Application_Model_DbTable_Project extends Zend_Db_Table_Abstract
{
    protected $_name = 'project';
    protected $_dependentTables = array ('Application_Model_DbTable_ProjectUser');
}
