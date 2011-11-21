<?php
class Base_View_Helper_PageElement extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function pageElement($name,$path="/layouts/scripts/page")
	{
		 $path=APPLICATION_PATH.$path;
		 $this->view->addScriptPath($path);
		 return $this->view->render($name.".phtml");
	}
	
	public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
	
}