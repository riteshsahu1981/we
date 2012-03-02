<?php

class ErrorController extends Base_Controller_Action
{
 	public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function errorAction()
    {
        //$this->_helper->layout->setLayout('home-layout');
        $errors = $this->_getParam('error_handler');
        $flag=true;
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            	
         //var_dump($this->_getParam('controller'));
        
                    $userM=new Application_Model_User();
                    $user=$userM->fetchRow("username='{$this->_getParam('controller')}'");

                    if($user!==false)
                    {
                        $flag=false;
                        //Forward to the controller
                       $this->_forward('index','profile','default',
                                                array(
                                                     'id' => $user->getId()
                                                ));
  
                    } 
                    
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

               
                    $this->getResponse()->setHttpResponseCode(404);
                    $this->view->message = 'Page not found';
                
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        //var_dump($this->getInvokeArg('displayExceptions'));
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;


        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        $this->view->error_flag=$config->error_flag;

        //Mail

        $options['message']=$this->view->message;
        if ($this->getInvokeArg('displayExceptions') == true) {
            $options['exception']=$this->view->exception->getMessage();
            $options['traceString']=$this->view->exception->getTraceAsString();
        }
        $options['params']=$this->view->request->getParams();
        $options['requesturi']=$this->view->request->getRequestUri();
        $options['siteurl']=Zend_Registry::get('siteurl');
        $mail=new Base_Mail();
        if($flag==true)
        $mail->sendErrorMail($options);
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}

