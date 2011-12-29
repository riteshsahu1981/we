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
        if(Zend_Auth::getInstance()->hasIdentity()==true )
        {
            $username=Zend_Auth::getInstance()->getIdentity();
                
             $request_uri=$request->getRequestUri();
             $params="username={$username}";
             
             foreach($request->getParams() as $k=>$v)
             {
               if($request->getControllerName()!="error")
                $params.="&{$k}={$v}"; 
             }

             $usersNs = new Zend_Session_Namespace("members");
             $user_id=$usersNs->userId;
             $date=date("Y-m-d H:i:s");
             $remote_addr=$_SERVER['REMOTE_ADDR'];
             $table_name="log_".date("Y_m");
           $INSERT="INSERT INTO {$table_name} SET 
             request_uri='{$request_uri}',
             params='{$params}',
             remote_addr='{$remote_addr}',
             user_id='{$user_id}',
             addedon='{$date}';  
             ";

           $CREATE=" CREATE TABLE IF NOT EXISTS `{$table_name}` (
              `id` int(14) NOT NULL auto_increment,
              `request_uri` tinytext NOT NULL,
              `params` text NOT NULL,
              `remote_addr` varchar(255) NOT NULL,
              `user_id` int(11) NOT NULL,
              `addedon` datetime NOT NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
             
              $db=Zend_Registry::get('db');
              $db->query($CREATE.$INSERT);
              
        }
    } 

    public function postDispatch(Zend_Controller_Request_Abstract $request)
	{
    } 

    public function dispatchLoopShutdown()
	{

    }
    
} 
