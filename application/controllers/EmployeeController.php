<?php
class EmployeeController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    
    public function dashboardAction()
    {    


        $usersNs = new Zend_Session_Namespace("members");
        $model=new Application_Model_User();
        $user=$model->find($usersNs->userId);
        if(false===$user)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/dashboard'));  
        }
        $this->view->user=$user;
        $this->view->birthdayGuys=$user->getBirthdayGuys();
        $this->view->latestNotice=$user->getLatestNotice();
        $this->view->appriciations=$user->getLatestAppriciations();
        
    }
    
    public function myProfileAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $model=new Application_Model_User();
        $user=$model->find($usersNs->userId);
        if(false===$user)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/dashboard'));  
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
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/my-profile'));  
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
        $user = new Application_Model_User();
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
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/change-password'));

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
    public function leavesAction()
    {
         $usersNs = new Zend_Session_Namespace("members");
        $model=new Application_Model_User();
        $user=$model->find($usersNs->userId);
        if(false===$user)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request!'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/dashboard'));  
        }
        
        $this->view->user=$user;
    }
    
    public function myRequestsAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $userId=$usersNs->userId;
        
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="requested_by='{$userId}'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="requested_by='{$userId}' and (request like '%{$search}%' or d.title like '%{$search}%' or status like '%{$search}%') ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Request();
        $table=$model->getMapper()->getDbTable();
        //print_r($table->info());
        //$select = $table->select()->order('addedon DESC')->where($where);
        $select = $table->select()->setIntegrityCheck(false)->from(array("r"=>'request'))->join(array("d"=>'department'),'r.department_id=d.id',array('department_name'=>'title'))->order('status asc')->order('addedon DESC')->where($where);
        //->join('department', 'department.id=request.department_id')
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function createRequestAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $userId=$usersNs->userId;
        
        $request = $this->getRequest();
        $form    = new Application_Form_Request();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                $options['requestedBy']=$userId;
                $options['status']="Open";
                $model=new Application_Model_Request($options);
                $id=$model->save();
                if($id)  
                {    
                    //send email notificatons to concern department's persons
                    $mail=new Base_Mail();
                    $mail->sendRequestNotification($id);

                    $this->_flashMessenger->addMessage(array('success'=>"Your request has been successfully conveyed to the concern person! Your Request No. is #{$id}"));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/my-requests'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to send request!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/my-requests'));
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
    
    
    public function requestDetailAction()
    {
        $id = $this->_getParam('id');
        $model=new Application_Model_Request();
        $model=$model->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/my-requests'));  
        }
        $this->view->request=$model;
    }
    
    public function requestReceivedAction()
    {
        $usersNs = new Zend_Session_Namespace("members");
        $userId=$usersNs->userId;
        
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="d.department_head_id='{$userId}' and d.type='operations'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="d.department_head_id='{$userId}' and d.type='operations' and (request like '%{$search}%' or d.title like '%{$search}%' or u.email like '%{$search}%' or u.last_name like '%{$search}%' or u.first_name like '%{$search}%' or r.status like '%{$search}%') ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Request();
        $table=$model->getMapper()->getDbTable();
        //print_r($table->info());
        //$select = $table->select()->order('addedon DESC')->where($where);
        $select = $table->select()->setIntegrityCheck(false)->from(array("r"=>'request'))->join(array("d"=>'department'),'r.department_id=d.id',array('department_name'=>'title'))->join(array("u"=>'user'),'r.requested_by=u.id',array('first_name','last_name', 'email','employee_code'))->order('status asc')->order('addedon DESC')->where($where);
        //->join('department', 'department.id=request.department_id')
        //echo $select->_toString();
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function changeRequestStatusAction()
    {
        $id = $this->_getParam('id');
        $request = $this->getRequest();
        if($request->isPost())
        {
            $options=$request->getPost();
            
            if(trim($options['remarks'])=='' && $options['submit']=="Close Request")
            {
                $this->_flashMessenger->addMessage(array('error'=>'Please enter remarks.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/change-request-status/id/'.$id));  
            }
            else if ($options['submit']=='Cancel')
            {
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/request-received'));  
            }
            else
            {
                $usersNs = new Zend_Session_Namespace("members");
                $userId=$usersNs->userId;
                $model=new Application_Model_Request();
                $model=$model->find($id);
                $model->setStatus("close");
                $model->setUserId($userId);
                $model->setRemarks($options['remarks']);
                if($model->save())
                {
                    //send email notificaiton to requested by person
                    $mail=new Base_Mail();
                    $mail->sendRequestCompleteNotification($id);
                    $this->_flashMessenger->addMessage(array('success'=>'Request status changed successfully'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/request-received')); 
                }
            }
        }
        
        $model=new Application_Model_Request();
        $model=$model->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/request-received'));  
        }
        $this->view->request=$model;
        if($model->getStatus()=="close"){
        $pageA=$this->view->navigation()->findActive($this->view->navigation()->getContainer());
             if(isset($pageA['page']))
                   $pageA['page']->setLabel("View Request Status");
        
        }
    }
    
    public function trackRequestAction()
    {
        
    }
    public function myAttendanceAction()
    {
        
        //---user---
        $usersNs = new Zend_Session_Namespace("members");
        $userId = $usersNs->userId;
        $model1 = new Application_Model_User();
        $model = $model1->find($userId);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
        }
        $this->view->user=$model;
        //-----user end--
         
          //--calendar---
        $prm = $this->getRequest()->getParam('prm');
        $chm = $this->getRequest()->getParam('chm');
        if(isset($prm) and $prm > 0)
            $m =$prm+$chm;
        else
            $m = date("m");
        
       
        $d= date("d");   
        $y= date("Y");    
        
        //----calender end-----
         
        //--attendance ----
        
        $attendance=new Application_Model_Attendance();
        $attendance=$attendance->getMonthlyAttendance($m,$y,$userId);
        //----attendance end---
        $currentUrl="/".$this->view->controllerName."/".$this->view->actionName."/id/".$userId;
        $this->view->attendanceCalender=$this->view->partial('employee/employee-attendance.phtml', array( 'attendance'=>$attendance, 'm'=>$m, 'y'=>$y, 'd'=>$d,'prm'=>$prm, 'chm'=>$chm, 'currentUrl'=>$currentUrl,));
        
    }
    
    public function oldmyAttendanceAction()
    {
        
        
        $usersNs = new Zend_Session_Namespace("members");
        $userId = $usersNs->userId;
        $model1 = new Application_Model_User();
        $model = $model1->find($userId);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
        }
        $this->view->user=$model;
        
        $request = $this->getRequest();
        $form    = new Application_Form_Attendance();
        $form->removeElement("attendanceSheet");
        $form->clearDecorators();
        $elements=$form->getElements();
        foreach($elements as $element)
        {
            $element->setAttrib("style", "width:100px");
            $element->removeDecorator('label');
        }
       $form->getElement("month")->setAttrib("class", "");
       $form->getElement("year")->setAttrib("class", "");
       
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                $date=$options["year"]."-".$options['month'];
                $attendance=new Application_Model_Attendance();
                $this->view->attendance=$attendance->fetchAll("user_id='$userId' and DATE_FORMAT(attendance_date, '%Y-%m')='$date'");
                
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        else
        {
            $options['month']=date("m");
            $options['year']=date("Y");
            $form->populate($options);
            $date=date("Y-m");
            $attendance=new Application_Model_Attendance();
            $this->view->attendance=$attendance->fetchAll("user_id='$userId' and DATE_FORMAT(attendance_date, '%Y-%m')='$date'");
        }
        $this->view->form =  $form;
        
    }
    public function thumbAction()
    {
    	$path=base64_decode($this->_getParam('path'));
    	$width=70;
    	$height=70;
    	$thumb = Base_Image_PhpThumbFactory ::create($path);
		$thumb->resize($width,$height);
		$thumb->show();
    	exit;	
    }
    
    public function contactsAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="status!='deleted'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(first_name like '%{$search}%' or last_name like '%{$search}%' or email like '%{$search}%' or extension_no like '%{$search}%' or skype like '%{$search}%' or d.title like '%{$search}%') and status='active' ";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_User();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("u"=>'user'))->join(array("d"=>'department'),'u.department_id=d.id',array('department_name'=>'title'))->order('first_name ASC')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
    }
    
    public function importantContactsAction()
    {
        
    }
    
    public function pageAction()
    {
        $identifire	=	$this->_getParam("identifire");
        $page		=	new Application_Model_Page();
        $page		=	$page->getStaticContent($identifire);
        if(false!==$page)
        {
                $this->view->status		=	$page->getStatus();
                $this->view->title		=	$page->getTitle();
                $this->view->content	=	$page->getContent();
                $this->view->headTitle()->setSeparator(' - ');
                if($page->getMetaTitle()=="")
                        $this->view->headTitle()->set($page->getTitle());
                else
                        $this->view->headTitle()->set($page->getMetaTitle());

                $this->view->headMeta()->appendName('keywords',$page->getMetaKeyword());
                $this->view->headMeta()->appendName('description',$page->getMetaDescription());
                $this->view->headMeta()->appendName('title',$page->getMetaTitle());
                
             $pageA=$this->view->navigation()->findActive($this->view->navigation()->getContainer());
             if(isset($pageA['page']))
                   $pageA['page']->setLabel($page->getTitle());
        }
        else
        {
                $this->view->status = 2; //deleted
        }	

       
            
    }
    
    
    public function noticesAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="title like '%{$search}%' or content like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Notice();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
    }
    
    public function noticeDetailAction()
    {
        $id = $this->_getParam('id');
        $model1 = new Application_Model_Notice();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/notices'));  
        }
        $this->view->notice=$model;
        $pageA=$this->view->navigation()->findActive($this->view->navigation()->getContainer());
             if(isset($pageA['page']))
                   $pageA['page']->setLabel($model->getTitle());
    }
    public function galleryAction()
    {
        $album=new Application_Model_Album();
        $this->view->albums=$album->fetchAll("status='publish'", 'addedon desc');
        $this->view->totalItems= count($this->view->albums);
    }
    
    
    
    public function viewPicturesAction()
    {
        $this->view->album_id=$this->_getParam('id');
    }
    
    
    
    public function employeeInfoAction()
    {
        $this->view->layout()->disableLayout();
        $userId=$this->_getParam("id");
        $model=new Application_Model_User();
        $user=$model->find( $userId);
        if(false===$user)
        {
            exit("Operation failed!");
        }
        $this->view->user=$user;
    }
}//end of class
