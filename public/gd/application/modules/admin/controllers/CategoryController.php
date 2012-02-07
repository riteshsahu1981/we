<?php
class Admin_CategoryController extends Base_Controller_Action
{
	public function indexAction()
	{
		$this->view->type = $type = $this->_getParam('type',"other");
		$this->view->title=ucfirst($type)." Category ";
		
		//change title for Journals
		if($type=="blog")
		{
			$this->view->title ="Journal Category ";
		}
		
        $this->view->headTitle(" -  ".$this->view->title);
		$model=new Application_Model_Category();
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$where="status!='deleted' AND type='{$type}'";
		$paginator=$pageObj->fetchPageData($model,$page,$page_size,$where,"weight ASC");
		
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->msg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		else
		{
			$this->view->errorMsg	=	"";
		}
	}

	public function addAction()
    {
    	$this->view->type=$type=$this->_getParam('type',"other");
    	
		$this->view->title=ucfirst($type)." Category - Add";
        $this->view->headTitle(" -  ".$this->view->title);
        
        $form = new Admin_Form_Category();
        $this->view->form = $form;
		
		//remove weight field for all type of categories except advice and wsv category
		if($type=="album" || $type=="blog" || $type=="work" || $type=="study" || $type=="volunteer" || $type=="other")
		{
			$form->removeElement('weight');
		}
		//Url Link and Url Text fields should appear for WSV categories only
		if($type!="wsv")
		{
			$form->removeElement('urlText');
			$form->removeElement('urlLink');
		}
        $this->view->successMsg="";
        if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {
            	$formData['type']=$type;
            	$formData['parentId']="0";
            	$this->view->warningMsg='';
                $model = new Application_Model_Category($formData);
                $id=$model->save();

                $upload = new Zend_File_Transfer_Adapter_Http();
                //---main image
		        if($upload->isValid('image'))
		        {
		        	
		        	$upload->setDestination("images/uploads/");
		        	try 
		        	{
					 	$upload->receive('image');
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg= $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('image');
					$cardImageTypeArr = explode(".", $file_name);
					$ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
					$target_file_name = "category_".$id.".{$ext}";
					$targetPath = 'media/picture/category/'.$type.'/'.$target_file_name;
					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);
					$options['image']=$target_file_name;

					/*--- Generate Thumbnail ---*/
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(100,100);
					$thumb->save($targetPath = 'media/picture/category/'.$type.'/thumb_'.$target_file_name);

					$model=new Application_Model_Category();
		        	$model=$model->find($id);
		        	$model->setImage($target_file_name);
		        	$model->save();
		        }
		        //-----------
				$form->reset();
                $this->view->successMsg="Category added successfully. Category id : $id";
            }
			else
			{
                $form->populate($formData);
            }
        } 
    }
    
	public function editAction()
	{
		$this->view->type=$type=$this->_getParam('type',"other");
		$this->view->title=ucfirst($type)." Category - Edit";
        $this->view->headTitle(" -  ".$this->view->title);
        
		$id=$this->_getParam('id');
		$model1=new Application_Model_Category();
		$model=$model1->find($id);
		
		$options['name']=$model->getName();
		$options['urlText']=$model->getUrlText();
		$options['urlLink']=$model->getUrlLink();
		$options['description']=$model->getDescription();
		$options['image']=$model->getImage();
		$options['status']=$model->getStatus();
		$options['weight']=$model->getWeight();
		$this->view->imgName = $model->getImage();
		$request = $this->getRequest();
        $form    = new Admin_Form_Category();
        $form->populate($options);
        
		//remove weight field for all type of categories except advice and wsv category
		if($type=="album" || $type=="blog" || $type=="work" || $type=="study" || $type=="volunteer" || $type=="other")
		{
			$form->removeElement('weight');
		}
		//Url Link and Url Text fields should appear for WSV categories only
		if($type!="wsv")
		{
			$form->removeElement('urlText');
			$form->removeElement('urlLink');
		}
		
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
                $category_id=$model->getId();
                $upload = new Zend_File_Transfer_Adapter_Http();
                //---main image
		        if($upload->isValid('image'))
		        {
		        	$upload->setDestination("images/uploads/");
		        	try 
		        	{
					 	$upload->receive('image');
					} 
					catch (Zend_File_Transfer_Exception $e) 
					{
					 	$msg= $e->getMessage();
					}			 
								 
					$upload->setOptions(array('useByteString' => false));
					//delete existing files
					if($model->getImage()!="" && file_exists("media/picture/category/".$type."/".$model->getImage()))
					{
						unlink("media/picture/category/".$type."/".$model->getImage());
						unlink("media/picture/category/".$type."/thumb_".$model->getImage());
					}
					$id=$category_id;
					$file_name = $upload->getFileName('image');
		 		 	$cardImageTypeArr = explode(".", $file_name);
		 		 	$ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]); 			 	 
		 		 	$target_file_name = "category_".$id.".{$ext}";
				 	$targetPath = 'media/picture/category/'.$type.'/'.$target_file_name;
				 	$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);
					$options['image']=$target_file_name;
					 
					/*--- Generate Thumbnail ---*/ 
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(100,100);
					$thumb->save($targetPath = 'media/picture/category/'.$type.'/thumb_'.$target_file_name);
		        }
		        //-----------
				
		        $model->setOptions($options);
                $model->save($model);
		        $model->updateRelatedSeoUrls($id);
                $this->view->successMsg = "Category has been updated successfully!";
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        
        $this->view->form=$form;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 5-Jan-2011
	 * @Description: This function used to update category status
	 */
	public function statusAction()
	{	
		$id		=	$this->_getParam('id');
		$type	=	$this->_getParam('type');
		$catM	=	new Application_Model_Category();
		$catRes  =	$catM->find($id);
		if($catRes)
		{
			if($catRes->getStatus()=="published")
			{
				$status			= "unpublished";
				$articleStatus	= 0;
				$blogStatus		= "draft";
			}
			else
			{
				$status			= "published";
				$articleStatus	= 1;
				$blogStatus		= "published";
			}			
			$catRes->setStatus($status);
			$updateRes = $catRes->save();
			$msg = "Category has been {$status} successfully!";
			
			if($updateRes)
			{
				$msg = $msg;
				
				$db		= Zend_Registry::get("db");
				//publish/unpublish Articles associated with category
				$upArticleSQL	= "UPDATE articles SET status='{$articleStatus}' WHERE category_id={$id}";
				$db->query($upArticleSQL);
				
				//publish/unpublish Blogs associated with category
				$upBlogSQL	= "UPDATE blog SET publish='{$blogStatus}' WHERE category_id={$id}";
				$db->query($upBlogSQL);
				
				//publish/unpublish Advice associated with category
				$upAdviceSQL = "UPDATE advice SET status='{$articleStatus}' WHERE category_id={$id}";
				$db->query($upAdviceSQL);
			}
			else
			{
				$msg = "Error occured while updating category status!";
			}
		}
		else
		{
			$msg = "Invalid request, no category found!";
		}
		//set mesage in session and redirect user to index
		$_SESSION['errorMsg'] = $msg;
		$this->_helper->redirector('index','category',"admin",Array('type'=>$type));
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 5-Jan-2011
	 * @Description: This function used to delete user(simply change user status as 'deleted')
	 */
	public function deleteAction()
	{
		$id		=	$this->_getParam('id');
		$type	= 	$this->_getParam('type');
		
		$catM	=	new Application_Model_Category();
		//$catM->delete("id={$id}");
		$catRes  =	$catM->find($id);
		if($catRes)
		{
			$catRes->setStatus('deleted');
			$catRes->save();
			
			//delete all data associated with category
			$catM->deleteCategoryData($id);
			
			//set message
			$msg = "Category has been deleted successfully!";
		}
		else
		{
			$msg = "Invalid request, no category found!";
		}
		//set mesage in session and redirect user to index
		$_SESSION['errorMsg'] = $msg;
		$this->_helper->redirector('index','category',"admin",Array('type'=>$type));
	}//end function
}
