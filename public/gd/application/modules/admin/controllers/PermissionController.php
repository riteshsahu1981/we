<?php
class Admin_PermissionController extends Base_Controller_Action {
	
	public function indexAction()
	{

		$this->view->title="Permission ";
        $this->view->headTitle(" -  ".$this->view->title);
		$model=new Application_Model_Permission();
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($model,$page,$page_size);
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
	}

	public function addAction()
    {
    	
		$this->view->title="Permission - Add";
        $this->view->headTitle(" -  ".$this->view->title);
        
        $form = new Admin_Form_Permission();
        $this->view->form = $form;
        $this->view->successMsg="";
        if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {
            	$usersNs = new Zend_Session_Namespace("members");
            	$formData['userId']=$usersNs->userId;
            	        		
            	$this->view->warningMsg='';
                $model = new Application_Model_Permission($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="Permission added successfully. Permission Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="Permission - Edit";
        $this->view->headTitle(" -  ".$this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_Permission();
		$model=$model1->find($id);
		
		$options['name']=$model->getName();
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Permission();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="Permission Id : {$model->getId()}' has been updated successfully!";
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        
        $this->view->form=$form;
	}
	
}
