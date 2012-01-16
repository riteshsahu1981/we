<?php

class SeoUrlController extends Base_Controller_Action {


	public function indexAction() 
	{
		
		$this->view->title="Url Rewrite Management";
                $this->view->headTitle(" - ".$this->view->title);
		$model=new Application_Model_SeoUrl();
		$settings=new Application_Model_GlobalSettings();
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
    	
    $this->view->title=ucfirst("Url Rewrite Management - Add");
        $this->view->headTitle(" -  ".$this->view->title);
        
        $form = new Application_Form_SeoUrl();
        $this->view->form = $form;
        $this->view->successMsg="";
        if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {
            	
            	$this->view->warningMsg='';
                $model = new Application_Model_SeoUrl($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="Seo Url added successfully. Seo Url Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="Url Rewrite Management - Edit";
                $this->view->headTitle(" -  ".$this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_SeoUrl();
		$model=$model1->find($id);
		
		$options['actualUrl']=$model->getActualUrl();
                $options['seoUrl']=$model->getSeoUrl();
		
		$request = $this->getRequest();
        $form    = new Application_Form_SeoUrl();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="Seo Url Id : {$model->getId()}' has been updated successfully!";
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
