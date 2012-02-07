<?php

class Application_Model_DbTable_Area extends Zend_Db_Table_Abstract
{
    protected $_name = 'area';
    
    protected $_referenceMap = array (
	    'City'=> array (
	    'columns'=>'city_id',
	    'refTableClass'=>'Application_Model_DbTable_City',
	    'refColumns'=>'id'
	    ), 
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
