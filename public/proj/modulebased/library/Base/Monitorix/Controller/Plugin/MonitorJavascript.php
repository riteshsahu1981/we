<?php

/**
 * cloud solutions monitorix 
 * 
 * This source file is part of the cloud solutions monitorix package
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 * @license    New BSD License {@link /docs/LICENSE}
 * @copyright  Copyright (c) 2011, cloud solutions O�
 * @version    $Id: MonitorJavascript.php 54 2011-09-20 00:19:05Z markushausammann@gmail.com $
 */

/**
 * Zend Front Controller Plugin that intercepts XmlHttpRequests for loggin javascript errors
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 */
class Base_Monitorix_Controller_Plugin_MonitorJavascript extends Zend_Controller_Plugin_Abstract
{
	/**
	 * 
	 * Zend Framework provided front controller hook
	 * Here used to intercept XmlHttpRequests sent off for javascript error logging
	 */
	public function routeStartup(Zend_Controller_Request_Abstract $request)
	{
		if ($request->__get('monitori') == 'x' && $request->isXmlHttpRequest())
		{
			$monitor = Zend_Registry::get('monitor');
			$message = 	"A javascript error was detected.\n" .
	   		           	"================================\n" .
						"Message:  " . $_POST['message'] . ";\n" .
        			   	"Uri:      " . $_POST['errorUrl'] . ";\n" .
	    			   	"Line:     " . $_POST['errorLine'] . ";\n" . ";";
	
		    $monitor->writeLog($message, 4, 'javascript-error');
		}
	}
}