<?php

class Admin_ContinentController extends Base_Controller_Action {

	
    public function preDispatch()
    {
		$this->view->type=$this->_getParam('type');
		parent::preDispatch();
    }
	public function indexAction() 
	{
		$this->view->title="Continent";
        $this->view->headTitle(" - ".$this->view->title);
		$model=new Application_Model_Continent();
		//$settings=new Admin_Model_GlobalSettings();
		//$page_size=$settings->settingValue('pagination_size');
		$page_size	= $this->_getParam('page_size',25);
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($model,$page,$page_size,NULL, "name ASC");
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
	}
	
	public function deleteAction()
	{
		//added by Mahipal on 5-jan-2011, no one can delete continent
		return $this->_helper->redirector('index','continent',"admin");
		
		$this->_helper->viewRenderer->setNoRender(true);
		$id=$this->_getParam('id');
		$continentM=new Application_Model_Continent();
		if($continentM->delete("id='{$id}'"))
		{
			$this->_redirect("/admin/continent/index/msg/".base64_encode("Continent id : [{$id}] has been deleted."));
		}
	}
	
	public function addAction()
    {
    	
		$this->view->title=ucfirst("Continent - Add");
        $this->view->headTitle(" -  ".$this->view->title);
        
        $form = new Admin_Form_Continent();
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
                $model = new Application_Model_Continent($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="Continent added successfully. Continent Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="Continent - Edit";
        $this->view->headTitle(" -  ".$this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_Continent();
		$model=$model1->find($id);
		
		$options['name']=$model->getName();
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Continent();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="Continent Id : {$model->getId()}' has been updated successfully!";
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
