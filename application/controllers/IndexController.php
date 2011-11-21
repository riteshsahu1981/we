<?php
class IndexController extends Base_Controller_Action
{
        
        public function preDispatch()
        { 
            parent::preDispatch();
         
            if (Zend_Auth::getInstance()->hasIdentity()) 
            {
                if ('logout' != $this->getRequest()->getActionName()) 
                {
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/dashboard'));
                }
            } 
            else 
            {
                if ('logout' == $this->getRequest()->getActionName()) 
                {
                    $this->_flashMessenger->addMessage(array('success'=>'You have successfully logged out!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));    
                }
            }
        }
        
	public function indexAction()
	{
            $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));
	}
        
        public function loginAction()
	{
            $this->view->pageHeading="Login";
            $request = $this->getRequest();
            
            $this->view->form=$form=new Application_Form_Login();
            $elements=$form->getElements();
            $form->clearDecorators();

            foreach($elements as $element)
            {
                $element->removeDecorator('label');
                $element->removeDecorator('Errors');
            }   
            if ($request->isPost())
            {
                if($form->isValid($request->getPost()))
                {
                    $params=$request->getParams();
                    $Auth = new Base_Auth_Auth();
                    $Auth ->doLogout();
                    $loginStatusEmail=true;
                    $loginStatusUsername=true;

                    $loginStatusEmail=$Auth->doLogin($params, 'email');
                    if($loginStatusEmail==false)
                        $loginStatusUsername=$Auth->doLogin($params, 'username');



                    if ($loginStatusEmail==false && $loginStatusUsername==false) 
                    {
                        $this->_flashMessenger->addMessage(array('error'=>'Invalid credentials! Please try again.'));
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));
                    }
                    else
                    {				
                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/'));
                    }
                }
                else
                {
                    $this->view->email_msg=array_pop($form->getMessages('email'));
                    $this->view->password_msg=array_pop($form->getMessages('password'));
                }
            }
            
            
	}
        
    public function logoutAction()
    {
    	$Auth=new Base_Auth_Auth();
        $Auth->doLogout();
        //$Auth->forgotMe('rememberMe');
        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));
      
    }
    
    

}//end of class
