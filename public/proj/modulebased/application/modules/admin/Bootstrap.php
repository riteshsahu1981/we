<?php

class Admin_Bootstrap extends Base_Application_Module_Bootstrap
{
    
    protected function _initPlugins()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);

//        $opt=$this->getBootstrap()->getOptions();
//        echo "ritesh";  
//        var_dump($opt);exit;
        //var_dump($this->getOptions());exit;
  
    }

}