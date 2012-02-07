<?php

class Application_Model_DbTable_State extends Zend_Db_Table_Abstract
{
    protected $_name = 'state';
    protected $_dependentTables = array ('Application_Model_DbTable_City' , 'Application_Model_DbTable_User');
    
    protected $_referenceMap = array (
    'Region'=> array (
    'columns'=>'region_id',
    'refTableClass'=>'Application_Model_DbTable_Region',
    'refColumns'=>'id'
    )
    );
    
}
