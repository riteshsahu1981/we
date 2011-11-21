<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
	
defined('PUBLIC_PATH')
    || define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/../public'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

 
    defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';






// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);


/*------- Custom Routing --------*/
$ctrl  = Zend_Controller_Front::getInstance();
$router = $ctrl->getRouter();
/*
$router->addRoute(
    'user',
    new Zend_Controller_Router_Route(':nickname',
                                     array('controller' => 'index',
                                           'action' => 'gapper-profile'))
);*/


//$real_url=$_SERVER['REQUEST_URI'];
//$seo_url=

/*$router->addRoute(
    null,
    new Zend_Controller_Router_Route(':action',
                                     array('controller' => 'index',
                                           'module' => 'default'))
);
*/
/*$router->addRoute(
    'user',
    new Zend_Controller_Router_Route( ':controller/:action/:username',
                                    array('module' => 'default'))
);*/



/*------------------------*/




	$application->bootstrap()
           ->run();


//echo PUBLIC_PATH.'/cache/';exit;
/*$key=md5($_SERVER['REQUEST_URI']);
$frontendOptions = array('lifeTime' => 30,'automatic_serialization' => true); // 30 seconds
$backendOptions = array('cache_dir' => PUBLIC_PATH.'/cache/');
$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
if (!$value = $cache->load($key) ){
	ob_start();
	$application->bootstrap()
            ->run();
	$value=ob_get_contents();
	ob_end_clean();
    $cache->save($value, $key);
	print "cache Miss: ";

} else {
	    echo "cache hit: ";
}
	print $value;
*/