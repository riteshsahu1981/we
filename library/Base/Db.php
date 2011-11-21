<?php
class Base_Db{
	
	public function __construct()
    {
    
    }
	
    public function getTotalRecords($table,$where=null)
    {
        $dbTable=Zend_Registry::get('db');
        $dbTable->setFetchMode(Zend_Db::FETCH_ASSOC);
        $select = $dbTable->select()->from($table,'COUNT(*) AS num')->where($where);
        $result = $dbTable->fetchRow($select);
        return 	$result['num'];
	}
	
	
 
}