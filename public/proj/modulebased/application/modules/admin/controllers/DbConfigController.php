<?php
class Admin_DbConfigController extends Base_Controller_Action{
    public function databaseConfigsAction(){
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->search="Search...";
               if($search<>"" && $search<>"Search...")
        {
                    $where="(db_server_name like '%{$search}%' or db_name like '%{$search}%' or db_user like '%{$search}%')";
                    $this->view->search=$search;
        }
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $model=new Application_Model_DatabaseConfig();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from('dbconfiguration')
                 ->order('dbcnf_id ASC')->where($where);
        $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
        
    }
    public function addNewDbConfigAction(){
        $request = $this->getRequest();
        $form    = new Application_Form_DbConfig();
         if ($request->isPost())
        {
            $options=$request->getPost();

            if ($form->isValid($options))
            { 
                //$options['status']='active';
                             
                $model=new Application_Model_DatabaseConfig($options);
                $id=$model->save();
                if($id)  
                {    
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Db Configuration added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/db-config/add-new-db-config'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Config!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/db-config/add-new-db-config'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
    }
    public function editConfigAction(){
        $configId = $this->_getParam('id');
        $this->view->dbcnf_id = $configId;
        $model1 = new Application_Model_DatabaseConfig();
        $model = $model1->find($configId);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/db-config/databaceConfigs'));  
        }
        $options['configId'] = $model->getConfigId();
        $options['dbServerName'] = $model->getDbServerName();
        $options['dbServerPort']      = $model->getDbServerPort();
        $options['dbUser'] = $model->getdbUser();
        $options['dbName'] = $model->getDbName();
        $options['dbPassword'] = $model->getDbPassword();
        $options['dbTransType'] = $model->getDbTransType();
        $options['status'] = $model->getStatus();
        
        $request = $this->getRequest();
        $form    = new Application_Form_DbConfig();
        $form->populate($options);
        $options=$request->getPost();
  
        if ($request->isPost()) 
        { 
           
            if ($form->isValid($options))
            {
               $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'DB Cionfiguration has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/db-config/edit-Config/id/'.$configId));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=$form;    
    }
    public function deleteConfigAction(){
         $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->dbcnf_id = $id;
        $model1 = new Application_Model_DatabaseConfig();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/data-baseConfig/database-configs'));  
        }
      
        
       if($model->delete("dbcnf_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/db-config/database-configs'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/db-config/database-configs'));  
       }
    }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
