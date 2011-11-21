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
	protected $_dependentTables = array ('Application_Model_DbTable_UserLeaveAccount', 'Application_Model_DbTable_Attendance', 'Application_Model_DbTable_Request', 'Application_Model_DbTable_Appriciation');
        protected $_referenceMap = array (
            'Designation'=> array (
            'columns'=>'designation_id',
            'refTableClass'=>'Application_Model_DbTable_Designation',
            'refColumns'=>'id'
            ),
             'Department'=> array (
            'columns'=>'department_id',
            'refTableClass'=>'Application_Model_DbTable_Department',
            'refColumns'=>'id'
            )  
            );
}
