<?php

class Application_Model_DbTable_UserPermission extends Zend_Db_Table_Abstract
{
    protected $_name = 'user_permission';
    
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    ),
    
    'FriendGroup'=> array (
    'columns'=>'friend_group_id',
    'refTableClass'=>'Application_Model_DbTable_FriendGroup',
    'refColumns'=>'id'
    ),
    
    'Permission'=> array (
    'columns'=>'permission_id',
    'refTableClass'=>'Application_Model_DbTable_Permission',
    'refColumns'=>'id'
    )
    
    
    );
}
