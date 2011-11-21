<?php
class PmController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    public function projectsAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $status = trim($this->_getParam('status'));
        $where='1=1';
        $linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(title like '%{$search}%' or description like '%{$search}%' or client_info like '%{$search}%' or start_date like '%{$search}%' or end_date like '%{$search}%' )";
            $linkArray['search']=$search;
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
         $this->view->linkArray=$linkArray;
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Project();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("p"=>'project'))->order('status Asc')->order('addedon desc')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
        
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
