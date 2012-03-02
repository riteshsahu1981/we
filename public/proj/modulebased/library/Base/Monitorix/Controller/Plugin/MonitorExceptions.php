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
 * @version    $Id: MonitorExceptions.php 50 2011-09-16 14:54:07Z markushausammann@gmail.com $
 */

/**
 * Zend Front Controller Plugin that intercepts Exceptions for logging
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 */
class Base_Monitorix_Controller_Plugin_MonitorExceptions extends Zend_Controller_Plugin_Abstract
{
	/**
	 * 
	 * Zend Framework provided front controller hook
	 * Here used to intercept uncaught Exceptions at the end of the dispatch process
	 */
	public function dispatchLoopShutdown()
	{
	    $response = $this->getResponse();
		
	    $monitor = Zend_Registry::get('monitor');
	
	    if ($response->isException())
	    {
	        $monitor->writeLog($response);
	    }
	}
}