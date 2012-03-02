<?php
class Base_Security_Menu 
{
    public function getMenuItems($status=1)
    {
        $model=new Security_Model_SystemMaster();
        return $model->fetchAll("status='{$status}' and master_code='fdMenu'");
    }
        
    public function getMenuItemsArray($status=1)
    {
        $arr=array("0"=>"--Select--");
//        $menu_items =$this->getMenuItems($status);
//        
//        foreach($menu_items as $_menu_item)
//        {
//            $arr[$_menu_item->getMasterId()]=$_menu_item->getMasterValue();
//        }
//        return $arr;
        
        
        $pages=$this->getChildPages(0,0);
        foreach($pages as $_page)
        {
            $arr[$_page['menu_id']]=$_page['menu_sno'].". ".$_page['menu_title'];
            
        }
        return $arr;
    }
    
    public function delgetChildPages($parent_id)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'");

        $arrParentResult=array();
        if(count($result)>0)
        {
            foreach($result as $row)
            {
                    $i=count($arrParentResult);
                    $arrParentResult[$i]['menu_id']=$row->getMasterId();
                    $arrParentResult[$i]['menu_title']=$row->getMasterValue();
                    $arrParentResult[$i]['menu_code']=$row->getMasterCode();
                    $arrParentResult[$i]['menu_is_active']=$row->getStatus();
                    $arrParentResult[$i]['menu_parent_id']=$parent_id;
                    $arrParentResult[$i]['menu_is_child']=$row->getBlnval1();
                    $arrParentResult[$i]['menu_path']=$row->getStrval1();

                    $arrChildResult=$this->getChildPages($row->getMasterId());
                    $arrParentResult[$i]['menu_childs']=array();
                    if(count($arrChildResult)>0)
                    {
                        $arrParentResult[$i]['menu_childs']=$arrChildResult;
                    }
                    
            }
        }
        
        return $arrParentResult;
    }
    public function getChildPages($parent_id, $psno)
    {
        $model=new Security_Model_SystemMaster();
        $result=$model->fetchAll("master_code='fdMenu' and intval1='$parent_id'");

        $arrParentResult=array();
        if(count($result)>0)
        {
            $sno=0;
            
            foreach($result as $row)
            {
                $sno++;
                if($psno == "0" )
                    $snod=$sno;
                 else
                    $snod=$psno.".".$sno;
                
                    $i=count($arrParentResult);
                    $arrParentResult[$i]['menu_sno']=$snod;
                    $arrParentResult[$i]['menu_id']=$row->getMasterId();
                    $arrParentResult[$i]['menu_title']=$row->getMasterValue();
                    $arrParentResult[$i]['menu_code']=$row->getMasterCode();
                    $arrParentResult[$i]['menu_is_active']=$row->getStatus();
                    $arrParentResult[$i]['menu_parent_id']=$parent_id;
                    $arrParentResult[$i]['menu_is_child']=$row->getBlnval1();
                    $arrParentResult[$i]['menu_path']=$row->getStrval1();

                    $arrChildResult=$this->getChildPages($row->getMasterId(), $snod);
                    //$arrParentResult[$i]['menu_childs']=array();
                    if(is_array($arrChildResult))
                       $arrParentResult = array_merge($arrParentResult,$arrChildResult);
//                    if(count($arrChildResult)>0)
//                    {
//                        $arrParentResult[$i]['menu_childs']=$arrChildResult;
//                    }
                    
            }
        }
        
        return $arrParentResult;
    }
    
    public function hasChild($arrChild)
    {
        if(count($arrChild)>0)
            return true;
        else
            return false;
    }
 
    public function getChildGrid($arrChild, $psno)
    {
        if($this->hasChild($arrChild))
        {
            $sno=0;
            
            foreach($arrChild as $_child)
            {
                $has_childs=$this->hasChild($_child['menu_childs']);
                
                $sno++;
                $snod=$psno.".".$sno;
                $str.="<tr class='child_".$_child['menu_parent_id']."' >";
                $str.="<td>  ".$snod."</td>";
                $str.="<td>".$_child['menu_id']."</td>";
                $str.="<td>".$_child['menu_title']."</td>";
                $str.="<td>".$_child['menu_path']."</td>";
                
                $str.="<td>".$_child['menu_parent_id']."</td>";
                $str.="<td>".($_child['menu_is_active']==0 ? "No" : "Yes")."</td>";
                $str.="<td>".($_child['menu_is_child']==0 ? "No" : "Yes")."</td>";
                
                if($has_childs)
                {
                    $str.=$this->getChildGrid($_child['menu_childs'], $snod);
                }
                $str.="</tr>";
            }
            
        }
        return $str;
    }
    
    
    public function changeStatus($id, $status)
    {
        $model=new Security_Model_SystemMaster();
        $row=$model->fetchRow("master_id='{$id}' and master_code='fdMenu'");
        if(false===$row)
            return false;
        
        $row->setStatus($status);
        return $row->save();
        
    }
    
    public function changeChildStatus($id, $status)
    {
        $model=new Security_Model_SystemMaster();
        $row=$model->fetchRow("master_id='{$id}' and master_code='fdMenu'");
        if(false===$row)
            return false;
        
        $row->setBlnval1($status);
        return $row->save();
    }
}