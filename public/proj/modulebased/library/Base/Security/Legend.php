<?php
class Base_Security_Legend 
{
    public function getLegends($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdLegends'");
    }
        
    public function getLegendsValue($legend_id, $status=1)
    {
        $model=new Security_Model_SystemMapping();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'system_mapping'), array('map_code','group_id'=>'map_id1','legend_value_id'=>'map_id2'))
                ->join(array("b"=>'system_master'),"a.map_id2=b.master_id and b.master_code='fdLegendsVal'" ,array('legend_value_title'=>'master_value', 'master_code'))
                ->where("a.status='{$status}' and a.map_code='fdLegendsLegendsValMap' and a.map_id1='$legend_id'");
                //echo $select->__toString(); exit;
                
        return $table->fetchAll($select);
    }
    
    
    public function getLegendsArray($status=1)
    {
        $arr=array("0"=>"--Select--");
        $groups=$this->getLegends($status);
        foreach($legends as $_legend)
        {
            $arr[$_legend->getMasterId()]=$_legend->getMasterValue();
        }
        return $arr;
    }
    
    public function getLagendsValueArray($legend_id, $status=1)
    {
        $arr=array("0"=>"--Select--");
        $legendsValue=$this->getLegendsValue($legend_id, $status);
        
        foreach($legendsValue as $_legendsValue)
        {
            $arr[$_legendsValue->legend_value_id]=$_legendsValue->legend_value_title;
        }
        return $arr;
    }
   
    
}