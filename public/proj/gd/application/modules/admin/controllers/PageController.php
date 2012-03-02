<?php
class Admin_PageController extends Base_Controller_Action
{
	//Fixed contenet, user can not modify identifire for these pages
	var $fixedPages = array("contact", "privacy-policy", "advice", "work-study-volunteer", "about", "work-for-us", "terms-conditions", "press-media", "advertising-and-partnerships", "safety-policy", "competition", "video", "photos");
	
	var $fixedOtherCMSPages = array("advice","work-study-volunteer"); //these pages are used for Advice, WSV home page
	
	public function indexAction()
	{
		$this->view->title	=	"Pages";
		//echo "sdfdfsdfsdf";exit;
        $this->view->headTitle(" - ".$this->view->title);
		
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		else
		{
			$this->view->errorMsg	=	"";
		}
		
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
		
		$model		=	new Application_Model_Page();
		$page		=	$this->_getParam('page',1);
		$fixedPages	=	implode(",", $this->fixedOtherCMSPages);
		$where		=	"id IS NOT NULL AND identifire NOT IN ('advice', 'work-study-volunteer')";
		$order		=	"addedon ASC";
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		$this->view->fixedPages	=	$this->fixedPages;
	}
	
	public function editAction()
	{
		$id		=	$this->_getParam('id');
		
		$preview	=	false;
		$preview	=	$this->_getParam('preview');
		
		$this->view->identifire	= $this->_getParam('identifire');
		$this->view->preview	= $preview;
		
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
		
		$page	=	new Application_Model_Page();
		$page	=	$page->find($id);
		
		$options = array(
            'title'   => $page->getTitle(),
	  	  	'identifire'   => $page->getIdentifire(),
  	  		'content'   => $page->getContent(),
  	  		'metaTitle'   => $page->getMetaTitle(),
  	  		'metaDescription'   => $page->getMetaDescription(),
  	  		'metaKeyword'   => $page->getMetaKeyword(),
  	  		'status'   => $page->getStatus(),		
        );
		
		$request = $this->getRequest();
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	if ($form->isValid($options))
        	{
        		//update SEO URL START
				/*
				$sanitize=  new Base_Sanitize();
				if(trim($options['identifire'])=="")
				{
					$options['identifire']=$options['title'];
				}
				if(trim($options['identifire'])!="")
				{
					$options['identifire']	=	$sanitize->clearInputs($options['identifire']);
					$options['identifire']	=	$sanitize->sanitize($options['identifire']);

					//update seo url table
					$seo_url_title	=	$options['identifire'];
					
					$actual_url		=	"/index/contact";
					$seo_url		=	"/contact";
					if($page->getIdentifire()!="contact")
					{
						$actual_url		=	"/index/page/identifire/{$page->getIdentifire()}";
						$new_actual_url	=	"/index/page/identifire/{$seo_url_title}";
						$seo_url		=	"/{$seo_url_title}";
					}
					$seoUrlM	=	new Application_Model_SeoUrl();
					$soeUrl		=	$seoUrlM->fetchRow("actual_url='{$actual_url}'");
					//print_r($soeUrl);
					//exit;
					if(false!==$soeUrl)
					{
						if($seo_url<>"")
						{ 
							$soeUrl->setActualUrl($new_actual_url);
							$soeUrl->setSeoUrl($seo_url);
							$soeUrl->save();
						}
					}
					else
					{
						if($seo_url<>"")
						{
							$seoUrl = new Application_Model_SeoUrl();
							$seoUrl->setActualUrl($new_actual_url);
							$seoUrl->setSeoUrl($seo_url);
							$seoUrl->save();
						}                       
					}
				}
				//update SEO URL END
				*/
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
                //return $this->_helper->redirector('index','page',"admin",Array('msg'=>base64_encode("'{$page->getTitle()}' has been updated successfully!")));
			    if($options["savePublish"]=="Save and Publish")
				{
					$_SESSION['errorMsg'] = "Page has been saved & published successfully.";
					$this->_helper->redirector('index','page','admin');
				}
				else if($options["saveUnpublish"]=="Save and Unpublish")
				{
					$_SESSION['errorMsg'] = "Page has been saved successfully.";
					$this->_helper->redirector('index','page','admin');
				}
				else
				{
					$identifire = $options['identifire'];
					$this->_helper->redirector('edit','page','admin',array('id'=>$id,'identifire'=>$identifire,'preview'=>'true'));
				}
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $this->view->form		=	$form;
		$this->view->pageIdentifire =	$page->getIdentifire();
		$this->view->fixedPages	=	$this->fixedPages;
	}

	public function addAction()
	{
		$request = $this->getRequest();
		$form = new Admin_Form_Page();
		
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
		
		$model = new Application_Model_Page();
		$page_id=$this->_getParam('id');
		
		$this->view->msg="";
		if($this->_getParam('m')=='s')
		{
			$this->view->msg="Page saved successfully";
		}	
		else if($this->_getParam('m')=='e')
		{
			$this->view->msg="Page identifire already exist";
		}	
		//submit form	
		if ($this->getRequest ()->isPost ())
		{
			if ($form->isValid ( $request->getPost () )) 
			{
				$params	=	$form->getValues();
				$params['status'] = 1;
				
				if($options["savePublish"]!="Save and Publish")
				{
					$params['status']	= 0;
				}
				$usersNs = new Zend_Session_Namespace("members");
				$params['userId']=$usersNs->userId;
				
				//Set SEO page URL START, added by Mahipal on 23-Feb-2011					
				$sanitize=  new Base_Sanitize();
				if(trim($params['identifire'])=="")
				{
					$params['identifire'] = $params['title'];
				}
				if(trim($params['identifire'])!="")
				{
					$params['identifire']	=	$sanitize->clearInputs($params['identifire']);
					$params['identifire']	=	$sanitize->sanitize($params['identifire']);
					
					$seo_url_title	=	$params['identifire'];
					$actual_url		=	"/index/page/identifire/{$seo_url_title}";
					$seo_url		=	"/{$seo_url_title}";
					
					if($seo_url<>"")
					{
						$seoUrl = new Application_Model_SeoUrl();
						$seoUrl->setActualUrl($actual_url);
						$seoUrl->setSeoUrl($seo_url);
						$seoUrl->save();
					}
				}
				//Set SEO page URL END
					
				$model = new Application_Model_Page($params);
				
				try
				{
					$page_id = $model->save();
					//$this->_helper->redirector('add','page','admin',array('id'=>$page_id,'m'=>'s'));
					if($options["savePublish"]=="Save and Publish")
					{
						$_SESSION['errorMsg'] = "Page has been saved & published successfully.";
						$this->_helper->redirector('index','page','admin');
					}
					else if($options["saveUnpublish"]=="Save and Unpublish")
					{
						$_SESSION['errorMsg'] = "Page has been saved successfully.";
						$this->_helper->redirector('index','page','admin');
					}
					else
					{
						//$this->_helper->redirector('edit','page','admin',array('id'=>$page_id,'preview'=>'true'));
						$identifire = $params['identifire'];
					    $this->_helper->redirector('edit','page','admin',array('id'=>$page_id,'identifire'=>$identifire,'preview'=>'true'));
					}
				}
				catch(Exception $e)
				{
					$this->_helper->redirector('add','page','admin',array('id'=>$page_id,'m'=>'e'));
				}				
			}
		}		
		$this->view->form = $form;		
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 5-Jan-2011
	 * @Description: Delete CMS page permanently
	 */
	public function deleteAction()
	{
		$id		=	$this->_getParam('id');
		$page	= 	$this->_getParam('page');
			
		$model	=	new Application_Model_Page();
		$deleteRes = $model->delete("id={$id}");
		if($deleteRes)
		{		
			$this->_helper->redirector('index','page',"admin",Array('page'=>$page, 'msg'=>base64_encode("Page has been deleted successfully!")));
		}
		else
		{
			$this->_helper->redirector('index','page',"admin",Array('page'=>$page, 'msg'=>base64_encode("Error occured while deleting the page!")));
		}
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 3-Mar-2011
	 * @Description: Change status of CMS Page
	 */
	public function statusAction()
	{	
		$id		=	$this->_getParam('id');
		$model	=	new Application_Model_Page();
		$val	=	$model->find($id);
		
		if($val->getStatus()==1)
		{
			$val->setStatus(0);
			
		}
		else
		{
			$val->setStatus(1);
		}
		$val->save();
		return $this->_helper->redirector('index','page',"admin");	
	}//end function
}

