<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */


class Admin_LoginController extends Base_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function preDispatch()
    { 
    	 parent::preDispatch();
    	$this->_helper->layout->setLayout('admin-login');
        if (Zend_Auth::getInstance()->hasIdentity()) 
        {
            if ('logout' != $this->getRequest()->getActionName()) 
            {
            	$usersNs = new Zend_Session_Namespace("members");
				if($usersNs->userType=='administrator')
				{
					$this->_helper->redirector('index', 'index', 'admin');
				} 
				else
				{
					$this->_helper->redirector('logout', 'login', 'admin');
				}
            }
        } 
        else 
        {
            if ('logout' == $this->getRequest()->getActionName()) 
            {
                $this->_helper->redirector('index', 'login', 'admin');
            }
        }
    }
    
	public function indexAction()
	{	
		$this->_helper->redirector('login','login', 'admin');	
    }
    
	public function logoutAction()
    {
    	$Auth=new Base_Auth_Auth();
		$Auth->doLogout();
        /*
		 * @Commented By: Mahipal Adhikari
		 * @Commented On : 25-Nov-2010
		 * @Description: Do not delete cookies while loggig out as per new requirement logged in mantis(bug id: 250)
		 */
		//$Auth->forgotMe('rememberMe');
        $this->_helper->redirector('index','login', 'admin'); // back to login page
    }
    
    
    
    public function loginAction()
    {
    	$request = $this->getRequest();
    	$form=new Admin_Form_Login();
    	$this->view->form=$form;
    	if ($request->isPost())
    	{
	    	if ($form->isValid($request->getPost())) 
	        {
	        	$Auth = new Base_Auth_Auth();
	        	$params=$request->getParams();
	   			$Auth ->doLogout();
	        	
	        	$loginStatusEmail=true;
	        	$loginStatusUsername=true;
	        	
	   			$loginStatusEmail=$Auth->doLogin($params, 'email');
	   			if($loginStatusEmail==false){
	   				$loginStatusUsername=$Auth->doLogin($params, 'username');
	   			}
	   			
	   			if ($loginStatusEmail==false && $loginStatusUsername==false)
				{
		            // Invalid credentials
        	    	$form->setDescription('Invalid credentials provided');
				}
				else
				{
                    if($params['rememberMe']==1)
					{
						$Auth->remeberMe(true, $params);
					}
					else
					{
						$Auth->forgotMe('rememberMe'); //delete existing cookies as per new requirement
					}
					// Valid credentials
			        // We're authenticated! Redirect to the home page
					$this->_helper->redirector('dashboard', 'index','admin');
				}
	        }
    	}
    	
    }
    
	public function warningAction()
    {
            $this->view->headTitle("Unauthorized Access");
    }

}
