<?php

class Application_Model_DbTable_FriendGroup extends Zend_Db_Table_Abstract
{
    protected $_name = 'friend_group';
    protected $_dependentTables = array ('Application_Model_DbTable_UserPermission','Application_Model_DbTable_Friend');
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    )
    );
}
