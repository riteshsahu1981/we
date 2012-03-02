<?php
class Admin_GlobalSettingsController extends Base_Controller_Action {
	
 	public function preDispatch()
    {
		$this->view->type=$this->_getParam('type');
		parent::preDispatch();
    }
	public function indexAction(){

		$settings=new Admin_Model_GlobalSettings();
		
		
		$page_size=$settings->settingValue('pagination_size');
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($settings,$page,$page_size);
		$this->view->total_settings=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		
	}
	public function editAction()
	{
		$id=$this->_getParam('id');
		$settings1=new Admin_Model_GlobalSettings();
		$settings=$settings1->find($id);
		
		$request = $this->getRequest();
        
		//added by mahipal on 16-Feb-2011
		if($settings->getIdentifire()=="bad_words")
		{
			$form    = new Admin_Form_Badwords();
		}
		else
		{
			$form    = new Admin_Form_GlobalSettings();
		}	
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $settings->setValue($options['value']);
                $settings->save();
                return $this->_helper->redirector('index','global-settings',"admin",Array('msg'=>base64_encode("'{$settings->getLabel()}' has been updated successfully!")));
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        //$form->getElement('value')->setLabel($settings->getLabel());
        $form->getElement('value')->setValue($settings->getValue());
        $this->view->form=$form;
	}
	
	public function amazonAction()
	{
		$this->view->title=ucfirst($this->_getParam('type'))." - Amazon";
        $this->view->headTitle(" - ".$this->view->title);
		$type=$this->_getParam('type');
		$settings=new Admin_Model_GlobalSettings();
		
		$where="identifire='{$type}_amazon_uk'";
		$settings_uk=$settings->fetchRow($where);
		
		$where="identifire='{$type}_amazon_other'";
		$settings_other=$settings->fetchRow($where);
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Amazon();
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
        		
                $settings_uk->setValue($options['amazon_uk']);
                $settings_uk->save();
                $settings_other->setValue($options['amazon_other']);
                $settings_other->save();
                //return $this->_helper->redirector('index','global-settings',"admin",Array('msg'=>base64_encode("'{$settings->getLabel()}' has been updated successfully!")));
                $this->view->msg="Amazon link is updated successfully!";
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        
        $form->getElement('amazon_uk')->setLabel($settings_uk->getLabel());
        $form->getElement('amazon_uk')->setValue($settings_uk->getValue());
        $form->getElement('amazon_other')->setLabel($settings_other->getLabel());
        $form->getElement('amazon_other')->setValue($settings_other->getValue());
        
        $this->view->form=$form;
	}
	
	public function importBadwordsAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get nationalities text from file and insert into database
		$file_path = "data/nationalities/Expletives.csv";
		$fileContent = file_get_contents($file_path);
		
		//echo $fileContent; exit;
		$badWordsArr = explode("\n",$fileContent);
		echo "<pre>";
		print_r($badWordsArr);
		echo "</pre>";
		$badwordsStr = implode(",",$badWordsArr);
		echo $badwordsStr; exit;
		
		$db=Zend_Registry::get("db");
		foreach($badWordsArr as $key=>$value)
		{
			$sSQL = "";
			//$sSQL = "INSERT INTO nationalities (nationality, country_id, created, status) values('".$value."', 0, '".date('Y-m-d H:i:s')."', 1)";
			//$db->query($sSQL);
		}
	}
}
