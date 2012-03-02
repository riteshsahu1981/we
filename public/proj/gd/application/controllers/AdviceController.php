<?php                         
class AdviceController extends Base_Controller_Action
{
	public function preDispatch()
	{
		parent::preDispatch();
		
		$blockM=new Base_View_Block();
		
   		$path="/layouts/scripts/page/blocks/advice";
   		$blocks=array("name"=>"search-advice", "order"=>"10", "path"=>$path);
   		$blockM->addBlock($blocks, 'advice');
   		$blocks=array("name"=>"right-banner", "order"=>"9", "path"=>$path);
   		$blockM->addBlock($blocks, 'advice');
   
   		$blocks=array("name"=>"advice-categories", "order"=>"7", "path"=>$path);
   		$blockM->addBlock($blocks, 'advice');

   		
   		 $this->_helper->layout->setLayout('journal-layout-2column');
		//$this->_helper->layout->setLayout('advice-layout-2column');
	}
	
	public function indexAction()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
    	//$this->_forward('home','advice',null);
		/*
		$params = $this->getRequest()->getParams();
    	$where = "1=1 AND status='1'";
    	$searchstrg = '';
    	if(isset($params['search-strg']))
    	{
			if($params['search-strg']!='' && $params['search-strg']!='Search By Keyword')
			{
				if($params['search-strg']=='Search by Keyword')
				{
					$searchstring='';
				}
				else
				{
					$searchstring=$params['search-strg'];
				}
				$where.= "AND (title LIKE '%".$searchstring."%' OR content LIKE '%".$searchstring."%')";
				$this->view->searchstr = $searchstrg = $searchstring;
			}
	    }
	    
	    
	    if(isset($params['search-filtr']) && $params['search-filtr']!='')
        {
			$this->_helper->redirector('detail','advice',"default",array("id"=>$params['search-filtr']));
        }        
        
		$identifire="advice";
		$advice=new Application_Model_Advice();
		
		$pageM=new Application_Model_Page();
		$pageM=$pageM->getStaticContent($identifire);
		
		$this->view->title=$pageM->getTitle();
		$this->view->content=$pageM->getContent();
		$this->view->headTitle()->setSeparator(' - ');
		
		
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		
	
		$this->view->param=array('search-strg'=>$searchstrg);
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();		
			
		$paginator=$pageObj->fetchPageData($advice,$page,$page_size,$where);
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->advices=$paginator
		*/
		
		//get advice CMS page detail content
		$identifire	=	"advice";
		
		$pageM		=	new Application_Model_Page();
		$pageM		=	$pageM->getStaticContent($identifire);
		
		if(false!==$pageM)
		{
			$this->view->title		=	$pageM->getTitle();
			$this->view->content	=	$pageM->getContent();
			//$this->view->headTitle()->setSeparator(' - ');
		}	
		
		//get Advice categories
		$categoryM		=	new Application_Model_Category();
		$where			=	"type='advice' AND status='published'";
		$order			=	"weight ASC";
        $categoryRes	=	$categoryM->fetchAll($where, $order);
		
		$this->view->total		=	count($categoryRes);
		$this->view->categories =	$categoryRes;
		
