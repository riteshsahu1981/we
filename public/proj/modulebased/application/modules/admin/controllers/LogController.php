<?php
class Admin_LogController extends Base_Controller_Action
{
  
     public function indexAction()
    { 
        /*--search---*/
         $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
               if($search<>"" && $search<>"Search...")
        {
            $where="config_name like '%{$search}%'";
            $this->view->search=$search;
        }
       
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $model=new Application_Model_Log();
        $table=$model->getMapper()->getDbTable();
       // $select = $table->select()->setIntegrityCheck(false)->from('user_privilege',array('user_id', 'screen_id', 'action_id','menu_id'))->order('user_id ASC')->where($where);
        $select = $table->select()->setIntegrityCheck(false)->from('config')
                 ->order('config_id ASC')->where($where);
        
        $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
       // echo '<pre>'; print_r($paginator);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
    }
        
    public function addNewLogAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Log();
        
        if ($request->isPost())
        {
            $options=$request->getPost();

            if ($form->isValid($options))
            { 
                
                
                //$options['status']='active';
                             
                $model=new Application_Model_Log($options);
                $id=$model->save();
                if($id)  
                {    
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Configuration added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-new-log'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Config!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-new-log'));
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
    }//end of add-new-log function
    public function editLogAction()
    {
         $configId = $this->_getParam('configid');
        $this->view->config_id = $configId;
        $model1 = new Application_Model_Log();
        $model = $model1->find($configId);
        
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/log/index'));  
        }
        $options['parentConfigId']=$model->getParentConfigId();
        $options['configName'] = $model->getConfigName();
        $options['configDesc'] = $model->getConfigDesc();
        $options['param1'] = $model->getParam1();
        $options['param2'] = $model->getParam2();
        $options['param3'] = $model->getParam3();
        $options['param4'] = $model->getParam4();
        $options['param5'] = $model->getParam5();
        $options['configName'] = $model->getConfigName();
        $options['configName'] = $model->getConfigName();
        $request = $this->getRequest();
        $form    = new Application_Form_Log();
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
            if($options['config_name']==$model->getConfigName())
            {
               $form->getElement('configName')->removeValidator("Db_NoRecordExists");
            }
            if ($form->isValid($options))
            {
               $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Config has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/edit-log/configid/'.$configId));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;  
         
     }
     
     public function configInfoAction()
    {
        $this->view->layout()->disableLayout();
        $configId=$this->_getParam("config_id");
        $model=new Application_Model_Log();
       
        $config=$model->find($configId);
       
       if(false===$config)
        {
            exit("Records not found for config id : $configId!");
        }
        $this->view->config=$config;
    }
    
