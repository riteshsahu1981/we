<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */


class Admin_UserlevelController extends Base_Controller_Action {
	/**
	 * The default action - show the home page
	 */

	
	public function viewAction()
	{
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		$userModel=new Application_Model_UserLevel();
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($userModel,$page,$page_size);
		$this->view->total_users=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		
		$request=$this->getRequest();
		//$request->getControllerName();
	}
	

	
	public function deleteuserAction()
	{
		
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$model=new Default_Model_UserLevel();
		$table=$model->getTableStructure();
		$model->delete("".$table['id']."='$id'");
		$this->_helper->redirector('view','userlevel','admin',Array('msg'=>base64_encode("User level with level id $id deleted successfully!"),'page'=>$page));
		
	}
 	public function adduserlevelAction()
    {
    	$request = $this->getRequest();
        $form    = new Admin_Form_UserLevel();
        
         
        if ($this->getRequest()->isPost()) 
        { 
            $options=$request->getPost();
            
            if ($form->isValid($options)) 
            {
                $model = new Application_Model_UserLevel($options);
                $model->setStatus("active");          
                $model->save();
                return $this->_helper->redirector('adduserlevel','userlevel',"admin",Array('msg'=>base64_encode("User level Added successfully!")));
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
		
		$userModel=new Application_Model_UserLevel();
		$editModel=$userModel->find($id);
		
		$editModel->setStatus($status);
		
		
		$editModel->save();	
		$this->_helper->redirector('view','userlevel','admin',Array('msg'=>base64_encode("Status changed to $status!"),'page'=>$page));
	}
	
	public function edituserlevelAction()
	{
		$id=$this->_getParam('id');
		$page=$this->_getParam('page');
		$model=new Application_Model_UserLevel();
		$row=$model->find($id);
		
		$options['identifire']=$row->getIdentifire();
      	$options['label']=$row->getLabel();
      	
      	
      	
		$request = $this->getRequest();
        $form    = new Admin_Form_UserLevel();
        $form->populate($options);

        if ($this->getRequest()->isPost()) 
        {
            $options=$request->getPost();
            if ($form->isValid($options)) 
            {
                $row->setIdentifire($options['identifire']);
				$row->setLabel($options['label']);
				$row->save();
                return $this->_helper->redirector('view','userlevel',"admin",Array('msg'=>base64_encode("User level [Id:$id] is updated successfully!")));                
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
}
?>

