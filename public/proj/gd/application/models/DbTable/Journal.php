<?php

class Application_Model_DbTable_Journal extends Zend_Db_Table_Abstract
{
    protected $_name = 'journal';
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    )
    );
    
}
