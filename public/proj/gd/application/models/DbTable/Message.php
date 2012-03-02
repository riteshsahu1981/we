<?php

/**
 * User table data gateway
 *
 * @uses   Zend_Db_Table_Abstract
 * @author 	Ritesh Kumar Sahu
 * @package QuickStart
 * @subpackage Model
 */

class Application_Model_DbTable_Message extends Zend_Db_Table_Abstract {
	/**
     * @var string Name of the database table
     */
	protected $_name = 'message';
	protected $_referenceMap = array (
    'To'=> array (
    'columns'=>'to_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    ),
    
    'From'=> array (
    'columns'=>'from_id',
    'refTableClass'=>'Application_Model_DbTable_User',
    'refColumns'=>'id'
    )
    );
		
}
