<?php
class Security_UserController extends Base_Controller_Action
{

    public function indexAction()
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
        
        
        $page_size= 25;
        $page =	$this->_getParam('page',1);
        $model=new Security_Model_User();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("u"=>'user'))
                ->order('first_name ASC')->where($where);
        $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
       
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
    }
    
    public function addNewUserAction()
    {
        $request = $this->getRequest();
        $form    = new Security_Form_User();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            $form->getElement('email')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'user',
            'field' => 'email',
            'messages'=>'Email already exists, Please choose another email address.'
                    ))
            ));
            if ($form->isValid($options))
            { 
                
                
                //$options['status']='active';
                $options['password']=md5($options['password']);
               
                $model=new Security_Model_User($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    $model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'User added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/add-new-user'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add user!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/add-new-user'));
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
    
    
    public function editUserAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Security_Model_User();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/user'));  
        }
        $options['firstName'] = $model->getFirstName();
        $options['middleName'] = $model->getMiddleName();
        $options['lastName'] = $model->getLastName();
        $options['email'] = $model->getEmail();
        $options['dob'] = $model->getDob();
        $options['sex'] = $model->getSex();
        $options['mobile'] = $model->getMobile();
        $options['groupId'] = $model->getGroupId();
        $options['subGroupId'] = $model->getSubGroupId();
        $options['roleId'] = $model->getRoleId();
        $options['status'] = $model->getStatus();
        $options['correspondenceAddress'] = $model->getCorrespondenceAddress();
        $this->view->username = $model->getUsername();
		 	
        $request = $this->getRequest();
        $form    = new Security_Form_User();
        //remove fields do not need to display in Edit
        //$form->removeElement('employeeCode');
        //$form->getElement('employeeCode')->setAttrib("readonly", "true");
        $form->removeElement('username');
        $form->removeElement('password');
        $form->removeElement('confirmPassword');
        
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs ->userId==$id)
        {
            //$form->removeElement('groupId');
            //$form->removeElement('subGroupId');
            //$form->removeElement('roleId');
            $form->removeElement('status');    
        }		
        
        $modelP	= new Base_Security_Privilege();
        $arrSubgroup = $modelP->getSubGroupArray($model->getGroupId());
        
        $form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
        $form->populate($options);
        
        $arrUserRole = $modelP->getRoleArray($model->getSubGroupId());
        $form->getElement("roleId")->addMultiOptions( $arrUserRole );
        
        
        $form->populate($options);
        
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['email']!=$model->getEmail())
            {
               
                $form->getElement('email')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'user',
                'field' => 'email',
                'messages'=>'Email already exists, Please choose another email address.'
                        ))
                ));
            }
          
            /*-------------------------*/
			
            $modelP	= new Base_Security_Privilege();
            $arrSubgroup = $modelP->getSubGroupArray($options['groupId']);

            $form->getElement("subGroupId")->addMultiOptions( $arrSubgroup );
            $form->populate($options);

            $arrUserRole = $modelP->getRoleArray($options['subGroupId']);
            $form->getElement("roleId")->addMultiOptions( $arrUserRole );
        
            
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                /*---------  Upload image START -------------------------*/
                $model->uploadProfilePicture($id,$options);
                /*---------  Upload image END -------------------------*/
                $this->_flashMessenger->addMessage(array('success'=>'User information has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/security/user/edit-user/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
        $this->view->profile_image=$model->getProfileImage();
        $this->view->form		=	$form;
    }//end of edit-employee function
   
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
  
    
        
        
}
