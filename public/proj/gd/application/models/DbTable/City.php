<?php

class Application_Model_DbTable_City extends Zend_Db_Table_Abstract
{
    protected $_name = 'city';
    protected $_dependentTables = array ('Application_Model_DbTable_Area');
    protected $_referenceMap = array (
    'Region'=> array (
    'columns'=>'region_id',
    'refTableClass'=>'Application_Model_DbTable_Region',
    'refColumns'=>'id'
    ),
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
