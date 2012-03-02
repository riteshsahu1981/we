<?php
class Admin_ShopController extends Base_Controller_Action
{
	public function indexAction()
	{
		//set error message
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Admin_Model_ShopDeals();
		$modelRes	=	$modelRes->find($id);

		$options = array(
						'dealAds1'	=> $modelRes->getDealAds1(),
						'dealAds2'	=> $modelRes->getDealAds2()
						);

		$form    = new Admin_Form_ShopDeals();
		$form->populate($options);
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				$modelRes->setOptions($options);
				$updateRes = $modelRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg']	=	"Content has been updated successfully.";
					$this->_helper->redirector('index','shop','admin',array('id'=>$id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}
			}//end if
			else
			{
				$form->reset();
				$form->populate($options);
			} 		
		}//end if
		
		//set form
		$this->view->form=$form;	
	}//end function
}

