<?php
//ritesh
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initCache()
    {

    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
 

    protected function _initRegistry()
    {
        $this->bootstrap('db');
        $db = $this->getResource('db');
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        Zend_Registry::set('db', $db);


        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('siteurl', $config->gd->siteurl);
        Zend_Registry::set('domain', $config->gd->domain);
        Zend_Registry::set('cdn_uri', $config->gd->cdn_uri);
        
        
        
        
    }
	
    protected function _initViewHelpers()
    {
        
        $this->bootstrap('layout');
        $layout=$this->getResource('layout');
        $view=$layout->getView();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->addHelperPath('Base/View/Helper/', 'Base_View_Helper');



        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        ZendX_JQuery::enableView($view);
   		
    }
    protected function _initACL()
    {
        $acl=new Base_Acl();
        Zend_Registry::set('acl', $acl);
    }
    
    protected function _initViewVars()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->roleName='guest';
        $usersNs = new Zend_Session_Namespace("members");
        if($usersNs->userType<>'')
        {
            $view->roleName=$usersNs->userType;
            $view->userFullName=$usersNs->userFullName;
            $view->userId=$usersNs->userId;
            $view->userEmail=$usersNs->userEmail;
            $view->userFirstName=$usersNs->userFirstName;
            $view->userUsername=$usersNs->userUsername;
        }
    }
    
    protected function _initNavigation()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        
        $config=new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation/navigation.xml','nav');
        $navigation= new Zend_Navigation($config);
        //$navigation=$navigation->findBy("display","Yes");
        $acl= Zend_Registry::get('acl');
        $view->navigation($navigation)->setAcl($acl)->setRole($view->roleName);
    }

    
    protected function _initPlugin()
    {
            $front = Zend_Controller_Front::getInstance();
            $front->registerPlugin(new Base_Plugin_Action());


    }
    
    protected function _initJquery()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();
         $view->jQuery()->setLocalPath($view->baseUrl()."/js/jqueryui/js/jquery-1.6.2.min.js")
                                ->setUiLocalPath($view->baseUrl()."/js/jqueryui/js/jquery-ui-1.8.16.custom.min.js")
                                ->addStylesheet($view->baseUrl()."/js/jqueryui/themes/le-frog/jquery.ui.all.css");
    }
    protected function _initJavascript()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->headScript()->appendFile('/js/simpla.js');   
        $view->headScript()->appendFile('/ckeditor/ckeditor.js');    
    }
    
    protected function _initStylesheet()
    {
        $this->bootstrap('layout');
        $layout=$this->getResource("layout");
        $view=$layout->getView();
        $view->headLink()->appendStylesheet('/style/reset.css');    
        $view->headLink()->appendStylesheet('/style/style.css'); 
        $view->headLink()->appendStylesheet('/style/invalid.css');
    }
}