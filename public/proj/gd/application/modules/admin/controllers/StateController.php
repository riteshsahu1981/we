<?php

class Admin_StateController extends Base_Controller_Action {
    
	public function indexAction() 
	{
		
		$this->view->title="State";
        $this->view->headTitle($this->view->title);
		$model=new Application_Model_State();
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
    	
		$this->view->title=ucfirst("State - Add");
        $this->view->headTitle($this->view->title);
        
        $form = new Admin_Form_State();
        $this->view->form = $form;
        $this->view->successMsg="";
        if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {
            	$usersNs = new Zend_Session_Namespace("members");
            	$formData['userId']=$usersNs->userId;
            	$formData['type']=$this->_getParam('type');        		
            	$this->view->warningMsg='';
                $model = new Application_Model_State($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="State added successfully. State Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="State - Edit";
        $this->view->headTitle($this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_State();
		$model=$model1->find($id);
		$options['name']=$model->getName();
		$options['regionId']=$model->getRegionId();
		
		$request = $this->getRequest();
        $form    = new Admin_Form_State();
        
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="State Id : {$model->getId()}' has been updated successfully!";
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
