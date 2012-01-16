<?php

/**
 * cloud solutions monitorix 
 * 
 * This source file is part of the cloud solutions monitorix package
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 * @license    New BSD License {@link /docs/LICENSE}
 * @copyright  Copyright (c) 2011, cloud solutions OÜ
 * @version    $Id: Monitor.php 51 2011-09-20 00:07:57Z markushausammann@gmail.com $
 */

/**
 * Generic class for extended logging and monitoring
 * Provides a fluid interface for most method calls
 * 
 * @category   Monitorix
 * @package    Base_Monitorix_Monitor
 */
class Base_Monitorix_Monitor extends Zend_Log
{
	/**
	 * 
	 * Maps the logtype db field
	 * @var string
	 */
    private  $logType;
    
    /**
     * 
     * The default logType, can be overwritten by user
     * @var string
     */
    protected $defaultLogType = 'simplelog';
    
    /**
     * 
     * The name of the project that is monitored
     * @var string
     */
    protected $projectName = 'undefined';
    
    /**
     * 
     * The environment that is monitored
     * @var string
     */
    protected $environment = 'undefined';
    
    /**
     * 
     * Defines what is considered a slow query in seconds
     * @var float
     */
    protected $slowQueryLimitSeconds = 1.0;
    
    /**
     * 
     * Is exception logging on or off
     * @var bool
     */
    public $loggingExceptions = FALSE;
    
    /**
     * 
     * Is javascript error logging on or off
     * @var bool
     */
    public $loggingJavascriptErrors = FALSE;
    
    /**
     * 
     * Is slow query logging on or off
     * @var bool
     */
    public $loggingSlowQueries = FALSE;
    
    /**
     * Cunstructor takes a Zend_Log_Writer_Db instance
     * 
     * @param Zend_Log_Writer_Db $writer
     * @param string $projectName
     * @param bool   $registerMonitor
     */
    public function __construct(Zend_Log_Writer_Abstract $writer, $projectName = NULL, $registerMonitor = TRUE)
    {
        parent::__construct($writer);
        
        if (defined('APPLICATION_ENV'))
        {
        	$this->environment = APPLICATION_ENV;
        }
        
        if(isset($projectName))
        {
            $this->projectName = (string) $projectName;
        }
        
        if (TRUE == $registerMonitor)
        {
            //Register the monitor for application wide usage
            Zend_Registry::set('monitor', $this);
        }
    }

    /**
     * Generic logger
     * 
     * @see also Zend_Log::log()
     * 
     * @param string|Zend_Controller_Response_Http $input
     * @param int $priority
     * @param string $logType
     */
    public function writeLog($input, $priority = 7, $logType = NULL)
    {
    	if (isset($logType))
    	{
    		$this->logType = $logType;
    	}
    	else
    	{
    		$this->logType = $this->defaultLogType;
    	}
    	
    	if ($input instanceof Zend_Controller_Response_Http)
        {
            $exceptions = $input->getException();
            
            foreach ($exceptions as $exception)
            {
                $message   = $exception->getMessage();
                $extraFields = $this->getExtraFieldsArray($exception);
                
                parent::log($message, 2, $extraFields);
            }
        }
        else
        {   
            $message = $input;
            
            parent::log($message, $priority, $this->getExtraFieldsArray());
        }
    }
    
     /**
     * Error Handler will convert error into log message, and then call the original error handler
     * This extended version will add the additional monitoring fields too
     *
     * @link http://www.php.net/manual/en/function.set-error-handler.php Custom error handler
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @return boolean
     */
    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $errorLevel = error_reporting();

        if ($errorLevel && $errno) 
        {
            if (isset($this->_errorHandlerMap[$errno])) 
            {
                $priority = $this->_errorHandlerMap[$errno];
            } 
            else 
            {
                $priority = Zend_Log::INFO;
            }
            
            parent::log($errstr, $priority, array(
                                                    'logType'     => 'php_error',
                                                    'projectName' => $this->projectName,
                                                    'environment' => $this->environment,
            										'errorNumber' => $errno, 
            										'file'        => $errfile, 
            										'line'        => $errline, 
            										'context'     => json_encode($errcontext),
            										'stacktrace'  => json_encode(debug_backtrace(false))
                                                 ));
        }
        
