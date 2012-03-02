<?php

class Application_Model_DbTable_Poi extends Zend_Db_Table_Abstract {
	
	protected $_name = 'poi';
	
	protected $_referenceMap = array (
    'Continent'=> array (
    'columns'=>'location_id',
    'refTableClass'=>'Application_Model_DbTable_Continent',
    'refColumns'=>'id'
    ),
    'Country'=> array (
    'columns'=>'location_id',
    'refTableClass'=>'Application_Model_DbTable_Country',
    'refColumns'=>'id'
    ),
    'City'=> array (
    'columns'=>'location_id',
    'refTableClass'=>'Application_Model_DbTable_City',
    'refColumns'=>'id'
    )
    );
    
}