<?php
/**
 * Base_Plugin_Action
 * 
 * @author : ritesh
 * @email : riteshsahu1981@gmail.com
 * @version 1.0  
 */

class Base_Plugin_Action extends Zend_Controller_Plugin_Abstract{	
    
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
            
                    
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        if($config->site_maintenance=="1")
        {
            $appNs = new Zend_Session_Namespace("app");
            if($appNs->userName=="" && $appNs->password=="")
            {
                    $request->setRequestUri('/index/app-login/');
            }
        }
        
        if($config->seofriendlyurl=="1")
        {
            $seoUrlM = new Application_Model_SeoUrl();
            $stringURI = $request->getRequestUri();
            $stringSearchArr = explode("?",$stringURI);

            $stringSeoUrl = 	$stringSearchArr[0];
            $seoUrl	=	$seoUrlM->fetchRow("seo_url='{$stringSeoUrl}'");
            if(false!==$seoUrl)
            {
                if(isset($stringSearchArr[1]))
                {
                        $request->setRequestUri($seoUrl->getActualUrl()."?".$stringSearchArr[1]);
                }
                else
                {
                        $request->setRequestUri($seoUrl->getActualUrl());
                }	
            }      
        }
        
        
    } 

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
    }

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		/*$frontendOptions = array(
				'lifeTime' => 30,
				'debug_header' => true,
				'regexps' => array(
					'^/' => array(
						'cache' => true,
						'cache_with_cookie_variables' => true,
					)
				)
			);
		 
			$backendOptions = array(
				'cache_dir' => PUBLIC_PATH.'/cache/'
			);
		 
			$cache = Zend_Cache::factory(
				'Page',
				'File',
				$frontendOptions,
				$backendOptions
			);
		 
			$cache->start();
*/
		/*
		$cookie=new Base_Http_Cookie();
		if(!$cookie->isExpired('rememberMe'))
		{
            if(Zend_Auth::getInstance()->hasIdentity()!=true )
            {
				//print_r($cookie->getCookie('rememberMe'));							  
				$params=unserialize(base64_decode($cookie->getCookie('rememberMe')));
				$Auth = new Base_Auth_Auth();
				$Auth ->doLogout();
				$loginStatusEmail=true;
				$loginStatusUsername=true;
				
				$loginStatusEmail=$Auth->doLogin($params, 'email');
				if($loginStatusEmail==false){
					$loginStatusUsername=$Auth->doLogin($params, 'username');
				}
            }
		}
		*/
		if(Zend_Auth::getInstance()->hasIdentity()!=true )
		{
			//$user=new Application_Model_User();
			//$result=$user->doFacebookLogin();
		}//end of has identity
    } 

    public function postDispatch(Zend_Controller_Request_Abstract $request)
	{
    } 

    public function dispatchLoopShutdown()
	{

    }
    
} 
