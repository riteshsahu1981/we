<?php
class Security_PrivilegeController extends Base_Controller_Action
{

    public function indexAction()
    { 
        
    }
    public function ajaxGetSubGroupAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $group_id=$this->_getParam('group_id');
        
        $objPrivilege = new Base_Security_Privilege();
        $subgroups=$objPrivilege->getSubGroupArray($group_id);
        echo Zend_Json::encode($subgroups);
    }
    
    public function ajaxGetRoleAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $sub_group_id=$this->_getParam('sub_group_id');
        
        $objPrivilege = new Base_Security_Privilege();
        $roles=$objPrivilege->getRoleArray($sub_group_id);
        echo Zend_Json::encode($roles);
    }
    
    public function createAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $parent_node_id=$this->_getParam('parent_node_id');
        $child_master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$parent_node_id);
        $parent_master_code=$arrNode[0];
        $parent_master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        
        if($parent_master_code=="noderoot")
        {
            // create group
            $child_master_code="fdUserGroup";
            
            
        }else if($parent_master_code=="fdUserGroup")
        {
            //create sub group
            $child_master_code="fdUserSubGroup";
            $map_code="fdGroupSubGroupMap";
        }
        else if($parent_master_code=="fdUserSubGroup")
        {
            //create new role
            $child_master_code="fdUserRole";
            $map_code="fdSubGroupRoleMap";
        }
        $model->setMasterCode($child_master_code);
        $model->setMasterValue($child_master_value);
        $node_id=$model->save();
        if($parent_master_code!=="noderoot")
        {
            //mapping start
            $objMapping=new Security_Model_SystemMapping();
            $objMapping->setMapId1($parent_master_id);
            $objMapping->setMapId2($node_id);
            $objMapping->setMapCode($map_code);
            if(true===$objMapping->save())
            {
                $result=Zend_Json::encode(array("status"=>true, "node_id"=>$child_master_code."_".$node_id));
            }
            else
            {
                $result=Zend_Json::encode(array("status"=>false));
            }
        }
        else
        {
            if($node_id)
                $result=Zend_Json::encode(array("status"=>true, "node_id"=>$child_master_code."_".$node_id));
            else
                $result=Zend_Json::encode(array("status"=>false));
        }
        echo $result;
    }
    
    
    
    public function renameAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $node_id=$this->_getParam('node_id');
        $master_value=$this->_getParam('node_title');
        $arrNode=explode("_",$node_id);
        $master_code=$arrNode[0];
        $master_id=$arrNode[1];
        $model=new Security_Model_SystemMaster();
        $master=$model->fetchRow("master_code='{$master_code}' and master_id='{$master_id}'");
        $master->setMasterValue($master_value);
        if($master->save())
            $result=Zend_Json::encode(array("status"=>true));
        else
            $result=Zend_Json::encode(array("status"=>false));
        echo $result;        
    }
    
    
    public function removeAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $child_node_id=$this->_getParam('child_node_id');
        $arrChildNode=explode("_",$child_node_id);
        $child_master_code=$arrChildNode[0];
        $child_master_id=$arrChildNode[1];
        
        $parent_node_id=$this->_getParam('parent_node_id');
        $arrParentNode=explode("_",$parent_node_id);
        $parent_master_code=$arrParentNode[0];
        $parent_master_id=$arrParentNode[1];
        
        if($child_master_code=="fdUserRole")
        {
            //delete role
            $objMap=new Security_Model_SystemMapping();
            $objMap->delete("map_code='fdSubGroupRoleMap' and map_id1='{$parent_master_id}' and map_id2='{$child_master_id}'");

            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
        }
        else if($child_master_code=="fdUserSubGroup")
        {
            //fetch roles and delete them
            $objMap=new Security_Model_SystemMapping();
            $result=$objMap->fetchAll("map_code='fdSubGroupRoleMap' and map_id1='{$child_master_id}'");
            if(count($result)>0)
            {
                foreach($result as $_row )
                {
                    $objMaster=new Security_Model_SystemMaster();
                    $objMaster->delete("master_code='fdUserRole' and master_id='{$_row->getMapId2()}'");
                }
            }
            $objMap->delete("map_code='fdSubGroupRoleMap' and map_id1='{$child_master_id}'");
            
            // now delete sub group from master
            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
            
        }
        else if($child_master_code=="fdUserGroup")
        {
            // fetch sub groups and delete them
            $objMap=new Security_Model_SystemMapping();
            $result=$objMap->fetchAll("map_code='fdGroupSubGroupMap' and map_id1='{$child_master_id}'");
            if(count($result)>0)
            {
                foreach($result as $_row )
                {
                    //fetch roles and delete them
                    
                    $objMap1=new Security_Model_SystemMapping();
                    $result1=$objMap1->fetchAll("map_code='fdSubGroupRoleMap' and map_id1='{$_row->getMapId2()}'");
                    if(count($result1)>0)
                    {
                        foreach($result1 as $_row1 )
                        {
                            $objMaster=new Security_Model_SystemMaster();
                            $objMaster->delete("master_code='fdUserRole' and master_id='{$_row1->getMapId2()}'");
                        }
                    }
                    $objMap1->delete("map_code='fdSubGroupRoleMap' and map_id1='{$_row->getMapId2()}'");
                    
                    $objMaster=new Security_Model_SystemMaster();
                    $objMaster->delete("master_code='fdUserSubGroup' and master_id='{$_row->getMapId2()}'");
                }
            }
            
            $objMap->delete("map_code='fdGroupSubGroupMap' and map_id1='{$child_master_id}'");
             // now delete group from master
            $objMaster=new Security_Model_SystemMaster();
            $objMaster->delete("master_code='{$child_master_code}' and master_id='{$child_master_id}'");
            
        }
        echo $result=Zend_Json::encode(array("status"=>true));
        
    }
   
   
        
}
