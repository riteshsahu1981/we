<?php
class Album_Model_DbTable_UserAlbum extends Zend_Db_Table_Abstract
{
    protected $_name = 'user_album';
    protected $_referenceMap = array (
    'User'=> array (
    'columns'=>'user_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    )
    );
    
}
