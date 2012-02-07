<?php

class Admin_AreaController extends Base_Controller_Action {
    
	public function indexAction() 
	{
		
		$this->view->title="Area";
        $this->view->headTitle($this->view->title);
		$model=new Application_Model_Area();
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
		//added by Mahipal on 5-jan-2011, no one can delete area
		return $this->_helper->redirector('index','area',"admin");
		
		$this->_helper->viewRenderer->setNoRender(true);
		$id=$this->_getParam('id');
		$areaM=new Application_Model_Area();
		if($areaM->delete("id='{$id}'"))
		{
			$this->_redirect("/admin/area/index/msg/".base64_encode("Area id : [{$id}] has been deleted."));
		}
	}
	
	public function addAction()
    {
    	
		$this->view->title=ucfirst("Area - Add");
        $this->view->headTitle($this->view->title);
        
        $form = new Admin_Form_Area();
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
                $model = new Application_Model_Area($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="Area added successfully. Area Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="Area - Edit";
        $this->view->headTitle($this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_Area();
		$model=$model1->find($id);
		$options['name']=$model->getName();
		$options['regionId']=$model->getRegionId();
		$options['cityId']=$model->getCityId();
		$options['countryId']=$model->getCountryId();
		$options['continentId']=$model->getContinentId();
		$request = $this->getRequest();
        $form    = new Admin_Form_Area();
        
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="Area Id : {$model->getId()}' has been updated successfully!";
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