    public function deleteLogAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->config_id = $id;
        $model1 = new Application_Model_Log();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log'));  
        }
      
        
       if($model->delete("config_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log'));  
       }
       
    }
    /// Delete confif function Start
   
    // End delete config function
    
    public function messagesAction()
    { 
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
               if($search<>"" && $search<>"Search...")
        {
            $where="user_message like '%{$search}%' || sys_message like '%{$search}%' ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $model=new Application_Model_Message();
        $table=$model->getMapper()->getDbTable();
        
        $select = $table->select()->setIntegrityCheck(false)->from('message')
                 ->order('message_id ASC')->where($where);
        
         $select = $table->select()->setIntegrityCheck(false)->from(array("m"=>'message'))
                ->join(array("mc"=>'message_category'),'m.category_id=mc.message_category_id',array('category_name'=>'message_category_name'))
                ->join(array("ms"=>'message_sevirity'),'m.severity_id 	=ms.message_sevirity_id', array("sevirity_name"=>"message_sevirity_name"))
               ->join(array("mt"=>'message_type'),'m.type_id=mt.message_type_id', array("type_name"=>"message_type_name"))
                ->order('message_id ASC')->where($where);
        
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
    }
        
    public function addNewMessageAction()  {   //create new message
    
        $request = $this->getRequest();
        $form    = new Application_Form_Message();
         if ($request->isPost())
        {
            $options=$request->getPost();

            if ($form->isValid($options))
            { 
                //$options['status']='active';
                             
                $model=new Application_Model_Message($options);
                $id=$model->save();
                if($id)  
                {    
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Message added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-new-message'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Config!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-new-message'));
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
    }// End create new message
       Public function editMessageAction(){  //Edit Message
         $messageId = $this->_getParam('messageid');
        $this->view->message_id = $messageId;
        $model1 = new Application_Model_Message();
        $model = $model1->find($messageId);
        
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/log/message'));  
        }
        $options['categoryId'] = $model->getCategoryId();
        $options['severityId'] = $model->getSeverityId();
        $options['typeId'] = $model->getTypeId();
        $options['userMessage'] = $model->getUserMessage();
        $options['sysMessage'] = $model->getSysMessage();
        
        $request = $this->getRequest();
        $form    = new Application_Form_Message();
        $form->populate($options);
        $options=$request->getPost();
  
        if ($request->isPost()) 
        { 
            if($options['user_message']==$model->getUserMessage())
            {
               $form->getElement('userMessage')->removeValidator("Db_NoRecordExists");
            }
            if ($form->isValid($options))
            {
               $model->setOptions($options);
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Message has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/edit-message/messageid/'.$messageId));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=$form;  
         
     }// end  Edit message
       //delete message function start
     public function deleteMessageAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->config_id = $id;
        $model1 = new Application_Model_Message();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/messages'));  
        }
      
        
       if($model->delete("message_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/messages'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/messages'));  
       }
       
    }
     //delete message function end
      /****************************Message Cetegory Function Start******/
       public function messageCategoryAction()
    {
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="message_category_name like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_MessageCategory();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('created_on DESC')->where($where);
       
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage("$page_size");
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator; 
    }
    public function addMessageCategoryAction(){
         $request = $this->getRequest();
        $form    = new Application_Form_MessageCategory();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
          
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_MessageCategory($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Message Category added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-category'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Message Category!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-category'));
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
     Public function editMessageCategoryAction(){
        $messageCategoryid = $this->_getParam('id');
        $this->view->group_id = $id;
        $model1 = new Application_Model_MessageCategory();
        $model = $model1->find($messageCategoryid);
      
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/log/message-category'));  
        }
        $options['messageCategoryName'] = $model->getMessageCategoryName();
        
        $request = $this->getRequest();
        $form    = new Application_Form_MessageCategory();
       
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['messageCategoryName']==$model->getMessageCategoryName())
            {
               $form->getElement('messageCategoryName')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
               
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Message Category  has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/edit-message-category/id/'.$messageCategoryid));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;  
         
     }
      public function deleteMessageCategoryAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->config_id = $id;
        $model1 = new Application_Model_MessageCategory();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-category'));  
        }
      
        
       if($model->delete("message_category_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-category'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-category'));  
       }
       
    }
      /****************************Message Category Function End********/
     /*****************************Message Sevirity Function Start*********/
      public function messageSevirityAction()
    {
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="message_sevirity_name like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_MessageSevirity();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('created_on DESC')->where($where);
       
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage("$page_size");
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator; 
    }
    public function addMessageSevirityAction(){
         $request = $this->getRequest();
        $form    = new Application_Form_MessageSevirity();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
          
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_MessageSevirity($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Message Sevirity added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-sevirity'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Message Sevirity!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-sevirity'));
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
     Public function editMessageSevirityAction(){
        $messageSevirityid = $this->_getParam('id');
        $this->view->sevirity_id = $id;
        $model1 = new Application_Model_MessageSevirity();
        $model = $model1->find($messageSevirityid);
      
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/log/message-sevirity'));  
        }
        $options['messageSevirityName'] = $model->getMessageSevirityName();
        
        $request = $this->getRequest();
        $form    = new Application_Form_MessageSevirity();
       
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['messageSevirityName']==$model->getMessageSevirityName())
            {
               $form->getElement('messageSevirityName')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
               
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Message Sevirity  has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/edit-message-Sevirity/id/'.$messageSevirityid));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;  
         
     }
     public function deleteMessageSevirityAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        
        $this->view->config_id = $id;
        $model1 = new Application_Model_MessageSevirity();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-sevirity'));  
        }
      
        
       if($model->delete("message_sevirity_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-sevirity'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-sevirity'));  
       }
       
    }
     /*****************************Message Sevirity  Function End ****************/
     /*****************************Message Type Function Start************************/
           public function messageTypeAction()
    {
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="message_type_name like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_MessageType();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('created_on DESC')->where($where);
       
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage("$page_size");
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator; 
    }
    public function addMessageTypeAction(){
         $request = $this->getRequest();
        $form    = new Application_Form_MessageType();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
          
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_MessageType($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Message Type added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-type'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add Message Type!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/add-message-type'));
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
     Public function editMessageTypeAction(){
        $messageTypeid = $this->_getParam('id');
        $this->view->group_id = $id;
        $model1 = new Application_Model_MessageType();
        $model = $model1->find($messageTypeid);
      
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('admin/log/message-type'));  
        }
        $options['messageTypeName'] = $model->getMessageTypeName();
        
        $request = $this->getRequest();
        $form    = new Application_Form_MessageType();
       
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['messageTypeName']==$model->getMessageTypeName())
            {
               $form->getElement('messageTypeName')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
               
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Message Type  has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/edit-message-type/id/'.$messageTypeid));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;  
         
     }
      public function deleteMessageTypeAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        $model1 = new Application_Model_MessageType();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-Type'));  
        }
      
        
       if($model->delete("message_type_id=$id"))
       {
            $this->_flashMessenger->addMessage(array('success'=>'Data Deleted succesfully' ));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-type'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to Delete the data '));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/log/message-type'));  
       }
       
    }
     
     /*****************************Message Type Function End**************************************/
    
    /*******************************Error Log Function Start*****************************************/
     public function errorLogsAction()
    { 
        /*--search---*/
         $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
               if($search<>"" && $search<>"Search...")
        {
            $where="(machine_name like '%{$search}%' or app_name like '%{$search}%' or process_name like '%{$search}%' or module_name like '%{$search}%' or  method_name like '%{$search}%' )";
          
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
       
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $model=new Application_Model_ErrorLog();
        $table=$model->getMapper()->getDbTable();
       // $select = $table->select()->setIntegrityCheck(false)->from('user_privilege',array('user_id', 'screen_id', 'action_id','menu_id'))->order('user_id ASC')->where($where);
        $select = $table->select()->setIntegrityCheck(false)->from('error_log')
                 ->order('log_id ASC')->where($where);
        
       $sql = $select->__toString();
        $paginator =  Base_Paginator::factory($select);
       // echo '<pre>'; print_r($paginator);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
    }
        
    /*******************************Error Log Function End*********************************************/
    
}
