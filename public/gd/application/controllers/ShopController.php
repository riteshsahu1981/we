<?php
/**
* @Created By: Mahipal Singh Adhikari
* @Created On: 07-January-2011
* @Description: This controller is used to display Amazon Shop in iframe
*/
class ShopController extends Base_Controller_Action
{

	public function preDispatch()
	{
		parent::preDispatch();
		//$this->_helper->layout->setLayout('travel-shop');
		$this->_helper->layout->setLayout('shop');
	}
	
	public function indexAction()
	{
		//$this->_helper->redirector('amazon','shop'); //redirect user to amazon shop
		//redirect user for the time being and remove it once LIVE
		//$this->_helper->redirector('index','index');
		
		//get Affiliate Hot Deals for right section advertisement
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Admin_Model_ShopDeals();
		$modelRes	=	$modelRes->find($id);
		
		$add120x600 = "";
		$add120x60 = "";
		
		if(false!==$modelRes)
		{
			$add120x600	= $modelRes->getDealAds1();
			$add120x60	= $modelRes->getDealAds2();
		}
		$this->view->add120x600 = $add120x600;
		$this->view->add120x60 = $add120x60;
	}
	
	/**
	* @Added By: Mahipal Singh Adhikari
	* @Added On: 07-Jan-2011
	* @Description: display index page of Travel Shop
	*/
	public function amazonAction()
	{
		$this->_helper->layout->setLayout('travel-shop');
	}
	
	public function explorerAction()
	{
		
	}
	
	public function insuranceAction()
	{
		
	}
}
