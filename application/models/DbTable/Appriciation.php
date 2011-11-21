<?php

class Application_Model_DbTable_Appriciation extends Zend_Db_Table_Abstract
{
    protected $_name = 'appriciation';
    protected $_referenceMap = array (
            'User'=> array (
            'columns'=>'user_id',
            'refTableClass'=>'Application_Model_DbTable_User',
            'refColumns'=>'id'
            ),
            'AppriciationType'=> array (
            'columns'=>'appriciation_type_id',
            'refTableClass'=>'Application_Model_DbTable_AppriciationType',
            'refColumns'=>'id'
            )
            );
}
