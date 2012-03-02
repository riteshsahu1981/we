<?php

class Application_Model_DbTable_Region extends Zend_Db_Table_Abstract
{
    protected $_name = 'region';
    protected $_dependentTables = array ('Application_Model_DbTable_City');
    
    protected $_referenceMap = array (
    'Country'=> array (
    'columns'=>'country_id',
    'refTableClass'=>'Application_Model_DbTable_Country',
    'refColumns'=>'id'
    ),
    
    'Continent'=> array (
    'columns'=>'continent_id',
    'refTableClass'=>'Application_Model_DbTable_Continent',
    'refColumns'=>'id'
    )
    
    );
}
