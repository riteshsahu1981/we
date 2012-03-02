<?php
class Admin_BannerController extends Base_Controller_Action {
	
	public function indexAction(){

		$model=new Cms_Model_Banner();
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
    	$request = $this->getRequest();
        $form    = new Admin_Form_Banner();
        if ($this->getRequest()->isPost()) 
        { 
            $options=$request->getPost();
            
            if ($form->isValid($options)) 
            { 
            	$model = new Cms_Model_Banner($options);
            	$model->setPublished("1");
            	$id=$model->save();
            	/*--Image Upload ----*/
        		$upload = new Zend_File_Transfer_Adapter_Http();
        		if($upload->isValid())
        		{
	        		$upload->setDestination("images/uploads/");
	        		try 
	        		{
					 	$upload->receive();
					 } 
					 catch (Zend_File_Transfer_Exception $e) 
					 {
					 	$e->getMessage();
					 }
					 $upload->setOptions(array('useByteString' => false));
					 $file_name = $upload->getFileName('image');
	 			 	 $cardImageTypeArr = explode(".", $file_name);
	 			 	 $ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]); 			 	 
	 			 	 $target_file_name = "banner_{$id}_image.{$ext}";
				 	 $targetPath = 'media/banner/'.$target_file_name;
				 	 
				 	 $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					 $filterFileRename -> filter($file_name);
					 $options['image']=$target_file_name;
					
					$model=$model->find($id);
					$model->setImage($target_file_name);
                	$model->save();
        		}
            	
            	
                
                return $this->_helper->redirector('add','banner',"admin",Array('msg'=>base64_encode("Banner Added successfully!")));
            }
            else
            {
            	$form->reset();
            	$form->populate($options);
            }
        }
          $this->view->msg=base64_decode($this->getRequest()->getParam("msg"));
        // Assign the form to the view
        $this->view->form = $form;
    }
    
    public function changestatusAction()
	{
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$status=$this->_getParam('status');
		
		$model=new Cms_Model_Banner();
		$model=$model->find($id);
		
		$model->setPublished($status);
		
		
		$model->save();
		$msg="You have successfully unpublished the banner!";
		if($status==1)
		$msg="You have successfully publish the banner!";	
		$this->_helper->redirector('index','banner','admin',Array('msg'=>base64_encode($msg),'page'=>$page));
	}
	
	public function editAction()
	{
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$model=new Cms_Model_Banner();
		$model=$model->find($id);
		
		$options['title']=$model->getTitle();
      	$options['image']=$model->getImage();
      	$options['url']=$model->getUrl();
      	$options['description']=$model->getDescription();
      	$options['position']=$model->getPosition();
      	$options['bannerType']=$model->getBannerType();
      	
		$request = $this->getRequest();
        $form    = new Admin_Form_Banner();
        $form->getElement('image')->removeValidator('NotEmpty');
        $form->getElement('image')->setRequired(false);
        $form->populate($options);
        if ($this->getRequest()->isPost()) 
        {
            $options=$request->getPost();
            if ($form->isValid($options)) 
            {
            	/*--Image Upload ----*/
        		$upload = new Zend_File_Transfer_Adapter_Http();
        		if($upload->isValid())
        		{
	        		$upload->setDestination("images/uploads/");
	        		try 
	        		{
					 	$upload->receive();
					 } 
					 catch (Zend_File_Transfer_Exception $e) 
					 {
					 	$e->getMessage();
					 }
					 $upload->setOptions(array('useByteString' => false));
					 $file_name = $upload->getFileName('image');
	 			 	 $cardImageTypeArr = explode(".", $file_name);
	 			 	 $ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]); 			 	 
	 			 	 $target_file_name = "banner_{$id}_image.{$ext}";
				 	 $targetPath = 'media/banner/'.$target_file_name;
				 	 
				 	 $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					 $filterFileRename -> filter($file_name);
					 $options['image']=$target_file_name;
        		}
        		/*---------------------*/
                $model->setOptions($options);
                $model->save();
                return $this->_helper->redirector('index','banner',"admin",Array('msg'=>base64_encode("Banner [Id:$id] is updated successfully!")));                
            }
            else
            {
            	$form->reset();
            	$form->populate($options);
            }
        }
        $this->view->msg=base64_decode($this->getRequest()->getParam("msg"));
        // Assign the form to the view
        $this->view->image_path="media/banner/".$model->getImage();
        $this->view->form = $form;
	}
	
	public function deleteAction()
	{
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$model=new Cms_Model_Banner();
		$model=$model->find($id);
		@unlink(PUBLIC_PATH."/images/banner/".$model->getImage());
		$model->delete("Id='$id'");
		return $this->_helper->redirector('index','banner',"admin",Array('msg'=>base64_encode("Banner [Id:$id] is successfully deleted!")));
	}
}