<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';
    protected $_referenceMap = array (
    'Country'=> array (
    'columns'=>'parent_id',
    'refTableClass'=>'Application_Model_DbTable_Category',
    'refColumns'=>'id'
    )
    );
}