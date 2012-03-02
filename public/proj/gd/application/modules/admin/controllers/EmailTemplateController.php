<?php
class Admin_EmailTemplateController extends Base_Controller_Action {
	
	public function indexAction()
	{
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		$model=new Admin_Model_EmailTemplate();
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($model,$page,$page_size);
		$this->view->total_templates=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
	}
	
	public function editAction()
	{
		$id=$this->_getParam('id');
		$emailTemplate1=new Admin_Model_EmailTemplate();
		$emailTemplate=$emailTemplate1->find($id);
		
		$request = $this->getRequest();
        $form    = new Admin_Form_EmailTemplate();
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
        		$emailTemplate->setOptions($options);
                $emailTemplate->save();
                return $this->_helper->redirector('index','email-template',"admin",Array('msg'=>base64_encode("'{$emailTemplate->getName()}' has been updated successfully!")));
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $form->getElement('name')->setValue($emailTemplate->getName());
        $form->getElement('body')->setValue($emailTemplate->getBody());
        $form->getElement('subject')->setValue($emailTemplate->getSubject());
        $this->view->form=$form;
	}
}
