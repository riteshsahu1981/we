<?php
class Base_View_Helper_SeoUrl extends Zend_View_Helper_Abstract
{
    public $view;

	public function seoUrl($string)
	{
		//$request=Zend_Controller_Request_Abstract::getControllerName();
		//echo $this->view->controllerName;
	   
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
                
		if($config->seofriendlyurl=="1")
		{
			$stringSearchArr = explode("?",$string);
			$string = $stringSearchArr[0];
								
			$seoUrlM=new Application_Model_SeoUrl();
			$seoUrl=$seoUrlM->fetchRow("actual_url='{$string}'");
			if(false!==$seoUrl)
			{
				if(isset($stringSearchArr[1]))
				{
					return $seoUrl->getSeoUrl()."?".$stringSearchArr[1];
				}
				else
				{
					return $seoUrl->getSeoUrl();
				}	
			}
			
			return $string;
		}
		else
		{
                    
			return $string;
		}
	}
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
}
