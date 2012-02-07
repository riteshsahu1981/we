<?php
class Admin_BlockRegionController extends Base_Controller_Action {
	
	public function indexAction(){

		$model=new Block_Model_BlockRegion();
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
        $form    = new Block_Form_BlockRegion();
        if ($this->getRequest()->isPost()) 
        { 
            $options=$request->getPost();
            if ($form->isValid($options)) 
            { 
            	$model = new Block_Model_BlockRegion($options);
            	$id=$model->save();
                return $this->_helper->redirector('add','block-region',"admin",Array('msg'=>base64_encode("Block-Region Added successfully!")));
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
		$model=new Block_Model_BlockRegion();
		$model=$model->find($id);
		$options['title']=$model->getTitle();
      	$options['alias']=$model->getAlias();
      	
		$request = $this->getRequest();
        $form    = new Block_Form_BlockRegion();
        
        $form->populate($options);
        if ($this->getRequest()->isPost()) 
        {
            $options=$request->getPost();
            if ($form->isValid($options)) 
            {
                $model->setOptions($options);
                $model->save();
                return $this->_helper->redirector('index','block-region',"admin",Array('msg'=>base64_encode("Block-Region [Id:$id] is updated successfully!")));                
            }
            else
            {
            	$form->reset();
            	$form->populate($options);
            }
        }
        $this->view->msg=base64_decode($this->getRequest()->getParam("msg"));
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