        if ($this->_origErrorHandler !== null) {
            return call_user_func($this->_origErrorHandler, $errno, $errstr, $errfile, $errline, $errcontext);
        }
        return false;
    }
    
    /**
     * 
     * Turns Exception logging on or off
     * 
     * @param bool $toggle
     * @return Base_Monitorix_Monitor
     */
    public function logExceptions($toggle = TRUE)
    {
        $this->loggingExceptions = $toggle;
        $this->registerControllerPlugin('Base_Monitorix_Controller_Plugin_MonitorExceptions', $toggle);
        return $this;
    }
    
    /**
     * 
     * Turns logging of slow queries on or off
     * Logs queries slower than $limiSeconds for the Zend_Db adapters passed in the array
     * Do NOT pass the Monitorix db adapter!
     * 
     * @param array $adapters
     * @param float $limitSeconds
     * @param bool $toggle
     * 
     * @return Base_Monitorix_Monitor
     */
    public function logSlowQueries(array $adapters, $limitSeconds = 1.0, $toggle = TRUE)
    {
    	$this->loggingSlowQueries = $toggle;
    	$this->setSlowQueryLimitSeconds = (float) $limitSeconds;
    	
    	$profilers = array();
    	
    	foreach ($adapters as $adapter)
    	{    		
    		$profiler = $adapter->getProfiler()->setEnabled($toggle);
    		
    		if (true == $toggle)
    		{
    			$profilers[] = $profiler;
    		}
    	}
    	
    	if (count($profilers) > 0)
    	{
    		Zend_Registry::set('profilers', $profilers);
    	}

    	$this->registerControllerPlugin('Base_Monitorix_Controller_Plugin_MonitorSlowQueries', $toggle);
    	
    	return $this;
    }

     /**
     * 
     * Turns logging of javascript errors on or off
     * Logs all javascript errors that are not caught
     * 
     * @param bool $toggle
     * @param bool $suppressJQueryCheck
     * 
     * @return Base_Monitorix_Monitor
     */
    public function logJavascriptErrors($toggle = TRUE, $suppressJQueryCheck = FALSE)
    {
    	if ($toggle)
    	{
    		//we need the view and try to get it from the view renderer
    		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			
    		if (null === $viewRenderer->view)
			{
				try 
				{
					$viewRenderer->init();
				}
				catch (Zend_Exception $exception)
				{
			    	throw new Base_Monitorix_Exception('Could not init() viewRenderer.');
				}
			}
			
			$view = $viewRenderer->view;
			
			if (!$suppressJQueryCheck)
			{
				//once we have the view, we need to make sure that ZendX_JQuery is active
				if (false === $view->getPluginLoader('helper')->getPaths('ZendX_JQuery_View_Helper')) 
	    		{
	    			try 
	    			{
	    				$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
	    			}
	    			catch (Zend_Exception $exception)
	    			{
	    				throw new Base_Monitorix_Exception('Failed to add ZendX_JQuery_View_Helper path to view.', NULL, $exception);
	    			}
	        	}
	        	
	        	//when we know that the ZendX_JQuery helper has been registered, we make sure jQuery is enabled
	        	if (!$view->jQuery()->isEnabled())
	        	{
	        		try 
	        		{
	        			$view->jQuery()->enable();
	        		}
	        		catch (Zend_Exception $exception)
	        		{
	        			throw new Base_Monitorix_Exception('Failed to enable jQuery.', NULL, $exception);
	        		}
	        	}
			}
    	}
    	
    	$this->loggingJavascriptErrors = $toggle;
    	$this->registerControllerPlugin('Base_Monitorix_Controller_Plugin_MonitorJavascript', $toggle);
    	
    	if ($toggle)
    	{
	    	$view->headScript()->prependScript("window.onerror = function(message, errorUrl, errorLine) {
    				$.ajax({
                    type: 'POST',
                    url: '?monitori=x',
                    dataType: 'html',
                    data: {'message': message, 'errorUrl': errorUrl, 'errorLine': errorLine},
                	});
    			}");
    	}
    	
    	return $this;
    	
    }
    
    /**
     * 
     * Setter for default logType
     * @param string $logType
     * @return Base_Monitorix_Monitor
     */
    public function setDefaultLogType($logType)
    {
    	$this->defaultLogType = (string) $logType;
    	return $this;
    }
    
    /**
     * 
     * Setter for the field 'projectName'
     * @param string $projectName
     * @return Base_Monitorix_Monitor
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        return $this;
    }
    
    /**
     * 
     * Setter for the field 'environment'
     * @param string $environment
     * @return Base_Monitorix_Monitor
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }
    
	/**
     * 
     * Setter for the field 'slowQueryLimitSeconds'
     * @param string $slowQueryLimitSeconds
     * @return Base_Monitorix_Monitor
     */
    public function setSlowQueryLimitSeconds($slowQueryLimitSeconds)
    {
        $this->slowQueryLimitSeconds = $slowQueryLimitSeconds;
        return $this;
    }
    
     /**
     * 
     * Getter for the field 'projectName'
     * @return string $projectName
     */
    public function getProjectName()
    {
        return $this->projectName;
    }
    
     /**
     * 
     * Getter for the field 'environment'
     * @return string $environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * 
     * Getter for the field 'slowQueryLimitSeconds'
     * @return string $slowQueryLimitSeconds
     */
    public function getSlowQueryLimitSeconds()
    {
    	return $this->slowQueryLimitSeconds;
    }
    
    /**
     * 
     * Maps the provided information to the corresponding fields
     * @param string|Zend_Exception $input
     * @return array @extraFields
     */
    protected function getExtraFieldsArray($input = null)
    {
        if ($input instanceof Zend_Exception)
        {
            $extraFields = array(
            						'logType'     => 'exception', 
            						'projectName' => $this->projectName, 
            						'environment' => $this->environment,
                                    'errorNumber' => $input->getCode(),
                                    'file'	      => $input->getFile(),
                                    'line'		  => $input->getLine(),
                                    'stacktrace'  => json_encode($input->getTrace())
                                );
        }
        else
        {
            $extraFields = array(
            						'logType'     => $this->logType,
            						'projectName' => $this->projectName, 
            						'environment' => $this->environment
                                );
        }
                           
        return $extraFields;
    }
    
    /**
     * 
     * Registers the MonitorExceptions plugin with the Zend front controller
     * @param bool $toggle
     */
    protected function registerControllerPlugin($pluginName, $toggle)
    {
        $frontController = Zend_Controller_Front::getInstance();
        
        $stackIndex = $this->getLowestFreeStackIndex();
        
        if (TRUE == $toggle)
        {
            $frontController->registerPlugin( new $pluginName, $stackIndex);
        }
        else 
        {
            $frontController->unregisterPlugin($pluginName);
        }
    }
    
    /**
     * 
     * Returns the lowest free Zend_Controller_Plugin stack index above $minimalIndex
     * @param int $minimalIndex
     * 
     * @return int $lowestFreeIndex || $minimalIndex
     */
    protected function getLowestFreeStackIndex($minimalIndex = 101)
    {
    	$plugins = Zend_Controller_Front::getInstance()->getPlugins();
    	$usedIndices = array();
    	
    	foreach ($plugins as $stackIndex => $plugin)
    	{
    		$usedIndices[$stackIndex] = $plugin;
    	}
    	
		krsort($usedIndices);
		
    	$highestUsedIndex = key($usedIndices);
    	
    	if ($highestUsedIndex < $minimalIndex)
    	{
    		return $minimalIndex;
    	}
    	
    	$lowestFreeIndex = $highestUsedIndex + 1;
    	
    	return $lowestFreeIndex;
    	
    }
}