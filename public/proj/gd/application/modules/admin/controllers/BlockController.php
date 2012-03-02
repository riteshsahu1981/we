<?php
class Admin_BlockController extends Base_Controller_Action
{
	public function indexAction()
	{
		$model		=	new Block_Model_Block();
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
		
		$pageObj	=	new Base_Paginator();
		$page		=	$this->_getParam('page',1);
		
		$paginator	=	$pageObj->fetchPageData($model,$page,$page_size);
		
		$this->view->total		=	$pageObj->getTotalCount();
		$this->view->paginator	=	$paginator;
		$this->view->msg		=	base64_decode($this->_getParam('msg',''));
		
	}
	public function addAction()
    {
    	$request = $this->getRequest();
        $form    = new Block_Form_Block();
        if ($this->getRequest()->isPost()) 
        { 
            $options=$request->getPost();
            if ($form->isValid($options)) 
            { 
            	$arrPaths=explode("\n",$options['visibilityPaths']);
            	$options['visibilityPaths']=serialize($arrPaths);
            	$model = new Block_Model_Block($options);
            	$id=$model->save();
                return $this->_helper->redirector('add','block',"admin",Array('msg'=>base64_encode("Block Added successfully!")));
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
		
		$model=new Block_Model_Block();
		$model=$model->find($id);
		
		$model->setStatus($status);
		
		
		$model->save();
		$msg="You have successfully unpublished the banner!";
		if($status==1)
		$msg="You have successfully publish the banner!";	
		$this->_helper->redirector('index','block','admin',Array('msg'=>base64_encode($msg),'page'=>$page));
	}
	
	public function editAction()
	{
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$model=new Block_Model_Block();
		$model=$model->find($id);
		
		$options['title']=$model->getTitle();
      	$options['alias']=$model->getAlias();
      	$options['body']=$model->getBody();
      	$options['status']=$model->getStatus();
      	$options['weight']=$model->getWeight();
      	$options['blockRegionId']=$model->getBlockRegionId();
      	
      	if($model->getVisibilityPaths()<>""){
      		$arrPaths=unserialize($model->getVisibilityPaths());
      		$options['visibilityPaths']=implode("\n", $arrPaths);
      	}
		$request = $this->getRequest();
        $form    = new Block_Form_Block();
        $form->populate($options);
        if ($this->getRequest()->isPost()) 
        {
            $options=$request->getPost();
            if ($form->isValid($options)) 
            {
            	$arrPaths=explode("\n",$options['visibilityPaths']);
            	$options['visibilityPaths']=serialize($arrPaths);
                $model->setOptions($options);
                $model->save();
                return $this->_helper->redirector('index','block',"admin",Array('msg'=>base64_encode("Block [Id:$id] is updated successfully!")));                
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
