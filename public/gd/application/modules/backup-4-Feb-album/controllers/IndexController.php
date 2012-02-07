<?php


class Album_IndexController extends Base_Controller_Action {

	public function preDispatch()
	{
		parent::preDispatch();
		
		$this->_helper->layout->setLayout('2column');
	}
	
	public function indexAction() 
	{
	
		
	}
	
	public function createAlbumAction()
	{
		$request=$this->getRequest();
		$form=new Album_Form_CreateAlbum();
	
	    $elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    		
		if($request->isPost())
		{
        	$params=$request->getParams();
        	
            if ($form->isValid($params)) 
            {
            	
            	$userNs=new Zend_Session_Namespace('members');
				$params['userId']=$userNs->userId;
				
				$albumM=new Album_Model_UserAlbum($params);
				$album_id=$albumM->save();
				if($album_id>0)
				{
					/*-----tags--------*/
					if($params['tags']<>""){
					$arrTags=explode(",",$params['tags']);
					foreach($arrTags as $_tag)
					{
						$_tag=trim($_tag);
						$tagsM=new Application_Model_Tags();
						$tag=$tagsM->fetchRow("tag='{$_tag}'");
						if(false===$tag){
							$tagsM->setTag($_tag);
							$tag_id=$tagsM->save();
						}else{
							$tag_id=$tag->getId();
						}
						$albumTagM=new Application_Model_AlbumTag();
						$albumTagM->setAlbumId($album_id);
						$albumTagM->setTagId($tag_id);
						$albumTagM->save();
						
					}
					}
					/*----------tags-------*/
					$this->view->msg="Album created successfully. Album Id : {$album_id}";
					$form->reset();	
				}
				else
				{
					$this->view->msg="Faild to create Album. Please try again.";
				}
            }
          
		}
		$this->view->form=$form;
	}
	
	public function myPhotosAction()
	{
		$userNs=new Zend_Session_Namespace('members');
		$userId  = $userNs->userId;
		$albumM  = new  Album_Model_UserAlbum();
		$where   = "user_id = $userId";
		
		
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		
		
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		
		$paginator=$pageObj->fetchPageData($albumM,$page,$page_size,$where);
		
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		
		$this->view->paginator=$paginator;
		
	}
	
	public function addPhotoAction()
	{
		$userNs=new Zend_Session_Namespace('members');
		$userId  = $userNs->userId;
		$albumM  = new  Album_Model_UserAlbum();
		$where   = "user_id = $userId";
		$id=$this->_getParam('id');
		
		$this->view->albumSelectBox = $albumM->createAlbumSelectBox($where,$id);
		
		
	}
	
	public function uploadPhotoAction()
	{    
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
		 $uploadFolder = '/images/uploads';
  
		  if (!is_dir($uploadFolder)) {
		    if (!@mkdir($uploadFolder, 0755)) {
		      echo "WARNING: Upload folder ($uploadFolder) does not exist.\n";
		    }
		  }
		  
		  foreach ($_FILES as $file_info) {
		    $src = $file_info['tmp_name'];
		    $dst = $uploadFolder.'/'.$file_info['name'];
		    echo "move_uploaded_file('$src', '$dst');\n";
		    if (is_dir($uploadFolder)) {
		      move_uploaded_file($src, $dst);
		    }
		  }
		
	}
	
	
}









