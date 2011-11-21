<?php

class Application_Model_DbTable_UserLeaveAccount extends Zend_Db_Table_Abstract
{
    protected $_name = 'user_leave_account';
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    ),
    'LeaveType'=> array (
    'columns'=>'leave_type_id',
    'refTableClass'=>'Application_Model_DbTable_LeaveType',
    'refColumns'=>'id'
    )    
    );
}
