<?php
class Admin_JournalsController extends Base_Controller_Action
{
	public function indexAction()
	{
		$this->view->title="Member's Journals";
        $this->view->headTitle(" - ".$this->view->title);
		
		//$settings	=	new Admin_Model_GlobalSettings();
		//$page_size	=	$settings->settingValue('pagination_size');
		//$page_size	=	1;
		$this->view->page_size=$page_size	= $this->_getParam('page_size',25);
		
		$model		=	new Application_Model_Blog();
		$page		=	$this->_getParam('page',1);
		
		//create search form
		$form    = new Admin_Form_SearchJournals();
		$elements=$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			//$element->removeDecorator('class');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		
		//search journals
		$where = "id IS NOT NULL";
		$order = "addedon DESC";
		$param = $this->_getParam('submit');
		//if($this->getRequest()->isPost())
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
			$publish		= $this->_getParam('publish');
			$featured		= $this->_getParam('featured');
			
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
			//search by publish
			if($publish!="")
			{
				$where .= " AND publish = '{$publish}'";
			}
			//search by featured
			if($featured!="")
			{
				$where .= " AND featured = '{$featured}'";
			}
			$options = array("title"=>$title,"category_id"=>$category_id,"status"=>$status,"publish"=>$publish,"featured"=>$featured);
			$form->populate($options);
		}
		$this->view->form = $form;
		
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
	
	public function editAction()
	{
		$id		=	$this->_getParam('id');
		$page	=	new Application_Model_Blog();
		$page	=	$page->find($id);
		
		$tag	=	new Application_Model_Tags();
        //$tags	=	$tag->getBlogTags($id,true);
	    $tags	=	$tag->getTagsForEdit($id);
		
		//$tags	=	$page->getTags(); //added by mahipal adhikari on 15-Feb-2011 to get tags for edit from Blog table itself
		
            $options = array(
                'title'   		=> $page->getTitle(),
		        'categoryId'   	=> $page->getCategoryId(),
		 	    'location'   	=> $page->getLocation(),
			    'tags'			=> $tags,
			    'content'		=> $page->getContent(),
			    'publish'		=> $page->getPublish(),
			    'journalId'		=> $page->getJournalId(),
  	  		    'status'   		=> $page->getStatus(),
				'weight'        => $page->getWeight(),		
            );
		
		$request = $this->getRequest();
        $form    = new Application_Form_Blog();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
        		//Zend::dump($options);
        		//print_r($options);
                $page->setOptions($options);
                $page->save();

                    /*-----tags--------*/
                   $blog_id= $id;
                    if($options['tags']<>""){
                    $arrTags=explode(",",$options['tags']);
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
                            $albumTagM=new Application_Model_BlogTag();
                            $albumTagM->setBlogId($blog_id);
                            $albumTagM->setTagId($tag_id);
                            $albumTagM->save();

                    }
                    }
                    /*----------tags-------*/
			 $this->view->successMsg="Blog Id : {$blog_id}' has been updated successfully!";		
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
		$model = new Application_Model_Articles();
		$page_id=$this->_getParam('id');
		
		$this->view->msg="";
		if($this->_getParam('m')=='s')
			$this->view->msg="Advice category saved successfully";			
		
		/*-----------------------------------------*/
		
		if ($this->getRequest ()->isPost ()) 
		{
			if ($form->isValid ( $request->getPost () )) 
			{
				$params=$form->getValues();
				$params['status']=1;
				$usersNs = new Zend_Session_Namespace("members");
				$params['userId']=$usersNs->userId;
				$model = new Application_Model_Articles($params);
				$page_id=$model->save();
				$this->_helper->redirector('add','articles','admin',array('id'=>$page_id,'m'=>'s'));
			}
		}
		
