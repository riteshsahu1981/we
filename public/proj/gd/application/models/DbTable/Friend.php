<?php

class Application_Model_DbTable_Friend extends Zend_Db_Table_Abstract
{
    protected $_name = 'friend';
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    ),
    
      'Friend'=> array (
    'columns'=>'friend_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    )
    );
    
}