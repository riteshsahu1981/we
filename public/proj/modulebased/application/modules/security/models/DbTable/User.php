<?php

/**
 * User table data gateway
 *
 * @uses   Zend_Db_Table_Abstract
 * @author 	Ritesh Kumar Sahu
 * @package QuickStart
 * @subpackage Model
 */

class Security_Model_DbTable_User extends Zend_Db_Table_Abstract {
	/**
     * @var string Name of the database table
     */
	protected $_name = 'user';
	
}
