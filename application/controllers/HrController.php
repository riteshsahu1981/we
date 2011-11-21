<?php
class HrController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    
    public function leaveTypesAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"")
        {
            $where="code like '%{$search}%' or title like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_LeaveType();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addNewLeaveTypeAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_LeaveType();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_LeaveType($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Leave type added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-leave-type'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add leave type!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-leave-type'));
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
    public function editLeaveTypeAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_LeaveType();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/leave-types'));  
        }
        $options['title'] = $model->getTitle();
        $options['code'] = $model->getCode();
        $options['totalLeavesInYear'] = $model->getTotalLeavesInYear();
        $request = $this->getRequest();
        $form    = new Application_Form_LeaveType();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             
            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
            if($options['code']==$model->getCode())
            {
               $form->getElement('code')->removeValidator("Db_NoRecordExists");
            }
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Leave type has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-leave-type/id/'.$id));  
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
    public function importEmployeeSheetAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_EmployeeImport();
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                $user=new Application_Model_User();
                $targetPath=$user->uploadEmployeeSheet();
                if(file_exists($targetPath))
                {
                    $rows=$user->importEmployee($options,$targetPath);
                    $this->_flashMessenger->addMessage(array('success'=>$rows.' records imported!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/import-employee-sheet'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Import failed'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/import-employee-sheet'));
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
    }//end of function
    
    public function employeesAction()
    { 
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="status!='deleted'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(first_name like '%{$search}%' or last_name like '%{$search}%' or email like '%{$search}%' or skype like '%{$search}%' or d.title like '%{$search}%' or  username like '%{$search}%' or  employee_code like '%{$search}%') and status!='deleted'";
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
        
        $this->view->paginator=$paginator;
    }
    
    public function addNewEmployeeAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_User();
        
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
                $model=new Application_Model_User($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    $model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Employee added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-employee'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add employee!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-employee'));
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
    
    
    public function editEmployeeAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_User();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
        }
        $options['firstName'] = $model->getFirstName();
        $options['middleName'] = $model->getMiddleName();
        $options['lastName'] = $model->getLastName();
        $options['email'] = $model->getEmail();
        $options['dob'] = $model->getDob();
         $options['doj'] = $model->getDoj();
         $options['pan'] = $model->getPan();
         $options['employeeCode'] = $model->getEmployeeCode();
         $options['contactNo'] = $model->getContactNo();
         $options['extensionNo'] = $model->getExtensionNo();
         $options['skype'] = $model->getSkype();
        $options['sex'] = $model->getSex();
        $options['mobile'] = $model->getMobile();
        $options['fatherName'] = $model->getFatherName();
        $options['marriageAnniversary'] = $model->getMarriageAnniversary();
        $options['designationId'] = $model->getDesignationId();
        $options['departmentId'] = $model->getDepartmentId();
        $options['userLevelId'] = $model->getUserLevelId();
        $this->view->username = $model->getUsername();
		
        $request = $this->getRequest();
        $form    = new Application_Form_User();
        //remove fields do not need to display in Edit
        //$form->removeElement('employeeCode');
        //$form->getElement('employeeCode')->setAttrib("readonly", "true");
        $form->removeElement('username');
        $form->removeElement('password');
        $form->removeElement('confirmPassword');
		
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
            if($options['employeeCode']==$model->getEmployeeCode())
            {
               
                $form->getElement('employeeCode')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                /*---------  Upload image START -------------------------*/
                $model->uploadProfilePicture($id,$options);
                /*---------  Upload image END -------------------------*/
                $this->_flashMessenger->addMessage(array('success'=>'Employee information has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-employee/id/'.$id));  
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
   
    public function changeEmployeeStatusAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_User();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
        }
        if($model->getStatus()=="active")
            $model->setStatus ("inactive");
        else
            $model->setStatus ("active");
        
       if($model->save())
       {
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getFirstName().' '.$model->getLastName().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
       }
       
    }
    
    public function designationAction()
    {
        /*--search---*/
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

        $model=new Application_Model_Designation();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addNewDesignationAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Designation();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_Designation($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Designation added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-designation'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add designation!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-designation'));
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
    }//end of add-new-designation function
 
    public function editDesignationAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Designation();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/designation'));  
        }
        $options['title'] = $model->getTitle();
        
        $request = $this->getRequest();
        $form    = new Application_Form_Designation();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Designation title has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-designation/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;
    }//end of edit-designation function
    
    
    public function departmentsAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="title like '%{$search}%' or type like '%{$search}%' or u.email like '%{$search}%' or u.last_name like '%{$search}%' or u.first_name like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Department();
        $table=$model->getMapper()->getDbTable();
        
        $select = $table->select()->setIntegrityCheck(false)->from(array("d"=>'department'))->join(array("u"=>'user'),'u.id=d.department_head_id',array('first_name', 'last_name'))->order('addedon DESC')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addNewDepartmentAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Department();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_Department($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Department added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-department'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add department!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-department'));
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
    }//end of add-new-designation function
 
    public function editDepartmentAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Department();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/departments'));  
        }
        $options['title'] = $model->getTitle();
        $options['type'] = $model->getType();
        $options['departmentHeadId'] = $model->getDepartmentHeadId();
        $request = $this->getRequest();
        $form    = new Application_Form_Department();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Department title has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-department/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;
    }//end of edit-department function
    
    
    
    
    
    public function manageEmployeeLeavesAction()
    {
        $userId = $this->_getParam('id');
        $model1 = new Application_Model_User();
        $model = $model1->find($userId);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
        }
        
        $this->view->user=$model;
        
        
        
        $request = $this->getRequest();
        $form    = new Application_Form_UserLeaveAccount();
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                $options['userId']=$userId;
                $model=new Application_Model_UserLeaveAccount($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'User leave account has been successfully crided/debited!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/manage-employee-leaves/id/'.$userId));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to credit/debit the user leave account!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/manage-employee-leaves/id/'.$userId));
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
    
    public function attendanceAction()
    {
        
    }
    
    public function importAttendanceSheetAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Attendance();
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                $attendance=new Application_Model_Attendance();
                $targetPath=$attendance->uploadAttendanceSheet();
                if(file_exists($targetPath))
                {
                    $rows=$attendance->importAttendance($options,$targetPath);
                    $this->_flashMessenger->addMessage(array('success'=>$rows.' records imported!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/import-attendance-sheet'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Import failed'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/import-attendance-sheet'));
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
    }//end of function
    
    public function employeeAttendanceAction()
    {
         //---user---
        $userId = $this->_getParam('id');
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
    public function oldemployeeAttendanceAction()
    {
        $userId = $this->_getParam('id');
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
    
    
    
    
//    public function noticesAction()
//    {
//        /*--search---*/
//        $search = trim($this->_getParam('search'));
//        $where="1=1";
//        $this->view->linkArray=array();
//        $this->view->search="Search...";
//        if($search<>"" && $search!="Search...")
//        {
//            $where="title like '%{$search}%' or content like '%{$search}%'";
//            $this->view->linkArray=array('search'=>$search);
//            $this->view->search=$search;
//        }
//        
//        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
//        $page =	$this->_getParam('page',1);
//
//        $model=new Application_Model_NoticeBoard();
//        $table=$model->getMapper()->getDbTable();
//        $select = $table->select()->order('addedon DESC')->where($where);
//        $paginator =  Base_Paginator::factory($select);
//        $paginator->setItemCountPerPage($page_size);
//        $paginator->setCurrentPageNumber($page);
//        
//        $this->view->paginator=$paginator;
//    }
    
    public function appriciationsAction()
    {
        $search = trim($this->_getParam('search'));
        $where="status!='deleted'";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(first_name like '%{$search}%' or last_name like '%{$search}%' or email like '%{$search}%' or skype like '%{$search}%'  or  username like '%{$search}%' or  employee_code like '%{$search}%'  or remarks like '%{$search}%' or at.title like '%{$search}%' or appriciation_date like '%{$search}%' or d.title like '%{$search}%') and status!='deleted'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Appriciation();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'appriciation'))->join(array("u"=>'user'),'u.id=a.user_id')->join(array("d"=>'department'),'u.department_id=d.id',array('department_name'=>'title'))->join(array("at"=>'appriciation_type'),'at.id=a.appriciation_type_id',array('appriciation_type'=>'title'))->order('a.addedon DESC')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addAppriciationAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Appriciation();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            if ($form->isValid($options))
            { 
                $model=new Application_Model_Appriciation($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Appriciation added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-appriciation'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add appriciation!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-appriciation'));
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
    }//end of add-appriciation function
    public function editAppriciationAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Appriciation();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/appriciation'));  
        }
        $options['user_id'] = $model->getUserId();
        $options['appriciationDate'] = $model->getAppriciationDate();
         $options['appriciationTypeId'] = $model->getAppriciationTypeId();
        $options['remarks'] = $model->getRemarks();
        $request = $this->getRequest();
        $form    = new Application_Form_Appriciation();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Appriciation has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-appriciation/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;
    }//end of edit-appriciation function
    
    
    
    
    public function appriciationTypeAction()
    {
        /*--search---*/
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

        $model=new Application_Model_AppriciationType();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addNewAppriciationTypeAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_AppriciationType();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_AppriciationType($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Appriciation type added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-appriciation-type'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add appriciation type!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-new-appriciation-type'));
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
    }//end of add-new-appriciation function
 
    public function editAppriciationTypeAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_AppriciationType();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/appriciation-type'));  
        }
        $options['title'] = $model->getTitle();
        
        $request = $this->getRequest();
        $form    = new Application_Form_AppriciationType();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- email validation ----*/
            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Appriciation type title has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/edit-appriciation-type/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;
    }//end of edit-appriciation-type function
    
    
    
}
