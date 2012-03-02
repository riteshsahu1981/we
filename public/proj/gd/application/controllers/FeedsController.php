<?php
class FeedsController extends Base_Controller_Action
{   	
	public function indexAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	// functions moved to admin module
}