		$this->view->form = $form;		
	}
	
	public function blockAction()
	{
		$id=$this->_getParam('id');
		$model1=new Application_Model_Blog();
		$model=	$model1->find($id);
		
		
		if($model->getPublish()=="published")
		{
			$model->setPublish("draft");
			$publish="unpublished";
		}
		else
		{
			$model->setPublish('published');
			$publish="published";
		}
		$model->save();
		return $this->_helper->redirector('index','journals',"admin",Array('msg'=>base64_encode("Blog [Id : {$model->getId()}] has been $publish!")));
	}
    public function featureAction()
	{
		$id=$this->_getParam('id');
		$model1=new Application_Model_Blog();
		$model=	$model1->find($id);


		if($model->getFeatured()==1)
		{
			$model->setFeatured(0);
			$publish="not featured";
		}
		else
		{
			$model->setFeatured(1);
			$publish="featured";
		}
		$model->save();
		return $this->_helper->redirector('index','journals',"admin",Array('msg'=>base64_encode("Blog [Id : {$model->getId()}] has been marked as $publish!")));
	}
	
	public function deleteAction()
	{
		$id = $this->_getParam('id');
		
		$model	=	new Application_Model_Blog();
		//$model->delete("id={$id}");
		
		//added by Mahipal Adhikari on 5-jan-2011, move Blogs to deleted table before deleting permanently
		$model->deleteBlog($id);
		
		//$tag	=	new Application_Model_BlogTag();
		//$tag->delete("blog_id={$id}");
		
		$_SESSION['errorMsg']	=	"Journal post has been deleted!";
		
		return $this->_helper->redirector('index','journals',"admin");
	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 22-Feb-2011
	 * @Description: Display blog tags
	 */
	public function tagsAction()
	{
		//$settings	=	new Admin_Model_GlobalSettings();
		//$page_size	=	$settings->settingValue('pagination_size');
		$page_size	= $this->_getParam('page_size',25);
		$model		=	new Application_Model_Tags();		
		
		$pageObj	=	new Base_Paginator();
		$page		=	$this->_getParam('page',1);
		$paginator	=	$pageObj->fetchPageData($model,$page,$page_size,null, "tag ASC");
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->paginator	=	$paginator;
		
		//set error message
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
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 22-Feb-2011
	 * @Description: Delete tags and related blog tags
	 */
	public function deleteTagAction()
	{
		//get request params
		$id		= $this->_getParam('id');
		$page	= $this->_getParam('page');
		
		//delete blog tags related to this tag
		$blogTagM	=	new Application_Model_BlogTag();
		$blogTagM->delete("tag_id={$id}");
		
		//delete tag
		$tagM	=	new Application_Model_Tags();
		$tagM->delete("id={$id}");
		
		//set message and redirect
		$_SESSION['errorMsg']	=	"Tag has been deleted successfully!";
		//return $this->_helper->redirector('tags','journals',"admin");
		return $this->_helper->redirector('tags','journals',"admin",Array('page'=>$page));		
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 23-Feb-2011
	 * @Description: Manage journal Home page content
	 */
	public function cmsAction()
	{
		//set error message
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Application_Model_JournalHome();
		$modelRes	=	$modelRes->find($id);

		$options = array(
						'loginText1'	=> $modelRes->getLoginText1(),
						'loginText2'	=> $modelRes->getLoginText2(),
						'logoutText1'	=> $modelRes->getLogoutText1(),
						'logoutText2'	=> $modelRes->getLogoutText2(),
						'metaTitle'		=> $modelRes->getMetaTitle(),
						'metaKeyword'	=> $modelRes->getMetaKeyword(),
						'metaDescription'=> $modelRes->getMetaDescription(),
						'status'		=> $modelRes->getStatus()
						);

		$form    = new Admin_Form_JournalHome();
		$form->populate($options);
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				$modelRes->setOptions($options);
				$updateRes = $modelRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg']	=	"Content has been updated successfully.";
					$this->_helper->redirector('cms','journals','admin',array('id'=>$id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}
			}//end if
			else
			{
				$form->reset();
				$form->populate($options);
			} 		
		}//end if
		
		//set form
		$this->view->form=$form;				
	}
}

