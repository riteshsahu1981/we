<?php
class JobController extends Base_Controller_Action
{
    public function indexAction()
    {
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/job/jobs'));
    }
    
    public function jobsAction()
    {
        /*--search options---*/
        $search = trim($this->_getParam('search'));
        $status = trim($this->_getParam('status'));
        $department_id = trim($this->_getParam('department_id'));
        
        $where='1=1';
        $linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(j.title like '%{$search}%' or j.description like '%{$search}%' or u.first_name like '%{$search}%' or u.last_name like '%{$search}%' or d.title like '%{$search}%')";
            $linkArray['search']=$search;
            $this->view->search=$search;
        }
        
        if($status<>"")
        {
            if(is_null($where))
                $where.=" j.status='$status'";
            else
                $where.=" and j.status='$status'";
            $linkArray['status']=$status;
            $this->view->status=$status;
        }
        if($department_id<>"")
        {
            if(is_null($where))
                $where.=" j.department_id='$department_id'";
            else
                $where.=" and j.department_id='$department_id'";
            $linkArray['department_id']=$department_id;
            $this->view->department_id=$department_id;
        }
        
        /*----search options----*/
        
        
        $this->view->linkArray=$linkArray;
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Job();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("j"=>'job'))->join(array("u"=>"user"),'u.id=j.posted_by_id', array('first_name', 'last_name'))->join(array("d"=>"department"),'d.id=j.department_id', array('department_title'=>'title'))->order('addedon desc')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
        $department=new Application_Model_Department();
        $this->view->departments=$department->getDepartment();
        
    }
    
    public function addJobOpeningAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Job();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                $usersNs = new Zend_Session_Namespace("members");
                $options['postedById']=$usersNs->userId;
                $model=new Application_Model_Job($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Job opening added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/job/add-job-opening'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add job opening!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/job/add-job-opening'));
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
    
    public function editJobOpeningAction()
    {
        
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Job();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/job/jobs'));  
        }
        $options['title'] = $model->getTitle();
        $options['description'] = $model->getDescription();
        $options['noOfJobOpenings'] = $model->getNoOfOpenings();
        $options['departmentId'] = $model->getDepartmentId();
        $options['status'] = $model->getStatus();
        $request = $this->getRequest();
        $form    = new Application_Form_Job();
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             
            if($options['title']==$model->getTitle())
            {
               $form->getElement('title')->removeValidator("Db_NoRecordExists");
            }
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Job opening has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/job/edit-job-opening/id/'.$id));  
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
    
    public function currentJobOpeningsAction()
    {
        /*--search options---*/
        $search = trim($this->_getParam('search'));
        $department_id = trim($this->_getParam('department_id'));
        
        $where="status='open'";
        $linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(j.title like '%{$search}%' or j.description like '%{$search}%' or d.title like '%{$search}%')";
            $linkArray['search']=$search;
            $this->view->search=$search;
        }
        
        
        if($department_id<>"")
        {
            if(is_null($where))
                $where.=" j.department_id='$department_id'";
            else
                $where.=" and j.department_id='$department_id'";
            $linkArray['department_id']=$department_id;
            $this->view->department_id=$department_id;
        }
        
        /*----search options----*/
        
        
        $this->view->linkArray=$linkArray;
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Job();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("j"=>'job'))->join(array("d"=>"department"),'d.id=j.department_id', array('department_title'=>'title'))->order('addedon desc')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
        $department=new Application_Model_Department();
        $this->view->departments=$department->getDepartment();
    }
    
    
   public function jobDetailAction()
    {
        $this->view->layout()->disableLayout();
        $jobId=$this->_getParam("id");
        $model=new Application_Model_Job();
        $job=$model->find( $jobId);
        if(false===$job)
        {
            exit("Operation failed!");
        }
        $department=new Application_Model_Department();
        $department=$department->find($job->getDepartmentId());
        $this->view->department=$department->getTitle();
        $this->view->job=$job;
    }
    
}//end of class
