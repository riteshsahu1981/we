<?php

class Application_Model_DbTable_Continent extends Zend_Db_Table_Abstract {
	
	protected $_name = 'continent';
	protected $_dependentTables = array ('Application_Model_DbTable_Country');
}