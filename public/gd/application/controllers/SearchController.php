<?php                         
class SearchController extends Base_Controller_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_helper->layout->setLayout('journal-layout-2column');
        //$this->_helper->layout->setLayout('advice-layout-2column');
    }

    public function indexAction()
    {
		$params['q'] = $this->_getParam('q');
            
		if (isset($params['q']) && $params['q']<>"" && $params['q']<>"Search Gap Daemon")
		{
			$this->view->searchtext	=	$searchtext = $params['q'];
			$settings               =	new Admin_Model_GlobalSettings();
			$page_size              =	$settings->settingValue('pagination_size');
			//$page_size				= 	1;
			
			$modelList              =   new Application_Model_SearchView();
			
			$searchData             =   $modelList->searchResult($searchtext);
			$page                   =   $this->_getParam('page',1);
			$pageObj                =   new Base_Paginator();
			$paginator              =   $pageObj->fetchPageDataResult($searchData,$page,$page_size);
			if($pageObj->getTotalCount()>0)
			{
				$this->view->total         =   $pageObj->getTotalCount();
				$this->view->paginator     =   $paginator;
			}
			else
			{
				$this->view->message = "No result found for this keyword.";
			}
		}
		else
		{
			$this->view->message = "Missing search parameters.";
		}
    }	
}
