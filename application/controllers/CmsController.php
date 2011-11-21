<?php
class CmsController extends Base_Controller_Action
{
        public function pagesAction()
        {
            /*--search---*/
            $search = trim($this->_getParam('search'));
            $where="1=1";
            $this->view->linkArray=array();
            $this->view->search="Search...";
            if($search<>"" && $search<>"Search...")
            {
                $where="title like '%{$search}%' or content like '%{$search}%' or meta_title like '%{$search}%' or meta_description like '%{$search}%' or meta_keyword like '%{$search}%' or  identifire like '%{$search}%' ";
                $this->view->linkArray=array('search'=>$search);
                $this->view->search=$search;
            }

            $this->view->page_size=$page_size= $this->_getParam('page_size',25);
            $page =	$this->_getParam('page',1);

            $model=new Application_Model_Page();
            $table=$model->getMapper()->getDbTable();
            $select = $table->select()->order('addedon DESC')->where($where);
            //echo $sql = $select->__toString(); 
            $paginator =  Base_Paginator::factory($select);
            $paginator->setItemCountPerPage($page_size);
            $paginator->setCurrentPageNumber($page);

            $this->view->paginator=$paginator;
        }
        public function addPageAction()
        {
            $request = $this->getRequest();
            $form    = new Application_Form_Page();

            if ($request->isPost())
            {
                $options=$request->getPost();
                
                if ($form->isValid($options))
                { 
                    $params	=	$form->getValues();
                    $usersNs = new Zend_Session_Namespace("members");
                    $params['userId']=$usersNs->userId;
                    
                    //set seo url
                    $sanitize=  new Base_Sanitize();
                    if(trim($params['identifire'])=="")
                    {
                            $params['identifire'] = $params['title'];
                    }
                    if(trim($params['identifire'])!="")
                    {
                        $params['identifire']	=	$sanitize->clearInputs($params['identifire']);
                        $params['identifire']	=	$sanitize->sanitize($params['identifire']);

                        $seo_url_title=$params['identifire'];
                        $actual_url="/employee/page/identifire/{$seo_url_title}";
                        $seo_url="/{$seo_url_title}";

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
                    $id=$model->save();
                    if($id)  
                    {    
                        
                        $this->_flashMessenger->addMessage(array('success'=>'Page added successfully!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/add-page'));  
                    }
                    else
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Failed to add page!'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/add-page'));
                    }
                   $form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
               }
            }
            $this->view->form =  $form;
        }
        
        public function editPageAction()
        {
            $id = $this->_getParam('id');
            $this->view->user_id = $id;
            $model1 = new Application_Model_Page();
            $model = $model1->find($id);
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/hr/employees'));  
            }
            $options = array(
                'title'   => $model->getTitle(),
                'identifire'   => $model->getIdentifire(),
                'content'   => $model->getContent(),
                'metaTitle'   => $model->getMetaTitle(),
                'metaDescription'   => $model->getMetaDescription(),
                'metaKeyword'   => $model->getMetaKeyword(),
                'status'   => $model->getStatus(),		
            );

            $request = $this->getRequest();
            $form    = new Application_Form_Page();
          
            $form->populate($options);
            $options=$request->getPost();
            if ($request->isPost()) 
            { 
                if ($form->isValid($options))
                {
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


                        $actual_url		=	"/employee/page/identifire/{$model->getIdentifire()}";
                        $new_actual_url         =	"/employee/page/identifire/{$seo_url_title}";
                        $seo_url		=	"/{$seo_url_title}";

                        $seoUrlM	=	new Application_Model_SeoUrl();
                        $soeUrl		=	$seoUrlM->fetchRow("actual_url='{$actual_url}'");
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
                                
                    $model->setOptions($options);
                    $model->save();
                    
                    $this->_flashMessenger->addMessage(array('success'=>'Page has been updated successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/edit-page/id/'.$id));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                    $form->reset();
                    $form->populate($options);
                } 		
            }
            $this->view->form		=	$form;
        }
        
        public function changePageStatusAction()
        {
            $id = $this->_getParam('id');
            $model1 = new Application_Model_Page();
            $model = $model1->find($id);
            if(false===$model)
            {
                $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/pages'));  
            }
            if($model->getStatus()=="1")
                $model->setStatus ("0");
            else
                $model->setStatus ("1");

           if($model->save())
           {
               if($model->getStatus()=="1")
                   $status="Published";
               else
                   $status="Unpublished";
                $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getTitle().' [ ID : '.$model->getId().', Status : '.$status.']'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('cms/pages'));  
           }
           else
           {
               $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getTitle().' [ ID : '.$model->getId().', Status : '.$status.']'));
               $this->_helper->_redirector->gotoUrl($this->view->seoUrl('cms/pages'));  
           }

        }
	
    public function noticesAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search!="Search...")
        {
            $where="title like '%{$search}%' or content like '%{$search}%'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Notice();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->order('addedon DESC')->where($where);
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
	
    public function addNoticeAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Notice();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            
            if ($form->isValid($options))
            { 
                
                $model=new Application_Model_Notice($options);
                $id=$model->save();
                if($id)  
                {    
                    $this->_flashMessenger->addMessage(array('success'=>'Notice added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/add-notice'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add notice!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/add-notice'));
                }
               $form->reset();
            }
            else
            {
                $form->reset();
                $form->populate($options);
           }
        }
        $this->view->form =  $form;
    }//end of add-notice function
    
    public function editNoticeAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Notice();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/notices'));  
        }
        $options['title'] = $model->getTitle();
        $options['content'] = $model->getContent();
        $request = $this->getRequest();
        $form    = new Application_Form_Notice();
       
		
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
               
                $this->_flashMessenger->addMessage(array('success'=>'Notice has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/edit-notice/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
       
        $this->view->form		=	$form;
    }//end of edit-notice function
	
    public function deleteNoticeAction()
    {
        $id = $this->_getParam('id');
        $model1 = new Application_Model_Notice();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/cms/notices'));  
        }
       if($model->delete("id='{$id}'"))
       {
            $this->_flashMessenger->addMessage(array('success'=>"Notice ID#{$id} has been deleted successfully!"));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('cms/notices'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>"Failed to delete the notice ID#{$id}"));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('cms/notices'));  
       }
    }
}

