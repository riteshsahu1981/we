<?php
require_once 'Zend/Application.php';

class Base_App extends Zend_Application
{
	/**
	 * Front Controller.
	 * 
	 * @var Zend_Controller_Front
	 */
	protected $_front;
	
	/**
	 * Router
	 * 
	 * @var Zend_Controller_Router_Rewrite
	 */
	protected $_router;
	
	/**
	 * Request.
	 * 
	 * @var Zend_Controller_Request_Http
	 */
	protected $_request;
	
	/**
	 * Response.
	 * 
	 * @var Zend_Controller_Response_Http
	 */
	protected $_response;

	/**
	 * Modules dir path.
	 * 
	 * @var string
	 */
	protected $_moduleDir;
	
	/**
	 * Application path.
	 * 
	 * @var string
	 */
	protected $_appPath;

	/**
	 * Sets up all the initial required pieces of the app.
	 * 
	 * @param string $environment
	 * @param string $appPath
	 * @param string $moduleDir
	 */
	public function __construct($environment, 
								$appPath = APPLICATION_PATH, 
								$moduleDir = 'modules')
	{
		// set the environment
		$this->_environment = (string) $environment;
		
		// set the application path
		$this->_appPath = $appPath;
		
		// set the modules dir path
		$this->_moduleDir 	= $this->_appPath . 
							  DIRECTORY_SEPARATOR . $moduleDir;
		 
		// initiate autoloader				  
		require_once 'Zend/Loader/Autoloader.php';
		$this->_autoloader = Zend_Loader_Autoloader::getInstance();
		
		// set up module autoloading
		$this->_autoloader->pushAutoloader(array($this, 'moduleAutoload'));
		
		// set front controller
		$this->_front  = Zend_Controller_Front::getInstance();
		
		// add module directory
		$this->_front->addModuleDirectory($this->_moduleDir);
		
		// initiate request
		if($this->_request === null) {
			$this->_request = new Zend_Controller_Request_Http();
		}
		
		// initiate response
		if($this->_response === null) {
			$this->_response = new Zend_Controller_Response_Http();
		}
	
		// initiate router (Zend_Controller_Router_Rwrite)
		$this->_router = $this->_front->getRouter();
		
		// get application.ini options
		$appOptions = $this->_getApplicationOptions();
		
		// set routes in router from application.ini (if any)
		$this->_addRoutesFromConfig($appOptions);
		
		// update request with routes
		$this->_route($this->_request);

		// get module options
		$moduleOptions = $this->_getModuleOptions();
		
		// merge application and module options into one array
		$options = $this->mergeOptions($appOptions, $moduleOptions);
		
		// set options
		$this->setOptions($options);
		
		// update front controller request
		$this->_front->setRequest($this->_request);
		
		// update front controller response
		$this->_front->setResponse($this->_response);
		
		// to be used in dispatch
		$this->_front->setRouter($this->_router);
	}
	
	/**
	 * Create options from application.ini.
	 * 
	 * @return array
	 */
	private function _getApplicationOptions()
	{
		$appConfig = $this->_appPath . DIRECTORY_SEPARATOR . 
					 'configs' . DIRECTORY_SEPARATOR . 
					 'application.ini';
		return $this->_loadConfig($appConfig);
	}
	
	/**
	 * Create requested module's options from the requested
	 * module's module.ini.
	 * Router resource can only be defined in application.ini.
	 * 
	 * @return array
	 */
	private function _getModuleOptions()
	{
		$moduleName = $this->_request->getModuleName();
		$moduleDir  = $this->_moduleDir;
		$modConfig  = $moduleDir  . DIRECTORY_SEPARATOR . 
			 		  $moduleName . DIRECTORY_SEPARATOR . 
				  	  'configs'   . DIRECTORY_SEPARATOR . 'module.ini';

		$options = $this->_loadConfig($modConfig);
		if(isset($options['resources']['router'])) {
			throw new Exception ('You can only set routes in application.ini');
		}
		return $options;
	}

	/**
	 * Add routes from options created from application.ini.
	 * Router resource cannot be declared in module.ini.
	 * 
	 * @param array $options | from application.ini
	 */
	private function _addRoutesFromConfig($options)
	{
		if (!isset($options['resources']['router']['routes'])) {
        	$options['resources']['router']['routes'] = array();
     	}
		if (isset($options['resources']['router']['chainNameSeparator'])) {
			$this->_router->setChainNameSeparator($options['resources']['router']['chainNameSeparator']);
		}
		if (isset($options['resources']['router']['useRequestParametersAsGlobal'])) {
      		$this->_router->useRequestParametersAsGlobal($options['resources']['router']['useRequestParametersAsGlobal']);
		}
		$this->_router->addConfig(new Zend_Config($options['resources']['router']['routes']));
		
		// don't trigger Zend_Application_Resource_Router
		unset($options['resources']['router']);
	}
	
	/**
	 * Same route function in Zend_Controller_Front::dispatch().
	 * It updates the request with routes and sends a message to
	 * Zend_Controller_Front. This is processed in dispatch().
	 * 
	 * @param Zend_Controller_Request_Abstract $request
	 */
	private function _route(Zend_Controller_Request_Abstract $request)
	{		
		try {
        	$this->_router->route($request);	
                }  catch (Exception $e) {
                        if ($this->_front->throwExceptions()) {
                                throw $e;
                        }
                }
	}
	
	/**
	 * Instead of defining an autoloader for every module in 
	 * its corresponsing bootstrap, this take care of all the
	 * autoloading for all the classes under modules. The only
	 * thing is that the file names under modules need to be
	 * exact in the class declaration.
	 * 
	 * Example:
	 * application/modules/bugs/models/Tracker.php
	 * 
	 * So the Tracker.php will have the following class:
	 * class Bugs_Models_Tracker
	 * {
	 * 		// code
	 * }
	 * 
	 * You can call this class:
	 * $tracker = new Bugs_Models_Tracker();
	 * 
	 * This can also be achieved within this function with 
	 * a closure.
	 * private function _moduleAutoload()
	 * {
	 * 		$load = function($class) {
	 * 			$file = $this->_moduleDir . DIRECTORY_SEPARATOR . 
	 *    		 	str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
	 *	   		require $file;
	 *		};
	 *     	$this->getAutoloader()->pushAutoloader($load);
	 * }
	 *	Then in the constructor of this class you can call this function as
	 *  $this->_moduleAutoload();
	 */
	public function moduleAutoload($class)
	{
		$file = $this->_moduleDir . DIRECTORY_SEPARATOR . 
		    		 str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
		require $file;
	}
}