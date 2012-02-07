<?php

/**
 * User table data gateway
 *
 * @uses   Zend_Db_Table_Abstract
 * @author 	Ritesh Kumar Sahu
 * @package QuickStart
 * @subpackage Model
 */

class Cms_Model_DbTable_BannerHistory extends Zend_Db_Table_Abstract {
	/**
     * @var string Name of the database table
     */
	protected $_name = 'BannerHistory';
        
        public $tableStructure=Array(
		'tableName'     => 'BannerHistory',
		'bannerId'      => 'BId',
		'showUrl'       => 'ShowUrl',
		'ipAddress'     => 'Ips',
		'displayed'     => 'Displayed',
		'type'          => 'Type',
		'click'         => 'Click'
		);

}
