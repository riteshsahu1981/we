<?php
/**
 * Base_Controller_Action
 * 
 * @author : ritesh
 * @version  
 */
  
class Base_Controller_Action extends Zend_Controller_Action {	
	
	public function init()
        {
            $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $this->initView();
        }
	
	public function postDispatch()
        {
            parent::postDispatch();
           // if(APPLICATION_ENV=="development")
             //   $this->view->headTitle(" Layout --> ".$this->view->layout()->getLayout()." <-- Layout ");
	}

        public function preDispatch()
        {
            parent::preDispatch();
            $request=$this->getRequest();
            $this->view->module=$request->getModuleName();
            $this->view->actionName=$request->getActionName();
            $this->view->controllerName=$request->getControllerName();
            $this->view->params=$params=$request->getParams();
            $this->view->metas($params);
            $this->checkACL();
            $this->setAppLayout();

        }
        
        public function checkACL()
        {
            $request=$this->getRequest();
            $module=$request->getModuleName();
            $action=$request->getActionName();
            $controller=$request->getControllerName();
            
            $roleName=$this->view->roleName;    		
            $acl=Zend_Registry::get('acl');
            if(!$acl->isAllowed($roleName,$module.":".$controller,$action))
            {
                if($roleName=='guest')
                {
                    $this->_flashMessenger->addMessage(array('attention'=>'Unauthorized access or your session has been expired!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/login'));
                }
                else
                {
                    $this->_flashMessenger->addMessage(array('attention'=>'Unauthorized access!'));
                    $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/employee/dashboard'));
                }
            }
        }
        
        public function setAppLayout()
        {
            $request=$this->getRequest();
            $module=$request->getModuleName();
            $action=$request->getActionName();
            $controller=$request->getControllerName();
            
            $layout="1column";
            if($module=="default" && $controller=="index")
                $layout="home"; 
            
            $this->_helper->layout->setLayout($layout);
        }
} 
