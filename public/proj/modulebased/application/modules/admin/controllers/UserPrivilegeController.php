<?php
class Admin_UserPrivilegeController extends Base_Controller_Action
{
  public function indexAction()
    { 
        /*--search---*/
    
        $search = trim($this->_getParam('search'));
      
        $where="1=1";
        $this->view->linkArray=array();
        $this->view->search="Search...";
       
        /*if($search<>"" && $search<>"Search...")
        {
            $where="(first_name like '%{$search}%' or last_name like '%{$search}%' or email like '%{$search}%' or d.title like '%{$search}%' or  username like '%{$search}%' ) and status!='deleted'";
            $this->view->linkArray=array('search'=>$search);
            $this->view->search=$search;
        }*/
       
        
        $this->view->page_size=$page_size= $this->_getParam('page_size',25);
        $page =	$this->_getParam('page',1);
        $model=new Application_Model_UserPrivilege();
        $table=$model->getMapper()->getDbTable();
       // $select = $table->select()->setIntegrityCheck(false)->from('user_privilege',array('user_id', 'screen_id', 'action_id','menu_id'))->order('user_id ASC')->where($where);
        $select = $table->select()->setIntegrityCheck(false)->from(array("up"=>'user_privilege'))
                ->join(array("u"=>'user'),'up.user_id=u.id',array('first_name'=>'first_name','last_nae'=>'last_name'))
                 ->order('user_id ASC')->where($where);
        
        $sql = $select->__toString(); 
        $paginator =  Base_Paginator::factory($select);
       // echo '<pre>'; print_r($paginator);
        $paginator->setItemCountPerPage($page_size);
        $paginator->setCurrentPageNumber($page);
        $this->view->totalItems= $paginator->getTotalItemCount();
        $this->view->paginator=$paginator;
       
    }
        
    public function addUserPrivilegeAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_UserPrivilege();
        
        if ($request->isPost())
        {
            $options=$request->getPost();

            if ($form->isValid($options))
            { 
                
                
                //$options['status']='active';
                             
                $model=new Application_Model_User($options);
                $id=$model->save();
                if($id)  
                {    
                    /*---------  Upload image START -------------------------*/
                    $model->uploadProfilePicture($id,$options);
                    /*---------  Upload image END -------------------------*/
                    $this->_flashMessenger->addMessage(array('success'=>'User added successfully!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/user/add-new-user'));  
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('error'=>'Failed to add user!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/admin/user/add-new-user'));
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
    }//end of add-new-employee function
    
    
        
        
        
}
