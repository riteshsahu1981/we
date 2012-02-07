<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	public function _initCache()
	{
//		$frontendOptions = array(
//				'lifeTime' => 720,
//				'debug_header' => false,
//				'regexps' => array(
//					'^/' => array(
//						'cache' => true,
//						'cache_with_cookie_variables' => true,
//					)
//				)
//			);
//		 
//			$backendOptions = array(
//				'cache_dir' => PUBLIC_PATH.'/cache/'
//			);
//		 
//			$cache = Zend_Cache::factory(
//				'Page',
//				'File',
//				$frontendOptions,
//				$backendOptions
//			);
//		 
//			$cache->start();
	}

    protected function _initDoctype()
    {

        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
    
    protected function _initAutoload()
    {
    	/*$autoloader = new Zend_Application_Module_Autoloader(
	 	array(
                'namespace' => 'Admin',
                'basePath' => APPLICATION_PATH . '/modules/admin'
       	 )
		);*/
		
    	//---rit
    }
    
    
    

    protected function _initRegistry()
	{
	    $this->bootstrap('db');
	    $db = $this->getResource('db');
	    $db->setFetchMode(Zend_Db::FETCH_OBJ);
	    Zend_Registry::set('db', $db);
	    
	    /*Zend_Registry::set('luceneMovie', PUBLIC_PATH.'/tmp/luceneMovie');
	    Zend_Registry::set('luceneGame', PUBLIC_PATH.'/tmp/luceneGame');*/
	    	
	    $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
	    Zend_Registry::set('siteurl', $config->gd->siteurl);
	    Zend_Registry::set('domain', $config->gd->domain);
	    Zend_Registry::set('cdn_uri', $config->gd->cdn_uri);
	}
	
	protected function _initViewHelpers(){
		$this->bootstrap('layout');
		$layout=$this->getResource('layout');
		$view=$layout->getView();
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		$view->addHelperPath('Base/View/Helper/', 'Base_View_Helper');
		
			
		
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		ZendX_JQuery::enableView($view);

		

		/*------ default blocks in the region right ---*/
   		/*$blockM=new Base_View_Block();
   		$path="/layouts/scripts/page/blocks/journal";
   		$blocks=array("name"=>"search-destination", "order"=>"10", "path"=>$path);
   		$blockM->addBlock($blocks, 'journal');
   		$blocks=array("name"=>"right-banner", "order"=>"9", "path"=>$path);
   		$blockM->addBlock($blocks, 'journal');
   		$blocks=array("name"=>"recent-blog", "order"=>"8", "path"=>$path);
   		$blockM->addBlock($blocks, 'journal');

   		$blocks=array("name"=>"journal-categories", "order"=>"7", "path"=>$path);
   		$blockM->addBlock($blocks, 'journal');
   		$blocks=array("name"=>"tag-cloud", "order"=>"6", "path"=>$path);
   		$blockM->addBlock($blocks, 'journal');*/
		/*------ default blocks in the region right ---*/
   		
	}
	
	protected function _initNavigation()
	{
		$this->bootstrap('layout');
		$layout=$this->getResource("layout");
		$view=$layout->getView();
		
		$config=new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation/navigation.xml','nav');
		$navigation= new Zend_Navigation($config);
		$view->navigation($navigation);
			
	}
	
	protected function _initPlugin()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Base_Plugin_Action());

		
	}
	
}

