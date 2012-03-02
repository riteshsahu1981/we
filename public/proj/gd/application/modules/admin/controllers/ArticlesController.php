<?php
class Admin_ArticlesController extends Base_Controller_Action
{
	public function indexAction()
	{
		$this->view->title	=	"Articles";
        $this->view->headTitle(" - ".$this->view->title);
		
		//create search form
		$form    = new Admin_Form_SearchArticles();
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
		$model		=	new Application_Model_Articles();
		$page		=	$this->_getParam('page',1);
		
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
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
	
	public function editAction()
	{
		$id	=	$this->_getParam('id');
		$preview	=	false;
		$preview	=	$this->_getParam('preview');
		$this->view->id			= $id;
		$this->view->preview	= $preview;
		
		$form    = new Admin_Form_Articles();
		
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
		
		$page	=	new Application_Model_Articles();
		$page	=	$page->find($id);
		$this->view->imgName = $page->getImage();
		
		$options = array(
                        'title'   => $page->getTitle(),
						'identifire' =>$page->getIdentifire(),
						'content'   => $page->getContent(),
						'synopsis'   => $page->getSynopsis(),
						'metaTitle'   => $page->getMetaTitle(),
						'metaDescription'   => $page->getMetaDescription(),
						'categoryId'   => $page->getCategoryId(),
						'userId'   => $page->getUserId(),
						'metaKeyword'   => $page->getMetaKeyword(),
						'status'   => $page->getStatus()
						);
		
		$request = $this->getRequest();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
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
                    $articleM		=	new Application_Model_Articles();
                    $article		=	$articleM->find($id);
                    $seo_url		=	"";
                    $actual_url		=	"/work-study-volunteer/article-detail/id/{$id}";
                    if(false!==$article)
                    {
                        $sanitizeM		=	new Base_Sanitize();
                       //$category_id	=	$article->getCategoryId();
					    $category_id	=	$options['categoryId'];
                        $categoryM		=	new Application_Model_Category();
                        $category		=	$categoryM->find($category_id);

                        if(false!==$category)
                        {
                            //$seo_url="/work-study-volunteer/".$category->getType()."/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
							$seo_url = "/work-study-volunteer/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
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
                
            if ($form->isValid($options))
        	{
        		
				/*------------------------------ Image Upload START ---------------------------*/
                $upload = new Zend_File_Transfer_Adapter_Http();
				
				if($upload->isValid())
				{
					$upload->setDestination("images/articles/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}
					//unlink previous uploaded image files
					if($page->getImage() != "")
					{
						unlink("images/articles/".$page->getImage());
						unlink("images/articles/thumb_".$page->getImage());
					}
					
					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('image');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "art_".time().".{$ext}";

					$targetPath = 'images/articles/'.$target_file_name;
					$targetPathThumb = 'images/articles/thumb_'.$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(100, 64);
					$thumb->save($targetPathThumb);
					// file name
					$options['image'] =	$target_file_name;
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
				//$this->view->msg = "Article has been saved successfully.";
                //return $this->_helper->redirector('index','page',"admin",Array('msg'=>base64_encode("'{$page->getTitle()}' has been updated successfully!")));
				
				if($options["savePublish"]=="Save and Publish")
				{
					$_SESSION['errorMsg'] = "Article has been saved & published successfully.";
					$this->_helper->redirector('index','articles','admin');
				}
				else if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$_SESSION['errorMsg'] = "Article has been saved successfully.";
					$this->_helper->redirector('index','articles','admin');
				}
				else
				{
					$this->_helper->redirector('edit','articles','admin',array('id'=>$id,'preview'=>'true'));
				}
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $this->view->form=$form;
	}

	public function addAction()
	{
		$request = $this->getRequest();
		$form = new Admin_Form_Articles();
		
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
		
		$model = new Application_Model_Articles();
		$page_id=$this->_getParam('id');
		
		$this->view->msg="";
		if($this->_getParam('m')=='s')
		{
			$this->view->msg="Article has been saved successfully.";
		}
		
		//select logged in user as default seleted for Author
		$usersNs = new Zend_Session_Namespace("members");
		$author = array('userId' => $usersNs->userId);
		$form->populate($author);
		
		/*-----------------------------------------*/
		if ($this->getRequest ()->isPost ()) 
		{
			$options=$request->getPost();
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
			if ($form->isValid ( $options))
			{
				/*------------------------------Image Upload ---------------------------*/            
                $upload = new Zend_File_Transfer_Adapter_Http();
				$target_file_name = "";
                if($upload->isValid())
				{
                    $upload->setDestination("images/articles/");
                    try
					{
                        $upload->receive();
                    }
                    catch (Zend_File_Transfer_Exception $e)
					{
                        $msg = $e->getMessage();
                    }

                    $upload->setOptions(array('useByteString' => false));

                    $file_name = $upload->getFileName('image');  

                    $cardImageTypeArr = explode(".", $file_name);

                    $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

                    $target_file_name = "art_".time().".{$ext}";

                    $targetPath = 'images/articles/'.$target_file_name;
                    $targetPathThumb = 'images/articles/thumb_'.$target_file_name;

                    $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

                    $filterFileRename -> filter($file_name);

                    $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
                    $thumb->resize(100, 64);
                    $thumb->save($targetPathThumb);
				 }//end if
				/*------------------------------Image Upload ---------------------------*/
			
				$params = $options;
				$params['status'] = 1;
				if($options["savePublish"]!="Save and Publish")
				{
					$params['status']	= 0;
				}
				//commented by mahipal on 29-dec-2010 and replaced with user dropdown list
				//$usersNs = new Zend_Session_Namespace("members");
				//$params['userId']		=	$usersNs->userId;
				
				$params['image']	=	$target_file_name;	// file name
				
				$model	= new Application_Model_Articles($params);
				$id		= $page_id=$model->save();

				$seo_url_title = $options['identifire'];
				$articleM = new Application_Model_Articles();
				$article = $articleM->find($id);
				$seo_url = "";
				$actual_url = "/work-study-volunteer/article-detail/id/{$id}";
				if(false!==$article)
				{
					$sanitizeM=new Base_Sanitize();
					$category_id=$article->getCategoryId();
					$categoryM= new Application_Model_Category();
					$category=$categoryM->find($category_id);

					if(false!==$category)
					{
						//$seo_url="/work-study-volunteer/".$category->getType()."/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
						$seo_url = "/work-study-volunteer/".$sanitizeM->sanitize($category->getName())."/".$seo_url_title;
					}
				}
				$seoUrlM=new Application_Model_SeoUrl();
				$seoUrl=$seoUrlM->fetchRow("actual_url='{$actual_url}'");
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
				//$this->_helper->redirector('add','articles','admin',array('id'=>$page_id,'m'=>'s'));
				if($options["savePublish"]=="Save and Publish")
				{
					$_SESSION['errorMsg'] = "Article has been saved & published successfully.";
					$this->_helper->redirector('index','articles','admin');
				}
				else if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$_SESSION['errorMsg'] = "Article has been saved successfully.";
					$this->_helper->redirector('index','articles','admin');
				}
				else
				{
					$this->_helper->redirector('edit','articles','admin',array('id'=>$page_id,'preview'=>'true'));
				}
			}//end if
		}//end if
		$this->view->form = $form;		
	}//end function
	
	public function statusAction()
	{	
		$id=$this->_getParam('id');
		$model=new Application_Model_Articles();
		$val	=	$model->find($id);
		if($val->getStatus()==1)
		{
			$msg = "Article has been unpublished successfully!";
			$val->setStatus(0);			
		}
		else
		{
			$msg = "Article has been published successfully!";
			$val->setStatus(1);
		}
		$val->save();
		$_SESSION['errorMsg']	=	$msg;
		return $this->_helper->redirector('index','articles',"admin");	
	}
	
	public function deleteAction()
	{
		$id		=	$this->_getParam('id');
		$model	=	new Application_Model_Articles();
		
		//added by Mahipal Adhikari on 5-jan-2011, move Article to deleted table before deleting permanently
		$db		= Zend_Registry::get("db");
		$sSQL	= "INSERT INTO articles_deleted SELECT * FROM articles WHERE id={$id}";
		$db->query($sSQL);
		
		//now delete article
		$model->delete("id={$id}");
		
		$_SESSION['errorMsg']	=	"Article has been deleted successfully!";		
		return $this->_helper->redirector('index','articles',"admin");
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 28-Feb-2011
	 * @Description: Edit Advice hom page content CMS
	 */
	public function homeAction()
	{
		$identifire = "work-study-volunteer";
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

