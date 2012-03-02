<?php
class Admin_AdviceController extends Base_Controller_Action {
	
	public function indexAction()
	{
		$this->view->title	=	"Articles";
        $this->view->headTitle(" - ".$this->view->title);
		
		//create search form
		$form    = new Admin_Form_SearchAdvice();
		$elements=$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		
		//search Articles
		$where = "id IS NOT NULL";
		$order = "addedon DESC";
		$param = $this->_getParam('submit');
		if(isset($param) && $param=="Search")
		{
			$linkArray=array();
			if($this->getRequest()->isPost())
			{
				$params = $this->getRequest()->getPost();
			}
			else
			{
				$params = $this->getRequest()->getParams();	
			}
			
			foreach($params as $k => $v)
			{
				if($k<>"page" && $k<>"module" && $k<>"controller" && $k<>"action" && $v<>"")
				{
					$linkArray[$k]=$v;
				}
			}
			$this->view->linkArray = $linkArray;
			
			$title 			= $this->_getParam('title');
			$category_id	= $this->_getParam('category_id');
			$status			= $this->_getParam('status');
			
			//search by title
			if($title!="")
			{
				$where .= " AND title LIKE '%{$title}%'";
			}
			//search by category
			if($category_id!="")
			{
				$where .= " AND category_id = {$category_id}";
			}
			//search by status
			if($status!="")
			{
				$where .= " AND status = '{$status}'";
			}
			$options = array("title"=>$title,"category_id"=>$category_id,"status"=>$status);
			$form->populate($options);
		}
		$this->view->form = $form;
		
		//$settings	=	new Admin_Model_GlobalSettings();
		//$page_size	=	$settings->settingValue('pagination_size');
		$this->view->page_size=$page_size	= $this->_getParam('page_size',25);
		$model		=	new Application_Model_Advice();
		$page		=	$this->_getParam('page',1);
		
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		else
		{
			$this->view->errorMsg	=	"";
		}
	}
	
	public function addAction()
	{
		//$this->_helper->redirector('edit','advice','admin',array('id'=>13,'preview'=>'true'));
		
		$request	= $this->getRequest();
		$form		= new Admin_Form_Advice();
		
		//clear form element decorators
		$elements	=	$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('class');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
			
		$model		=	new Application_Model_Advice();
		$page_id	=	$this->_getParam('id');
		
		/*$this->view->msg = "";
		if($this->_getParam('m')=='s')
		{
			$this->view->msg="Advice has been saved successfully";
		}*/	
		
		//submit form
		if ($this->getRequest ()->isPost ()) 
		{
			$options = $request->getPost();
			//print_r($options);exit;
			if(trim($options['identifire'])=="")
			{
				$options['identifire']=$options['title'];
			}
			if(trim($options['identifire'])!="")
			{
				$sanitize=  new Base_Sanitize();
				$options['identifire'] = $sanitize->clearInputs($options['identifire']);
				$options['identifire'] = $sanitize->sanitize($options['identifire']);
			}
			if ($form->isValid ($options ))
			{
				/*------------------------------Image Upload ---------------------------*/
                $upload = new Zend_File_Transfer_Adapter_Http();
				
                if($upload->isValid()) {
                    $upload->setDestination("images/advice/");
                    try {
                        $upload->receive();
                    }
                    catch (Zend_File_Transfer_Exception $e) {
                        $msg = $e->getMessage();
                    }

                    $upload->setOptions(array('useByteString' => false));

                    $file_name = $upload->getFileName('name');  

                    $cardImageTypeArr = explode(".", $file_name);

                    $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

                    $target_file_name = "advice_".time().".{$ext}";

                    $targetPath = 'images/advice/'.$target_file_name;
                    $targetPathThumb = 'images/advice/thumb_'.$target_file_name;

                    $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

                    $filterFileRename -> filter($file_name);

                    $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
                    $thumb->resize(128, 84);
                    $thumb->save($targetPathThumb);
				 }
				/*------------------------------Image Upload ---------------------------*/
				
				$params = $options;
				$params['status']	= 1;
				if($options["savePublish"]!="Save and Publish")
				{
					$params['status']	= 0;
				}
				$params['name']		=	$target_file_name;// file name
				
				$model	= new Application_Model_Advice($params);
				$id		= $page_id = $model->save();
				
				$seo_url_title = $options['identifire'];
				$adviceM = new Application_Model_Advice();
				$advice  = $adviceM->find($id);
				$seo_url = "";
				$actual_url = "/advice/detail/id/{$id}";
				if(false!==$advice)
				{
					$sanitizeM		=	new Base_Sanitize();
					$category_id	=	$advice->getCategoryId();
					
					$categoryM		=	new Application_Model_Category();
					$category		=	$categoryM->find($category_id);

					if(false!==$category)
					{
						$seo_url = "/advice/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
					}
				}
				$seoUrlM	=	new Application_Model_SeoUrl();
				$seoUrl		=	$seoUrlM->fetchRow("actual_url='{$actual_url}'");
				if(false!==$seoUrl)
				{
					if($seo_url<>"")
					{
						$seoUrl->setSeoUrl($seo_url);
						$seoUrl->save();
					}
				}
				else
				{
					if($seo_url<>"")
					{
						$seoUrl=new Application_Model_SeoUrl();
						$seoUrl->setActualUrl($actual_url);
						$seoUrl->setSeoUrl($seo_url);
						$seoUrl->save();
					}
				}
				
				/*$seoUrlM=new Application_Model_SeoUrl();
				$soeUrl=$seoUrlM->fetchRow("actual_url='/advice/detail/id/{$id}'");
				if(false!==$soeUrl)
				{
					$soeUrl->setSeoUrl("/advice/".$options['identifire']);
					$soeUrl->save();
				}
				else
				{
					$seoUrlM=new Application_Model_SeoUrl();
					$seoUrlM->setActualUrl("/advice/detail/id/{$id}");
					$seoUrlM->setSeoUrl("/advice/".$options['identifire']);
					$seoUrlM->save();
				}*/
				//$this->_helper->redirector('index','advice','admin',array('id'=>$page_id,'m'=>'s'));
				
				if($options["savePublish"]=="Save and Publish")
				{
					$_SESSION['errorMsg'] = "Article has been saved & published successfully.";
					$this->_helper->redirector('index','advice','admin');
				}
				else if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$_SESSION['errorMsg'] = "Article has been saved successfully.";
					$this->_helper->redirector('index','advice','admin');
				}
				else
				{
					//$preview_url = Zend_Registry::get('siteurl')."/advice/detail/id/".$page_id."/preview/true";
					//echo "<script>window.open ('".$preview_url."','advice');</script>";
					$this->_helper->redirector('edit','advice','admin',array('id'=>$page_id,'preview'=>'true'));
				}
			}
		}
		
