<?php
class Base_View_Helper_Metas extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function metas($param)
	{
		/*--- Requested Module ------*/
		$module=$this->view->module;
		/*-----------------------------------*/

		/*---- Requested Action -------*/
		$actionName=$this->view->actionName;
		/*-----------------------------------*/

		/*---- Requested Controller -------*/
		$controllerName=$this->view->controllerName;
		/*-----------------------------------*/

		
                $this->view->headTitle("Admin Panel");
                $this->view->headMeta()->appendName("ROBOTS","NOINDEX, NOFOLLOW");
                $this->view->headMeta()->appendName("description","xyz");
                $this->view->headMeta()->appendName("keywords","xyz");

		
	}//end of function
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}	
}