		$this->render('home');
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Feb-2011
	 * Description : Display advice home page with CMS content and available categories
	 */
	public function homeAction()
	{
		//get advice CMS page detail content
		$identifire	=	"advice";
		
		$pageM		=	new Application_Model_Page();
		$pageM		=	$pageM->getStaticContent($identifire);
		
		if(false!==$pageM)
		{
			$this->view->title		=	$pageM->getTitle();
			$this->view->content	=	$pageM->getContent();
			//$this->view->headTitle()->setSeparator(' - ');
		}	
		
		//get Advice categories
		$categoryM		=	new Application_Model_Category();
		$where			=	"type='advice' AND status='published'";
		$order			=	"weight ASC";
        $categoryRes	=	$categoryM->fetchAll($where, $order);
		
		$this->view->total		=	count($categoryRes);
		$this->view->categories =	$categoryRes;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Feb-2011
	 * Description : Display advice category details home page and advice listing to that category
	 */
	public function categoryAction()
	{
		$params = $this->getRequest()->getParams();
		$category_id = $params["id"];
		
		//get category detail
		$categoryM		=	new Application_Model_Category();
		$category		=	$categoryM->find($category_id);
		if(false!==$category)
		{
			$this->view->name			=	$category->getName();
			$this->view->description	=	$category->getDescription();
			$this->view->param 			=	array('id'=>$category_id);
		}
		//display advices in right block associated with this category
		$this->view->category_id 		=	$category_id;
		
		//now get advices associsted with category
		$adviceM	=	new Application_Model_Advice();
		$where		=	"category_id={$category_id} AND status='1'";
		$order		=	"addedon DESC";
		
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
		//$page_size	=	1;
		$page		=	$this->_getParam('page',1);
		
		$pageObj	=	new Base_Paginator();			
		$paginator	=	$pageObj->fetchPageData($adviceM, $page, $page_size, $where, $order);
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->advices	=	$paginator;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Feb-2011
	 * Description : Search advice
	 */
	public function searchAction()
	{		
    	$params	= $this->getRequest()->getParams();
    	$where	= "status='1'";
    	$order	= "addedon DESC";
		
		$categoryM = new Application_Model_Category();
		
		//search by keyword
    	if(isset($params['search-strg']))
    	{
			if($params['search-strg']!='' && $params['search-strg']!='Search by Keyword')
			{
				$keyword = $params['search-strg'];
				$where.= " AND (title LIKE '%{$keyword}%' OR content LIKE '%{$keyword}%' OR synopsis LIKE '%{$keyword}%')";
				$this->view->searchstr = $keyword;
			}
		}
	    
	    //search by category
	    if(isset($params['category_id']) && $params['category_id']!='')
        {
        	$this->view->category_id = $category_id = $params['category_id'];	
	        
			$categorydata = $categoryM->find($category_id);
        	$category_id  = $categorydata->getId();
        	$this->view->categoryName = $categorydata->getName();
        	$where.= " AND category_id = {$category_id}";            
        }        
		
		$adviceM	=	new Application_Model_Advice();
		
		//$settings	=	new Admin_Model_GlobalSettings();
		//$page_size	=	$settings->settingValue('pagination_size');
		//$page_size	=	1;
		//$page		=	$this->_getParam('page',1);
		
		//$pageObj	=	new Base_Paginator();
		//$paginator	=	$pageObj->fetchPageData($adviceM, $page, $page_size, $where);
		
		//$this->view->total		=	$pageObj->getTotalCount();
		//$this->view->advices	=	$paginator;
		
		$adviceRes	=	$adviceM->fetchAll($where, $order);
		$this->view->total		=	count($adviceRes);
		$this->view->advices	=	$adviceRes;
		$this->view->categoryM	=	$categoryM;
	}
	
	public function detailAction()
	{
		$id			=	$this->_getParam("id");
		$preview	=	false;
		$preview	=	$this->_getParam("preview");
		
		$adviceM	=	new Application_Model_Advice();
        $adviceM	=	$adviceM->find($id);
		if(false!==$adviceM)
		{
			$this->view->advice = $adviceM;
			$this->view->preview = $preview;
					
			//display advices in right block associated with this category
			$this->view->category_id =	$category_id =	$adviceM->getCategoryId();
		
			$categoryM	= new Application_Model_Category();
			$categoryM	= $categoryM->find($category_id);
			$cat_name	= "";
			if(false!==$categoryM)
			{
				$cat_name	= $categoryM->getName();
				$this->view->cat_name = $cat_name;
			}
		
			/**
			 * @Added By: Mahipal Adhikari
			 * @Added On: 1-Mar-2011
			 * @Description: get Article user information to display as Author
			 */
			$userM = new Application_Model_User();
			$userRes = $userM->find($adviceM->getUserId());
			$Author = "Admin";
			if(false!==$userRes)
			{
				$Author = $userRes->getFirstName()." ".$userRes->getLastName();
				$this->view->author = $Author;
				$this->view->author_username = $userRes->getUsername();
			}
		}//end if	
	}//end function
}
