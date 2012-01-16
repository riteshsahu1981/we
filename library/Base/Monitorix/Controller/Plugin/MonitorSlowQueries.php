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
 * @version    $Id: MonitorExceptions.php 15 2011-03-26 23:04:39Z markushausammann@gmail.com $
 */

/**
 * Zend Front Controller Plugin that logs slow database queries
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 */
class Base_Monitorix_Controller_Plugin_MonitorSlowQueries extends Zend_Controller_Plugin_Abstract
{
	/**
	 * 
	 * Zend Framework provided front controller hook
	 * Here used to fetch all queries from the profiler and send the slow ones to monitorix
	 */
	public function dispatchLoopShutdown()
	{
	    $monitor = Zend_Registry::get('monitor');    
	    $profilers = Zend_Registry::get('profilers');
	    
	    foreach ($profilers as $profiler)
	    {
	    	if ($profiler->getTotalNumQueries())
	    	{
		    	$queryProfiles = $profiler->getQueryProfiles();
	
		    	foreach ($queryProfiles as $queryProfile)
		    	{
		    		if ($queryProfile->getElapsedSecs() > $monitor->getSlowQueryLimitSeconds())
		    		{
		    			$message = "A slow database query was detected.\n" .
		    			           "===================================\n" .
	        			   		   "Execution time: " . $queryProfile->getElapsedSecs() . ";\n" .
		    			           "Query:          " . $queryProfile->getQuery() . ";\n" .
		    			           "Parameters:     " . implode(', ', $queryProfile->getQueryParams()) . ";";
	
		    			$monitor->writeLog($message, 4, 'slow-query');
		    			
		    		}
		    	}
		    	$profiler->clear();
	    	}
	    } 
	}
}