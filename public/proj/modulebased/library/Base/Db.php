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
    
    public function genId($table_name, $primary_key_id_name, $row_max_id_name="row_max_id", $row_version_name="row_version", $min_id_value="-2147483648")
    {
        $dbTable=Zend_Registry::get('db');
       
        $select = $dbTable->select()
                ->from($table_name, array('id'=>$primary_key_id_name, 'row_version'=>$row_version_name, 'row_max_id'=>$row_max_id_name) )
                ->where("{$primary_key_id_name}='{$min_id_value}'");
                //echo $select->__toString();
                
        $result = $dbTable->fetchRow($select);
        
        $new_row_version=$result->row_version +1;
        $new_max_id = $result->row_max_id + 1;
        
        $no_of_rows_effected=$dbTable->update($table_name, array($row_max_id_name=>$new_max_id, $row_version_name=>$new_row_version  ), "{$row_version_name}='{$result->row_version}' and {$primary_key_id_name}='{$result->id}'");
        if(1===$no_of_rows_effected)
            return $new_max_id;
        else
            return false;       
    }
    
    public function genSystemMasterId($master_code)
    {
       $model=new Security_Model_SystemMaster();
       $table=$model->getMapper()->getDbTable();
        $select = $table->select()->from(array("a"=>'system_master'), array('max_id'=>'MAX(master_id)'))
                ->where("master_code='$master_code'");
        $row=$table->fetchRow($select );
        $max_id=$row->max_id + 1 ;
        return $max_id;
         //echo $select->__toString(); exit;
       
    }
	
	
 
}