<?php

class Application_Model_DbTable_Attendance extends Zend_Db_Table_Abstract
{
    protected $_name = 'attendance';
    protected $_referenceMap = array (
            'User'=> array (
            'columns'=>'=user_id',
            'refTableClass'=>'Application_Model_DbTable_User',
            'refColumns'=>'id'
            )   
            );
}
