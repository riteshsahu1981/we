<?php
class GalleryController extends Base_Controller_Action
{
    public function indexAction()
    {
        
    }
    public function albumsAction()
    {
        /*--search---*/
        $search = trim($this->_getParam('search'));
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
        if($search<>"" && $search<>"Search...")
        {
            $where="(title like '%{$search}%' or description like '%{$search}%' or first_name like '%{$search}%' or last_name like '%{$search}%' or middle_name like '%{$search}%')";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);

        $model=new Application_Model_Album();
        $table=$model->getMapper()->getDbTable();
        $select = $table->select()->setIntegrityCheck(false)->from(array("a"=>'album'))->join(array("u"=>'user'),'u.id=a.user_id',array('first_name','last_name','middle_name',"user_id"=>'id','employee_code'))->order('addedon desc')->order('updatedon desc')->order('title ASC')->where($where);
        //echo $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        
        $this->view->paginator=$paginator;
    }
    
    public function addAlbumAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Album();
        
        if ($request->isPost())
        {
            $options=$request->getPost();
            $form->getElement('title')->addValidators(array(
            array('Db_NoRecordExists', false, array(
            'table' => 'album',
            'field' => 'title',
            'messages'=>'Album with the same title is already exists, Please choose another title.'
                    ))
            ));
            if ($form->isValid($options))
            { 
                $usersNs = new Zend_Session_Namespace("members");
                $options['userId']=$usersNs->userId;
                $model=new Application_Model_Album($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    $model->uploadCoverImage($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'Album added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add album!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));
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
    public function editAlbumAction()
    {
        $id = $this->_getParam('id');
        $model1 = new Application_Model_Album();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
        }
        $options['title'] = $model->getTitle();
        $options['description'] = $model->getDescription();
        $options['coverImage'] = $model->getCoverImage();
        $options['status'] = $model->getStatus();
		
        $request = $this->getRequest();
        $form    = new Application_Form_Album();
        $form->populate($options);
        $options=$request->getPost();
        if ($request->isPost()) 
        { 
             /*---- title validation ----*/
            if($options['title']!=$model->getTitle())
            {
               
                $form->getElement('title')->addValidators(array(
                array('Db_NoRecordExists', false, array(
                'table' => 'album',
                'field' => 'title',
                'messages'=>'Album with the same title is already exists, Please choose another title.'
                        ))
                ));
            }
            /*-------------------------*/
			
            if ($form->isValid($options))
            {
                $model->setOptions($options);
                $model->save();
                /*---------  Upload image START -------------------------*/
                $model->uploadCoverImage($id,$options);
                /*---------  Upload image END -------------------------*/
                $this->_flashMessenger->addMessage(array('success'=>'Album has been updated successfully!'));
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/edit-album/id/'.$id));  
            }
            else
            {
                $this->_flashMessenger->addMessage(array('error'=>'Unable to save the data. Please provide valid inputs and try again.'));
                $form->reset();
                $form->populate($options);
            } 		
        }
        $this->view->cover_image_thumb=$model->getCoverImageThumb();
        $this->view->form		=	$form;
    }
    public function changeAlbumStatusAction()
    {
        $id = $this->_getParam('id');
        $this->view->user_id = $id;
        $model1 = new Application_Model_Album();
        $model = $model1->find($id);
        if(false===$model)
        {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Please try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
        }
        if($model->getStatus()=="publish")
            $model->setStatus ("unpublish");
        else
            $model->setStatus ("publish");
        
       if($model->save())
       {
            $this->_flashMessenger->addMessage(array('success'=>'Status changed for '.$model->getTitle().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
       }
       else
       {
           $this->_flashMessenger->addMessage(array('error'=>'Failed to change the status for '.$model->getTitle().' [ ID : '.$model->getId().', Status : '.$model->getStatus().']'));
           $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
       } 
    }
    public function addPicturesAction()
    {
        $this->view->album_id=$this->_getParam('id');
    }
    
   
    public function deleteAlbumAction()
    {
        $album_id=$this->_getParam('id');
        $album=new Application_Model_Album();

         $album=$album->find($album_id);
         if(false===$album)
         {
            $this->_flashMessenger->addMessage(array('error'=>'Invalid request! Try again.'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));  
         }
        
         
         if($album->delete("id='{$album_id}'"))
         {
            
            $dir=PUBLIC_PATH."/media/picture/album/{$album_id}";
            $album->rrmdir($dir);
            
            unlink(PUBLIC_PATH."/media/picture/album/{$album->getCoverImage()}");
            unlink(PUBLIC_PATH."/media/picture/album/thumb_{$album->getCoverImage()}");
            
            $this->_flashMessenger->addMessage(array('success'=>'Album deleted'));
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums'));
         }
         else
         {
             $this->_flashMessenger->addMessage(array('error'=>'Error while deleting the album!'));
             $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gallery/albums')); 
         }
      
         
         
        
    }
    
    
    public function deletePictureAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $id=$this->_getParam('id');
        $picture= new Application_Model_Pictures();
        $picture=$picture->find($id);
        if(false===$picture)
        {    
            $result=array("success"=>0);
           
        }
        else
        {
            if($picture->delete("id='{$id}'"))
            {
                $result=array("success"=>1);
                unlink(PUBLIC_PATH."/media/picture/album/{$picture->getAlbumId()}/{$picture->getImage()}");
                unlink(PUBLIC_PATH."/media/picture/album/{$picture->getAlbumId()}/small_{$picture->getImage()}");
                unlink(PUBLIC_PATH."/media/picture/album/{$picture->getAlbumId()}/thumb_{$picture->getImage()}");
            }
            else
            {
                $result=array("success"=>0);
            }
                
            
        }
        echo Zend_Json::encode($result);
    }
    
    
}

