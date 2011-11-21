<?php
class Base_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Constructor
     *
     * @param Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     * @return void
     */
    public function __construct($application)
    {
        parent::__construct($application);
        $this->init();
    }

    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
    	//$this->registerPluginResource('modulesetup');
        //$this->_executeResource('modulesetup');
    }

}
