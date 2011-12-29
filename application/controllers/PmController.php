<?php
class PmController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    public function projectsAction()
    {
        /*--search options---*/
        $search = trim($this->_getParam('search'));
        $status = trim($this->_getParam('status'));
        $project_manager_id = trim($this->_getParam('project_manager_id'));
        $team_leader_id = trim($this->_getParam('team_leader_id'));
        
        $where='1=1';
        $linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(p.title like '%{$search}%' or p.description like '%{$search}%' or p.client_info like '%{$search}%' or p.start_date like '%{$search}%' or p.end_date like '%{$search}%' or pm.first_name like '%{$search}%' or pm.last_name like '%{$search}%' or tl.first_name like '%{$search}%' or tl.last_name like '%{$search}%')";
            $linkArray['search']=$search;
            $this->view->search=$search;
        }
        
        if($status<>"")
        {
            if(is_null($where))
                $where.=" p.status='$status'";
            else
                $where.=" and p.status='$status'";
            $linkArray['status']=$status;
            $this->view->status=$status;
        }
        
        if($project_manager_id<>"")
        {
            if(is_null($where))
                $where.=" p.project_manager_id='$project_manager_id'";
            else
                $where.=" and p.project_manager_id='$project_manager_id'";
            $linkArray['project_manager_id']=$project_manager_id;
            $this->view->project_manager_id=$project_manager_id;
        }
        
        if($team_leader_id<>"")
        {
            if(is_null($where))
                $where.=" p.team_leader_id='$team_leader_id'";
            else
                $where.=" and p.team_leader_id='$team_leader_id'";
            $linkArray['team_leader_id']=$team_leader_id;
            $this->view->team_leader_id=$team_leader_id;
        }
        /*----search options----*/
        
        
        $this->view->linkArray=$linkArray;
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Project();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("p"=>'project'))->join(array("pm"=>"user"),'pm.id=p.project_manager_id', array("pm_first_name"=>'first_name', "pm_last_name"=> 'last_name','pm_id'=>'id'))->join(array("tl"=>"user"),'tl.id=p.team_leader_id', array("tl_first_name"=>'first_name', "tl_last_name"=> 'last_name','tl_id'=>'id'))->order('status Asc')->order('addedon desc')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
        
        $this->view->projectManagers=$model->getActiveProjectManagers();
        $this->view->teamLeaders=$model->getActiveTeamLeaders();
        
    }
    public function addProjectAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Project();
        $elements=$form->getElements();
	$form->clearDecorators();
	foreach($elements as $element)
        {
		$element->removeDecorator('label');
                $element->removeDecorator('HtmlTag');
                $element->removeDecorator('tr');
                $element->removeDecorator('td');
                $element->removeDecorator('row');
                $element->removeDecorator('data');
        }
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            if(isset($options['resource_value'])){
                $this->view->resource_value=$options['resource_value'];
                $this->view->resource_text=$options['resource_text'];
            }
            $form->getElement('title')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'project',
            'field' => 'title',
            'messages'=>'Project with the same title is already exist.'
                    ))
            ));
            if ($form->isValid($options))
            { 
                //$options['status']='active';
                $model=new Application_Model_Project($options);
                $id=$model->save();
                if($id)  
                {    
                    /*----- Add project Resource -----*/
                    if(isset($options['resource_value']))
                    {
                        foreach( $options['resource_value'] as $value)
                        {
                            $projectUser=new Application_Model_ProjectUser();
                            $projectUser->setProjectId($id);
                            $projectUser->setUserId($value);
                            $projectUser->setStatus('active');
                            $projectUser->save();
                        }
                    }
                    /*----- Add project Resource -----*/
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Project added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/pm/add-project'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add project!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/add-project'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $options['resource']='';
                $form->populate($options);
                
           }
        }
        $this->view->form =  $form;
    }
    public function editProjectAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Project();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/pm/projects'));  
        }
        $options['title'] = $model->getTitle();
        $options['description'] = $model->getDescription();
        $options['startDate'] = $model->getStartDate();
        $options['endDate'] = $model->getEndDate();
        $options['status'] = $model->getStatus();
        $options['projectManagerId'] = $model->getProjectManagerId();
        $options['teamLeaderId'] = $model->getTeamLeaderId();
        $options['clientInfo'] = $model->getClientInfo();
        
        $arr_resource_value=array();
        $arr_resource_text=array();
        foreach($model->getProjectUsers() as $_projectUser)
        {
            if($_projectUser->pustatus=="active")
            {
                $arr_resource_value[]=$_projectUser->user_id;
                $arr_resource_text[]=$_projectUser->first_name." ".$_projectUser->last_name." - [ Code:".$_projectUser->employee_code." ]";
            }
        }
        $this->view->resource_value=$arr_resource_value;
        $this->view->resource_text=$arr_resource_text;
       
		
        $request = $this->getRequest();
        $form    = new Application_Form_Project();
          $elements=$form->getElements();
	$form->clearDecorators();
	foreach($elements as $element)
        {
		$element->removeDecorator('label');
                $element->removeDecorator('HtmlTag');
                $element->removeDecorator('tr');
                $element->removeDecorator('td');
                $element->removeDecorator('row');
                $element->removeDecorator('data');
        }
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
            $options=$request->getPost();
            
            
           if(isset($options['resource_value'])){
                $this->view->resource_value=$options['resource_value'];
                $this->view->resource_text=$options['resource_text'];
            }
            
            $projectUser=new Application_Model_ProjectUser();
            $projectUser=$projectUser->fetchAll("project_id='{$id}'");
            foreach($projectUser as $pu)
            {
                $pu->setStatus('inactive');
                $pu->save();
            }
            /*----- Add/update project Resource -----*/
            if(isset($options['resource_value']))
            {
                

                foreach( $options['resource_value'] as $value)
                {
                     
                    $projectUser=new Application_Model_ProjectUser();
                    $projectUser=$projectUser->fetchRow("project_id='{$id}' and user_id='{$value}'");
                    if(false===$projectUser)
                    {
                        $projectUser=new Application_Model_ProjectUser();
                        $projectUser->setProjectId($id);
                        $projectUser->setUserId($value);
                        $projectUser->setStatus('active');
                        $projectUser->save();
                    }
                    else
                    {
                        $projectUser->setStatus('active');
                        $projectUser->save();
                    }
                }
            }
            /*----- Add/update project Resource -----*/
            
            if($model->getTitle()!=$options['title']){
                $form->getElement('title')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'project',
                'field' => 'title',
                'messages'=>'Project with the same title is already exist.'
                        ))
                ));	
            }
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                
                $this->_flashMessenger->addMessage(array('success'=>'Project has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/pm/edit-project/id/'.$id));  
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
    
}//end of class
