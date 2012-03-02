<?php
class Security_MenuController extends Base_Controller_Action
{

    public function indexAction()
    { 
        $this->view->pageHeading="Manage Menu";
        $menu=new Base_Security_Menu();
        $pages=$menu->getChildPages(0,0);
        $page_size= 25;
        $page =	$this->_getParam('page',1);
        $paginator =  Base_Paginator::factory($pages);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator=$paginator;
        
    }
    public function delindexAction()
    { 
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $status = trim($this->_getParam('status'));
        
        $where="status!='deleted' and u.id<>'-2147483648'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(first_name like '%{$search}%' or last_name like '%{$search}%' or email like '%{$search}%' or d.title like '%{$search}%' or  username like '%{$search}%' ) and {$where}} ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        if($status<>"")
        {
            if(is_null($where))
                $where.=" status='$status'";
            else
                $where.=" and status='$status'";
            $linkArray['status']=$status;
            $this->view->status=$status;
        }
        
        $menu=new Base_Security_Menu();
        $pages=$menu->getChildPages(0);

        $page_size= 25;
        $page =	$this->_getParam('page',1);
      
        $paginator =  Base_Paginator::factory($pages);
       
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
      //  $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
    }
    
    public function addMenuItemAction()
    {
	$request = $this->getRequest();
        $form    = new Security_Form_Menu();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                
                $model=new Security_Model_SystemMaster();
                $model->setMasterCode("fdMenu");
                $model->setMasterValue($options['title']);
                $model->setStatus($options['isActive']);
                $model->setStrval1($options['path']);
                $model->setStrval2($options['toolTip']);
                $model->setIntval1($options['parentMenuId']);
                $model->setBlnval1($options['isChild']);
                $id=$model->save();
                if($id)  
                {
                    $this->_flashMessenger->addMessage(array('success'=>'Menu item added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/add-menu-item'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add menu item!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/add-menu-item'));
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
    }//end of add-new-employee function
    
    
    public function editMenuItemAction()
    {
        $id = $this->_getParam('id');
        $model1 = new Security_Model_SystemMaster();
        $model1->setMasterCode("fdMenu");
        $model = $model1->fetchRow("master_code ='".$model1->getMasterCode()."' AND master_id='".$id."'");
      
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/user'));  
        }
        $options['title'] = $model->getMasterValue();
        $options['path'] = $model->getStrval1();
        $options['toolTip'] = $model->getStrval2();
        $options['parentMenuId'] = $model->getIntval1();
        $options['isActive'] = $model->getStatus();
        $options['isChild'] = $model->getBlnval1();
        
        $form    = new Security_Form_Menu();
        $form->populate($options);
        
        $request = $this->getRequest();
        $options=$request->getPost();
       
        if ($request->isPost()) 
        {
            if ($form->isValid($options))
            {
                $model->setMasterValue($options['title']);
                $model->setStatus($options['isActive']);
                $model->setStrval1($options['path']);
                $model->setStrval2($options['toolTip']);
                $model->setIntval1($options['parentMenuId']);
                $model->setBlnval1($options['isChild']);
                
                $model->save();
                $this->_flashMessenger->addMessage(array('success'=>'Menu information has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/edit-menu-item/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
        
        $this->view->form = $form;
    }//end of edit-employee function
    
    public function deleteMenuItemAction()
    {
        $id = $this->_getParam('id');
        $menu=new Base_Security_Menu();
        $pages=$menu->getChildPages($id,0);
        $arrChild[] = $id;
        for($i=0 ; $i < count($pages) ; $i++){
            $arrChild[] = $pages[$i]['menu_id'];
        }
        
       $strMenuIds = implode(',',$arrChild);
       $model1 = new Security_Model_SystemMaster();
       $model1->setMasterCode("fdMenu");
       $model1->delete("master_id IN ($strMenuIds) AND master_code ='".$model1->getMasterCode()."'");
       $this->_flashMessenger->addMessage(array('success'=>'Menu item deleted successfully!'));
       $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu/'));
    }
    
    public function changeUserStatusAction()
    {
        $id = $this->_getParam('id');
        
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs->userId==$id)
        {
           $this->_flashMessenger->addMessage(array('error'=>'You cannot change your status!' ));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user'));  
           exit;
        } 
        $this->view->user_id = $id;
        $model1 = new Security_Model_User();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user'));  
        }
        if($model->getStatus()=="active")
            $model->setStatus ("inactive");
        else
            $model->setStatus ("active");
        
       if($model->save())
       {
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/user'));  
       }
       
    }
    
    public function userInfoAction()
    {
        $this->view->layout()->disableLayout();
        $userId=$this->_getParam("id");
        $model=new Security_Model_User();
        $user=$model->find( $userId);
       if(false===$user)
        {
            exit("Operation failed!");
        }
        $this->view->user=$user;
    }
    
    
    public function myProfileAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $model=new Security_Model_User();
        $user=$model->find($usersNs->userId);
        if(false===$user)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/dashboard'));  
        }
        $form    = new Application_Form_User();
        $elements=$form->getElements();
        foreach($elements as $element)
        {
           if($element->getId()!="profilePicture" && $element->getId()!="submit" )
            $form->removeElement($element->getId());
        }
        
        $this->view->form=$form;
        $request = $this->getRequest();
        if ($request->isPost()) 
        {
             $options=$request->getPost();
             if ($form->isValid($options))
             {
                $user->uploadProfilePicture($usersNs->userId,$options);
                $this->_flashMessenger->addMessage(array('success'=>'Profile picture has been uploaded successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/user/my-profile'));  
             }
             else
             {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to upload the profile picture!'));
                $form->reset();
             } 
        }
        
        $this->view->user=$user;
    }
    
    public function changePasswordAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $user = new Security_Model_User();
        $model = $user->find($usersNs->userId);
        $request = $this->getRequest ();
        $form = new Application_Form_ChangePassword();
        $elements=$form->getElements();
        $form->clearDecorators();

        foreach($elements as $element)
        {
            $element->removeDecorator('label');
            $element->removeDecorator('Errors');
        }   
        
        if ($request->isPost ()) 
        {
                $options = $request->getPost ();
                if ($form->isValid ( $options )) 
                {
                    $model->setPassword(md5($options ['password']));
                    $model->save();
                    $this->_flashMessenger->addMessage(array('success'=>'Your password has been changed successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/dashboard'));

                } 
                else 
                {
                    $this->view->password_msg=array_pop($form->getMessages('password'));
                    $this->view->cpassword_msg=array_pop($form->getMessages('confirmPassword'));
                    $form->reset ();
                    $form->populate ( $options );
                }
        }
        // Assign the form to the view
        $this->view->form = $form;   
    }
    
    
    public function groupsAction()
    {
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="title like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Group();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage("$page_size");
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator; 
    }
  
    public function changeStatusAction()
    {
        $id = $this->_getParam('id');
        $status = $this->_getParam('status');
        if($status==0)
            $status=1;
        else
            $status=0;
        
        $model = new Base_Security_Menu();
        $model->changeStatus($id, $status);
        if($status==1)
            $txt="Active";
        else
            $txt="InActive";
        if(false===$model)
            $this->_flashMessenger->addMessage(array('error'=>'Operation failed. Please try again.'));
            
        else
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for menu ID : '.$id.', Now it is '.$txt));
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu'));  
       
    }
        
    public function changeChildStatusAction()
    {
        $id = $this->_getParam('id');
        $status = $this->_getParam('status');
        if($status==0)
            $status=1;
        else
            $status=0;
        
        $model = new Base_Security_Menu();
        $model->changeChildStatus($id, $status);
        if($status==1)
            $txt="it is child";
        else
            $txt="it is not a child";
        if(false===$model)
            $this->_flashMessenger->addMessage(array('error'=>'Operation failed. Please try again.'));
            
        else
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for menu ID : '.$id.', Now it is '.$txt));
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/menu'));  
       
    }
        
}
