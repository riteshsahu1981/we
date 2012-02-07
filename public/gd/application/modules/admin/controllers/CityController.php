<?php
class Admin_CityController extends Base_Controller_Action {
	
	public function indexAction()
	{
		$this->view->title="City ";
        $this->view->headTitle(" -  ".$this->view->title);
		$model=new Application_Model_City();
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
		//added by Mahipal on 5-jan-2011, no one can delete city
		return $this->_helper->redirector('index','city',"admin");
		
		$this->_helper->viewRenderer->setNoRender(true);
		$id=$this->_getParam('id');
		$cityM=new Application_Model_City();
		if($cityM->delete("id='{$id}'"))
		{
			$this->_redirect("/admin/city/index/msg/".base64_encode("City id : [{$id}] has been deleted."));
		}
	}
	public function addAction()
    {
    	$userNs=new Zend_Session_Namespace("members");
		$this->view->title="City - Add";
        $this->view->headTitle(" -  ".$this->view->title);
        
        $form = new Admin_Form_City();
        $this->view->form = $form;
        $this->view->successMsg="";
        if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {


                $upload = new Zend_File_Transfer_Adapter_Http();
				//---main image
		        if($upload->isValid('logo'))
		        {


		        	$upload->setDestination("images/logo/");
		        	try
		        	{
					 	$upload->receive('logo');
					 }
					 catch (Zend_File_Transfer_Exception $e)
					 {
					 	$msg= $e->getMessage();
					 }

					 $upload->setOptions(array('useByteString' => false));

					 $id=time();
					 $file_name = $upload->getFileName('logo');
		 		 	 $cardImageTypeArr = explode(".", $file_name);
		 		 	 $ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
		 		 	 $target_file_name = "logo_".$id.".{$ext}";
				 	 $targetPath = 'media/picture/city/logo/'.$target_file_name;
				 	 $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					 $filterFileRename -> filter($file_name);
					 $formData['logo']=$target_file_name;

					/*--- Generate Thumbnail ---*/
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(100,100);
					$thumb->save($targetPath = 'media/picture/city/logo/thumb_'.$target_file_name);


		        }



            	$usersNs = new Zend_Session_Namespace("members");
            	$formData['userId']=$usersNs->userId;
            	        		
            	$this->view->warningMsg='';
                $model = new Application_Model_City($formData);
                $id=$model->save($model);                
                $form->reset();
                $this->view->successMsg="City added successfully. City Id : $id";

            } else {
                $form->populate($formData);
            }
        }    
    }
    
	public function editAction()
	{
		$this->view->title="City - Edit";
        $this->view->headTitle(" -  ".$this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_City();
		$model=$model1->find($id);
		
		$options['name']=$model->getName();
		$options['regionId']=$model->getRegionId();
        $options['countryId']=$model->getCountryId();
        $options['continentId']=$model->getContinentId();
		
		$request = $this->getRequest();
        $form    = new Admin_Form_City();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $model->setOptions($options);
                $model->save($model);
                $this->view->successMsg="City Id : {$model->getId()}' has been updated successfully!";
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
