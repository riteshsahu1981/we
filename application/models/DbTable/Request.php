<?php

class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract
{
    protected $_name = 'request';
    protected $_referenceMap = array (
            'RequestedBy'=> array (
            'columns'=>'requested_by',
            'refTableClass'=>'Application_Model_DbTable_User',
            'refColumns'=>'id'
            ),
            'User'=> array (
            'columns'=>'user_id',
            'refTableClass'=>'Application_Model_DbTable_User',
            'refColumns'=>'id'
            ),
            'Department'=> array (
            'columns'=>'department_id',
            'refTableClass'=>'Application_Model_DbTable_Department',
            'refColumns'=>'id'
            )
            );
}
