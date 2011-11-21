<?php

class Application_Model_DbTable_Album extends Zend_Db_Table_Abstract
{
    protected $_name = 'album';
    protected $_dependentTables = array('Application_Model_DbTable_Pictures');
    protected $_referenceMap = array (
            'User'=> array (
            'columns'=>'user_id',
            'refTableClass'=>'Application_Model_DbTable_User',
            'refColumns'=>'id'
            )
           
            );
}
