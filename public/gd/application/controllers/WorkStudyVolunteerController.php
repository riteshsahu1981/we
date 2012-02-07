<?php
class WorkStudyVolunteerController extends Base_Controller_Action
{

	public function preDispatch()
	{
		parent::preDispatch();
		
		$blockM=new Base_View_Block();
		
   		$path="/layouts/scripts/page/blocks/work-study-volunteer";
   		
   		$blocks=array("name"=>"search-work-study-volunteer", "order"=>"10", "path"=>$path);
   		$blockM->addBlock($blocks, 'work-study-volunteer');
   		
   		$blocks=array("name"=>"right-banner", "order"=>"9", "path"=>$path);
   		$blockM->addBlock($blocks, 'work-study-volunteer');
   
   		$blocks=array("name"=>"work-study-volunteer-categories", "order"=>"7", "path"=>$path);
   		$blockM->addBlock($blocks, 'work-study-volunteer');

   		
   		
		$this->_helper->layout->setLayout('journal-layout-2column');
	}
	
	public function indexAction()
	{
		/*
		//$this->_helper->viewRenderer->setNoRender(true);
    	$params = $this->getRequest()->getParams();
		$identifire="work-study-volunteer";
		
		
		$pageM=new Application_Model_Page();
		$pageM=$pageM->getStaticContent($identifire);
		$this->view->title=$pageM->getTitle();
		$this->view->content=$pageM->getContent();
		$this->view->headTitle()->setSeparator(' - ');
	

                
		//Fetch work categories
		$categoryM=new Application_Model_Category();
		$this->view->workCats=$categoryM->fetchAll("type='work' AND status='published'", "name ASC");
		
		//Fetch Study categories
		$categoryM=new Application_Model_Category();
		$this->view->studyCats=$categoryM->fetchAll("type='study' AND status='published'", "name ASC");
		
		//Fetch volunteer categories
		$categoryM=new Application_Model_Category();
		$this->view->volunteerCats=$categoryM->fetchAll("type='volunteer' AND status='published'", "name ASC");
		*/
		
		$params		= $this->getRequest()->getParams();
		$identifire	= "work-study-volunteer";
		
		//Get CMS content to display in top of page
		$pageM	=	new Application_Model_Page();
		$pageM	=	$pageM->getStaticContent($identifire);
		if(false!==$pageM)
		{
			$this->view->title		=	$pageM->getTitle();
			$this->view->content	=	$pageM->getContent();
			$this->view->headTitle()->setSeparator(' - ');
		}	
		//fetch all WSV categories
		$categoryM	=	new Application_Model_Category();
		$this->view->categories = $categoryM->fetchAll("type='wsv' AND status='published'", "weight ASC");
		
		$this->render('home');	
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 14-Feb-2011
	 * @Description: Display WSV home page with category listing
	 */
	public function homeAction()
	{
		$params		= $this->getRequest()->getParams();
		$identifire	= "work-study-volunteer";
		
		//Get CMS content to display in top of page
		$pageM	=	new Application_Model_Page();
		$pageM	=	$pageM->getStaticContent($identifire);
		if(false!==$pageM)
		{
			$this->view->title		=	$pageM->getTitle();
			$this->view->content	=	$pageM->getContent();
			$this->view->headTitle()->setSeparator(' - ');
		}	
		//fetch all WSV categories
		$categoryM	=	new Application_Model_Category();
		$this->view->categories = $categoryM->fetchAll("type='wsv' AND status='published'", "weight ASC");
		
		$this->render('home');	
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 14-Feb-2011
	 * Description : Display WSV category details home page and articles listing to that category
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
		//display articles in right block associated with this category
		$this->view->category_id 		=	$category_id;
		
		//now get articles associsted with category
		$adviceM	=	new Application_Model_Articles();
		$where		=	"category_id={$category_id} AND status='1'";
		$order		=	"addedon DESC";
		
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
		//$page_size	=	1;
		$page		=	$this->_getParam('page',1);
		
		$pageObj	=	new Base_Paginator();			
		$paginator	=	$pageObj->fetchPageData($adviceM, $page, $page_size, $where, $order);
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->articles	=	$paginator;
	}
	
	public function detailAction()
	{
		$id=$this->_getParam("id");	
		$articlesM=new Application_Model_Articles();
		$where = "category_id =$id AND status='1'";
		
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		
	
		$this->view->param=array('id'=>$id);
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		
			
		$paginator=$pageObj->fetchPageData($articlesM,$page,$page_size,$where,"title ASC");
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->articles=$paginator;
		
		$categoryM = new Application_Model_Category();
		$this->view->category=$categoryM->find($id);
				
	}
	
   public function searchAction()
	{
		
    	$params = $this->getRequest()->getParams();
    	$where = "1=1 AND status='1'";
		$order	= "addedon DESC";
		
    	$searchstrg = '';
    	if(isset($params['search-strg']))
    	{
		    	if($params['search-strg']!='' && $params['search-strg']!='Search by Keyword')
		    	{
		    		$where.= "AND (title LIKE '%".$params['search-strg']."%' OR content LIKE '%".$params['search-strg']."%' OR synopsis LIKE '%".$params['search-strg']."%')";
		    		$this->view->searchstr = $searchstrg = $params['search-strg'];
		    	}
		    	$extras['search-strg'] =$searchstrg;
	    }
	    
	    $categoryM = new Application_Model_Category();
	    if(isset($params['search-filtr']) && $params['search-filtr']!='')
        {
        	$this->view->searchfiltr = $searchfiltr = $params['search-filtr'];	
	        $extras['search-filtr'] =$searchfiltr;
	     	
        	$categorydata = $categoryM->find($searchfiltr);
        	$category_id  = $categorydata->getId();
        	$this->view->categoryName = $categorydata->getName();
        	$where.= "AND category_id = $category_id";
            
        }        
		
		$articles = new Application_Model_Articles();
		
		/*
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		//$this->view->param=$extras;
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		
			
		$paginator=$pageObj->fetchPageData($articles,$page,$page_size,$where);
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->articles=$paginator;
		*/
		$articlesRes			=	$articles->fetchAll($where, $order);
		$this->view->total		=	count($articlesRes);
		$this->view->articles	=	$articlesRes;
		$this->view->categoryM	=	$categoryM;		
	}
	
	
public function categoryDetailAction()
	{
		//$this->_helper->viewRenderer->setNoRender(true);
    	$params = $this->getRequest()->getParams();
		$category = $params['category'];
		$this->view->title = $category;
		$categoryM=new Application_Model_Category();
	
		$this->view->cats=$categoryM->fetchAll("type='$category' AND status='published'", "name ASC");

	
	}
	
	public function articleDetailAction()
	{
		//$this->_helper->viewRenderer->setNoRender(true);		
		$blockM = new Base_View_Block();
		
   		$path ="/layouts/scripts/page/blocks/work-study-volunteer";
   		$blockM->removeBlock("work-study-volunteer-categories", 'work-study-volunteer');   		
   		
    	$params = $this->getRequest()->getParams();
		$article_id = $params['id'];
	    
		$preview	=	false;
		$preview	=	$this->_getParam("preview");
		
		$categoryM=new Application_Model_Category();
		$articleM=new Application_Model_Articles();
		
		$data = $articleM->find($article_id);
		if(false!=$data)
		{
			$this->view->article =  $data;
			$this->view->preview = $preview;
			$this->view->categoryId = $categoryId = $data->getCategoryId();
			$this->view->categoryM = $categoryM->find($categoryId);		
		
			$allarticles=$articleM->fetchAll("category_id = $categoryId and id != $article_id");
	    
			/**
			 * @Added By: Mahipal Adhikari
			 * @Added On: 29-Dec-2010
			 * @Description: get Article user information to display as Author
			 */
			$userM = new Application_Model_User();
			$userRes = $userM->find($data->getUserId());
			$Author = "Admin";
			if(false!==$userRes)
			{
				$Author = $userRes->getFirstName()." ".$userRes->getLastName();
				$this->view->author = $Author;
				$this->view->author_username = $userRes->getUsername();
			}
			
			if(count($allarticles)>0)
			{
				$this->view->allarticles = $allarticles;
				$blocks=array("name"=>"work-study-volunteer-articles", "order"=>"8", "path"=>$path);
				$blockM->addBlock($blocks, 'work-study-volunteer');
			}
		}	
	}
	
}
