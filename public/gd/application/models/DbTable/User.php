<?php

/**
 * User table data gateway
 *
 * @uses   Zend_Db_Table_Abstract
 * @author 	Ritesh Kumar Sahu
 * @package QuickStart
 * @subpackage Model
 */

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {
	/**
     * @var string Name of the database table
     */
	protected $_name = 'user';
	protected $_dependentTables = array ('Application_Model_DbTable_Journal','Application_Model_DbTable_UserPermission','Application_Model_DbTable_FriendGroup', 'Application_Model_DbTable_Wall', 'Application_Model_DbTable_Blog','Application_Model_DbTable_Feeds','Application_Model_DbTable_Friend','Application_Model_DbTable_Message');	
}