		$this->view->form = $form;		
	}
	
	
	public function editAction()
	{
		$id			=	$this->_getParam('id');
		$preview	=	false;
		$preview	=	$this->_getParam('preview');
		//echo "diana==>".base64_encode(85);
		$this->view->id			= $id;
		$this->view->preview	= $preview;
		
		$page	=	new Application_Model_Advice();
		$page	=	$page->find($id);
		
		$options = array(
            'categoryId'   => $page->getCategoryId(),
			'title'   => $page->getTitle(),
            'identifire' =>$page->getIdentifire(),
			'name'	  => $page->getName(),
  	  		'content'   => $page->getContent(),
            'synopsis'   => $page->getSynopsis(),
  	  		'metaTitle'   => $page->getMetaTitle(),
  	  		'metaDescription'   => $page->getMetaDescription(),
  	  		'metaKeyword'   => $page->getMetaKeyword(),
  	  		'status'   => $page->getStatus(),
			'name'	=> 	$page->getName(),
			'userId'   => $page->getUserId(),
        );
		
        $request = $this->getRequest();
        $form    = new Admin_Form_Advice();
		
		//clear form element decorators
		$elements	=	$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('class');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		
        //$this->view->type = $page->getType();
        $this->view->imgName = $page->getName();
        $form->populate($options);
		
        
	if ($request->isPost()) 
        { 
        	$options = $request->getPost();
            
			if(trim($options['identifire'])=="")
			{
				$sanitize=  new Base_Sanitize();
				$options['identifire']=$options['title'];
			}
			if(trim($options['identifire'])!="")
			{
				$sanitize=  new Base_Sanitize();
				$options['identifire']	=	$sanitize->clearInputs($options['identifire']);
				$options['identifire']	=	$sanitize->sanitize($options['identifire']);

				//update seo url table
				$seo_url_title	=	$options['identifire'];
				$adviceM		=	new Application_Model_Advice();
				$advice			=	$adviceM->find($id);
				$seo_url		=	"";
				$actual_url		=	"/advice/detail/id/{$id}";
				if(false!==$advice)
				{
					$sanitizeM		=	new Base_Sanitize();
				   //$category_id	=	$advice->getCategoryId();
					$category_id	=	$options['categoryId'];
					$categoryM		=	new Application_Model_Category();
					$category		=	$categoryM->find($category_id);

					if(false!==$category)
					{
						$seo_url = "/advice/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
					}
				}
				$seoUrlM	=	new Application_Model_SeoUrl();
				$soeUrl		=	$seoUrlM->fetchRow("actual_url='{$actual_url}'");
				if(false!==$soeUrl)
				{
					if($seo_url<>"")
					{ 
						$soeUrl->setSeoUrl($seo_url);
						$soeUrl->save();
					}
				}
				else
				{                       
					if($seo_url<>"")
					{
						$seoUrl = new Application_Model_SeoUrl();
						$seoUrl->setActualUrl($actual_url);
						$seoUrl->setSeoUrl($seo_url);
						$seoUrl->save();
					}                       
				}
			}
			
			//save data
			if ($form->isValid($options))
        	{
                //set previous image name if not uploaded new one
				$options['name'] =	$page->getName();
				
				/*------------------------------ Image Upload START ---------------------------*/
                                $upload = new Zend_File_Transfer_Adapter_Http();
				
				if($upload->isValid())
				{
					$upload->setDestination("images/advice/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}
					//unlink previous uploaded image files
					unlink("images/advice/".$page->getName());
					unlink("images/advice/thumb_".$page->getName());
					
					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('name');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "advice_".time().".{$ext}";

					$targetPath = 'images/advice/'.$target_file_name;
					$targetPathThumb = 'images/advice/thumb_'.$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(128, 84);
					$thumb->save($targetPathThumb);
					// file name
					$options['name'] =	$target_file_name;
				 }
				/*------------------------------ Image Upload END ---------------------------*/ 
				$options['status']	= $page->getStatus();
				if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$options['status']	= 0;
				}
				if($options["savePublish"]=="Save and Publish")
				{
					$options['status']	= 1;
				}	
				$page->setOptions($options);
                $page->save();                
                //return $this->_helper->redirector('index','advice',"admin",Array('msg'=>base64_encode("'{$page->getTitle()}' has been updated successfully!")));
				
				if($options["savePublish"]=="Save and Publish")
				{
					$_SESSION['errorMsg'] = "Article has been saved & published successfully.";
					$this->_helper->redirector('index','advice','admin');
				}
				else if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$_SESSION['errorMsg'] = "Article has been saved successfully.";
					$this->_helper->redirector('index','advice','admin');
				}
				else
				{
					$this->_helper->redirector('edit','advice','admin',array('id'=>$id,'preview'=>'true'));
				}
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $this->view->form=$form;
	}//end function
	
	

	public function statusAction()
	{	
		$id=$this->_getParam('id');
		$model=new Application_Model_Advice();
		$val	=	$model->find($id);
		
		if($val->getStatus()==1)
		{
			$val->setStatus(0);
			
		}else{
			$val->setStatus(1);
			
		}
		$val->save();
		return $this->_helper->redirector('index','advice',"admin");
	
	}
	
	public function deleteAction()
	{
		$id	=	$this->_getParam('id');
		//$model=new Application_Model_Advice();		
		//$model->delete("id={$id}");
		
		$db	= Zend_Registry::get("db");
		//move advice into deleted table associated with category
		$adviceSQL	= "INSERT INTO advice_deleted SELECT * FROM advice WHERE id={$id}";
		$db->query($adviceSQL);
		
		//now delete advice from original advice table
		$delAdviceSQL	= "DELETE FROM advice WHERE id={$id}";
		$db->query($delAdviceSQL);
		
		$_SESSION['errorMsg']	=	"Advice has been deleted!";		
		return $this->_helper->redirector('index','advice',"admin");
	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 28-Feb-2011
	 * @Description: Edit Advice hom page content CMS
	 */
	public function homeAction()
	{
		$identifire = "advice";
		$page	=	new Application_Model_Page();
		$page	=	$page->fetchRow("identifire='{$identifire}'");
		
		$options = array(
            'title'   => $page->getTitle(),
	  	  	'identifire'   => $page->getIdentifire(),
  	  		'content'   => $page->getContent(),
  	  		'metaTitle'   => $page->getMetaTitle(),
  	  		'metaDescription' => $page->getMetaDescription(),
  	  		'metaKeyword'   => $page->getMetaKeyword(),
  	  		'status'   => $page->getStatus(),		
        );
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Page();
		
		//clear form element decorators
		$elements	=	$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('class');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		
        $form->removeElement("identifire");
		$form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
        		$page->setOptions($options);
                $resDB = $page->save();
				if($resDB)
				{
					$errorMsg = "Home page content has been been saved.";
				}
				else
				{
					$errorMsg = "Error occured, please try again later.";
				}
				$this->view->errorMsg	=	$errorMsg;
            }
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $this->view->form			=	$form;
	}//end function
}

