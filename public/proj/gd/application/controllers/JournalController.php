<?php
class JournalController extends Base_Controller_Action
{

	public function preDispatch()
	{
		parent::preDispatch();

	}
	public function __call($method,$args)
	{
		$username=$this->getRequest()->getActionName();
		$this->_forward('journals','profile','default',
                                                array(
                                                     'username' => $username
                                                ));
	}
	
	public function indexAction()
	{
		$this->_helper->layout->setLayout('journal-layout-2column');
		
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->userId = $loggedin_id = $userNs->userId;

		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('journal_page_size');
		
		$blogm		=	new Application_Model_Blog();
		$params		= $this->getRequest()->getParams();
		//print_r($params);
		/*
		//Display only Public & Published journals
		$where = "publish='published' AND status='public' ";
		
		//search by Keyword
		if(isset($params['search-jrnl']) && $params['search-jrnl']!='Search by Keyword')
		{
			$searchkey = $params['search-jrnl'];
			$where .= " AND (title LIKE '%$searchkey%' OR tags LIKE '%$searchkey%' OR content LIKE '%$searchkey%' ";
			$this->view->searchjrnl = $searchkey;
			
			//search by Author as well while searching by keyword
			$user_where_sql  = "status='active'";
			$user_where_sql .= " AND (username like '%$searchkey%' OR CONCAT(first_name,' ',last_name ) LIKE '%$searchkey%')";
			$UserM	=	new Admin_Model_User();
			$UserM	=	$UserM->fetchAll($user_where_sql);
			if(false!==$UserM)
			{
				if(count($UserM)>0)
				{
					foreach($UserM as $userrow)
					{
						$userarray[] = $userrow->getId();
					}
					$userstr  = implode(',',$userarray);
					$where .= " OR user_id IN ($userstr)";
				}				 
			}
			$where .= ")";
		}
		
		//search by Location
		if(isset($params['search-city']) && $params['search-city']!='In City / Place')
		{
			$searchcity = $params['search-city'];
			$where .= " AND location LIKE '%$searchcity%'";
			$this->view->searchcity  = $searchcity;
		}
		
		//search by Category
		if(isset($params['search-filtr']) && $params['search-filtr']!='')
		{
			$searchfiltr = $params['search-filtr'];
			$where .= " AND category_id = '$searchfiltr'";
			$this->view->searchfiltr  = $searchfiltr;
		}
		
		//search by Tag cloud
		if(isset($params['search-cloud']) && $params['search-cloud']!='')
		{
			$searchcloud = $params['search-cloud'];
			$where .= " AND tags LIKE '%$searchcloud%'";
			$this->view->searchcloud  = $searchcloud;
		}
		$data	=	$blogm->fetchAll($where, "addedon DESC",$page_size);
		*/
		
		//search by Keyword
		$whereSearchSQL = "";
		if(isset($params['search-jrnl']) && $params['search-jrnl']!='Search by Keyword')
		{
			$searchkey = $params['search-jrnl'];
			$whereSearchSQL .= " AND (b.title LIKE '%$searchkey%' OR b.tags LIKE '%$searchkey%' OR b.content LIKE '%$searchkey%' ";
			$this->view->searchjrnl = $searchkey;
			
			//search by Author as well while searching by keyword
			$user_where_sql  = "status='active'";
			$user_where_sql .= " AND (username like '%$searchkey%' OR CONCAT(first_name,' ',last_name ) LIKE '%$searchkey%')";
			$UserM	=	new Admin_Model_User();
			$UserM	=	$UserM->fetchAll($user_where_sql);
			if(false!==$UserM)
			{
				if(count($UserM)>0)
				{
					foreach($UserM as $userrow)
					{
						$userarray[] = $userrow->getId();
					}
					$userstr  = implode(',',$userarray);
					$whereSearchSQL .= " OR b.user_id IN ($userstr)";
				}				 
			}
			$whereSearchSQL .= ")";
		}
		
		//search by Location
		if(isset($params['search-city']) && $params['search-city']!='In City / Place')
		{
			$searchcity = $params['search-city'];
			$whereSearchSQL .= " AND b.location LIKE '%$searchcity%'";
			$this->view->searchcity  = $searchcity;
		}
		
		//search by Category
		if(isset($params['search-filtr']) && $params['search-filtr']!='')
		{
			$searchfiltr = $params['search-filtr'];
			$whereSearchSQL .= " AND b.category_id = '$searchfiltr'";
			$this->view->searchfiltr  = $searchfiltr;
		}
		
		//search by Tag cloud
		if(isset($params['search-cloud']) && $params['search-cloud']!='')
		{
			$searchcloud = $params['search-cloud'];
			$whereSearchSQL .= " AND b.tags LIKE '%$searchcloud%'";
			$this->view->searchcloud  = $searchcloud;
		}
		
		$sSQL  = "SELECT b.* FROM blog AS b";
		$sSQL .= " JOIN journal AS j ON j.user_id = b.user_id";
		//$sSQL .= " WHERE b.publish='published' AND b.status=5";
		$sSQL .= " WHERE b.publish='published'";
		$sSQL .= " AND j.publish='published' AND j.status='public'";
		if($whereSearchSQL!="")
		{
			$sSQL .= $whereSearchSQL;
		}
		$sSQL .= " ORDER BY b.addedon DESC";
		//echo "<br />".$sSQL;exit;
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		//$data	=	$pageObj->fetchPageDataRaw($sSQL, $page, $page_size);
		$data	=	$pageObj->fetchBlogData($sSQL, $page, $page_size);
		$this->view->data=$data;

		/******* Featured blog post START ********/
		//$where_fea = "publish='published' AND status=5 AND featured=1";
		$where_fea = "publish='published' AND featured=1";
		$data_fea = $blogm->fetchAll($where_fea, "updatedon DESC");
		$this->view->data_fea = $data_fea;
		/******* Featured blog post END ********/

		//Get Jouranl Post Category
		$categoryM=new Application_Model_Category();
		$this->view->journalCategory=$categoryM->getJournalCategory();
	}

	public function blogsAction()
	{
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->userId=$userNs->userId;
				
		$mode	=	$this->_getParam("mode");

		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('journal_page_size');
		$page		=	$this->_getParam("page");
		$offset		=	($page-1)*$page_size;

		$blogm		= new Application_Model_Blog();
		$params		= $this->getRequest()->getParams();
		//print_r($params);
		
		/*
		//Display only Public & Published journals
		$where = "publish='published' AND status='public'";	
		
		//search by Keyword
		if(isset($params['search-jrnl']) && $params['search-jrnl']!='Search by Keyword')
		{
			$searchkey = $params['search-jrnl'];
			$where .= " AND (title LIKE '%$searchkey%' OR tags LIKE '%$searchkey%' OR content LIKE '%$searchkey%' ";
			$this->view->searchjrnl = $searchkey;
			
			//search by Author as well while searching by keyword
			$user_where_sql  = "status='active'";
			$user_where_sql .= " AND (username like '%$searchkey%' OR CONCAT(first_name,' ',last_name ) LIKE '%$searchkey%')";
			$UserM	=	new Admin_Model_User();
			$UserM	=	$UserM->fetchAll($user_where_sql);
			if(false!==$UserM)
			{
				if(count($UserM)>0)
				{
					foreach($UserM as $userrow)
					{
						$userarray[] = $userrow->getId();
					}
					$userstr  = implode(',',$userarray);
					$where .= " OR user_id IN ($userstr)";
				}				 
			}
			$where .= ")";
		}
		//search by Location
		if(isset($params['search-city']) && $params['search-city']!='In City / Place')
		{
			$searchcity = $params['search-city'];
			$where .= " AND location LIKE '%$searchcity%'";
			$this->view->searchcity  = $searchcity;
		}
		//search by Category		
		if(isset($params['search-filtr']) && $params['search-filtr']!='')
		{
			$searchfiltr = $params['search-filtr'];
			$where .= " AND category_id = '$searchfiltr'";
			$this->view->searchfiltr  = $searchfiltr;
		}
		//search by Tag cloud search	
		if(isset($params['search-cloud']) && $params['search-cloud']!='')
		{
			$searchcloud = $params['search-cloud'];
			$where .= " AND tags LIKE '%$searchcloud%'";
			$this->view->searchcloud  = $searchcloud;
		}				
		$data=$blogm->fetchAll($where, "addedon DESC",$page_size,$offset);
		*/
		
		//search by Keyword
		$whereSearchSQL = "";
		if(isset($params['search-jrnl']) && $params['search-jrnl']!='Search by Keyword')
		{
			$searchkey = $params['search-jrnl'];
			$whereSearchSQL .= " AND (b.title LIKE '%$searchkey%' OR b.tags LIKE '%$searchkey%' OR b.content LIKE '%$searchkey%' ";
			$this->view->searchjrnl = $searchkey;
			
			//search by Author as well while searching by keyword
			$user_where_sql  = "status='active'";
			$user_where_sql .= " AND (username like '%$searchkey%' OR CONCAT(first_name,' ',last_name ) LIKE '%$searchkey%')";
			$UserM	=	new Admin_Model_User();
			$UserM	=	$UserM->fetchAll($user_where_sql);
			if(false!==$UserM)
			{
				if(count($UserM)>0)
				{
					foreach($UserM as $userrow)
					{
						$userarray[] = $userrow->getId();
					}
					$userstr  = implode(',',$userarray);
					$whereSearchSQL .= " OR b.user_id IN ($userstr)";
				}				 
			}
			$whereSearchSQL .= ")";
		}
		
		//search by Location
		if(isset($params['search-city']) && $params['search-city']!='In City / Place')
		{
			$searchcity = $params['search-city'];
			$whereSearchSQL .= " AND b.location LIKE '%$searchcity%'";
			$this->view->searchcity  = $searchcity;
		}
		
		//search by Category
		if(isset($params['search-filtr']) && $params['search-filtr']!='')
		{
			$searchfiltr = $params['search-filtr'];
			$whereSearchSQL .= " AND b.category_id = '$searchfiltr'";
			$this->view->searchfiltr  = $searchfiltr;
		}
		
		//search by Tag cloud
		if(isset($params['search-cloud']) && $params['search-cloud']!='')
		{
			$searchcloud = $params['search-cloud'];
			$whereSearchSQL .= " AND b.tags LIKE '%$searchcloud%'";
			$this->view->searchcloud  = $searchcloud;
		}
		
		$sSQL  = "SELECT b.* FROM blog AS b";
		$sSQL .= " JOIN journal AS j ON j.user_id = b.user_id";
		//$sSQL .= " WHERE b.publish='published' AND b.status=5";
		$sSQL .= " WHERE b.publish='published'";
		$sSQL .= " AND j.publish='published' AND j.status='public'";
		if($whereSearchSQL!="")
		{
			$sSQL .= $whereSearchSQL;
		}
		$sSQL .= " ORDER BY b.addedon DESC";
		//echo "<br />".$sSQL;exit;
		
		$pageObj	=	new Base_Paginator();
		//$data		=	$pageObj->fetchPageDataRaw($sSQL, $page, $page_size);
		$data		=	$pageObj->fetchBlogData($sSQL, $page, $page_size);
		
		$totalCount = $pageObj->getTotalCount();
		
		$this->view->data = $data;
		//echo "offset=>".$offset." totalCount=>".$totalCount;
		if($mode=="ajax")
		{
			$this->view->layout()->disableLayout();
			//if(count($data)==0)
			if($offset>=$totalCount)
			{
				$this->_helper->viewRenderer->setNoRender(true);
				exit("nodata");
			}
		}		
	}
        
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Nov-2010
	 * @Description: Used to display My Journal post added by logged in users
	 */
	public function myJournalsAction()
	{
		$this->_helper->layout->setLayout('3column-my-account');
		
		$userNs	=	new Zend_Session_Namespace('members');
		$blogm	=	new Application_Model_Blog();
		$form	=	new Application_Form_Blog();
		
		/*--- Clear Form Element Decorators ---*/
		$elements = $form->getElements();
		foreach($elements as $element)
		{
				$element->removeDecorator('data');
				$element->removeDecorator('row');
				$element->removeDecorator('label');
				$element->removeDecorator('Table');
		}
		/*----------------------------*/        		
		
		//$where	=	"user_id='{$userNs->userId}' where status='active'"; 
		$where	=	"user_id='{$userNs->userId}'";
		
		$params	=	$this->getRequest()->getPost();
		if(isset($params['searchname']) && $params['searchname']!='' && $params['searchname']!='Search Journals')
		{
			$searchname		= trim($params['searchname']);
			$this->view->searchname = $searchname;
			$where	.=	" AND title LIKE '%$searchname%'";
		}
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('journal_page_size');		
        /*------------------------- Set paging END------------------------*/
				
		$data = $blogm->fetchAll($where, "addedon DESC", $page_size);
		
		$this->view->data	=	$data;
		$this->view->form	=	$form;
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Nov-2010
	 * @Description: Used to display more post on "View More" link from My Journals section
	 */
	public function viewMorepostsAction()
	{
		$this->view->layout()->disableLayout();
		
		$userNs	=	new Zend_Session_Namespace('members');
		$blogm	=	new Application_Model_Blog();		
		$form	=	new Application_Form_Blog();
		
		/*--- Clear Form Element Decorators ---*/
		$elements = $form->getElements();
		foreach($elements as $element)
		{
				$element->removeDecorator('data');
				$element->removeDecorator('row');
				$element->removeDecorator('label');
				$element->removeDecorator('Table');
		}
		/*----------------------------*/
		
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('journal_page_size');		
        $page		= 	$this->_getParam("page");
        $offset		=	($page-1)*$page_size;
		/*------------------------- Set paging END------------------------*/	
		
		$where	=	"user_id='{$userNs->userId}' "; 
		//$where	=	"user_id='{$userNs->userId}' where status='active'"; 
		
		
		
		$search_params	=	$this->_getParam("searchname");
		if(isset($search_params) && $search_params!='' && $search_params!='Search Journals')
		{
			$searchname		= trim($search_params);
			$where	.=	" AND title LIKE '%$searchname%'";
		}
						
		$data = $blogm->fetchAll($where, "addedon DESC", $page_size, $offset);
		$this->view->data	=	$data;
		$this->view->form	=	$form;
		
		if(count($data)==0)
		{
			$this->_helper->viewRenderer->setNoRender(true);
			exit("nodata");
        }				
	}//end of function
	
    public function commentAction()
	{
		$this->view->layout()->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(true);

		$id = $this->_getParam('blogId'); 
		$objModelComment = new Application_Model_Comment();
		$condition = "item_id= {$id} AND publish='1'";
		$objComment = $objModelComment->fetchAll($condition,"addedon ASC");
		$this->view->blog_id = $id;
		$this->view->comment = $objComment;
		
		//get blog information
		$objModelBlog	= new Application_Model_Blog();
		$objModelBlog	= $objModelBlog->find($id);
		$this->view->enable_comment = $objModelBlog->getComment();
		
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->user_id = $userNs->userId;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 1-Nov-2010
	 * @Description: Used to update blog post information
	 */
	public function updateblogAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	
		$id       	= $this->_getParam('id'); 
		//$catId    = $this->_getParam('catId'); 
		//$location	= $this->_getParam('location'); 
		//$tags 	= $this->_getParam('tags');
		$catId    	= $_POST['categoryId_'.$id]; 
		$location	= $_POST['location_'.$id];
		$tags		= $_POST['tags_'.$id];
		//print_r($_POST);
		//echo "id=$id, cat=$catId, loc=$location, tag=$tags";exit;
		if($id=="")
		{
			echo "Please select the journal to edit.";
			exit;
		}
		if($catId=="")
		{
			echo "Please select the category.";
			exit;
		}
		if($location=="")
		{
			echo "Location can not be left blank.";
			exit;
		}
		$objModelBlog	= new Application_Model_Blog();
		$objModelBlog	= $objModelBlog->find($id);
		
		if(false!==$objModelBlog)
		{
			$objModelBlog->setCategoryId($catId);
			$objModelBlog->setLocation($location);
			$objModelBlog->setTags($tags);
			$resp	=  $objModelBlog->save();
			
			if($resp)
			{
				//now first delete blog tags
				$objBlogTag	= new Application_Model_BlogTag();
				$objBlogTag	= $objBlogTag->delete("blog_id='{$id}'");
				
				//insert/update tags
				if($tags !="")
				{
					$arrTags = explode(",",$tags);
					foreach($arrTags as $_tag)
					{
						$_tag	= 	trim($_tag);
						$tagsM	= 	new Application_Model_Tags();
						$tag	=	$tagsM->fetchRow("tag='{$_tag}'");
						
						if(false===$tag)
						{
							$tagsM->setTag($_tag);
							$tag_id = $tagsM->save();
						}
						else
						{
							$tag_id = $tag->getId();
						}
						$albumTagM=new Application_Model_BlogTag();
						$albumTagM->setBlogId($id);
						$albumTagM->setTagId($tag_id);
						$albumTagM->save();
					}//end foreach
				}//end if	
				
				//set confirmation message to display
                $tagsM	=	new Application_Model_Tags();
                $tagStr	=	$tagsM->getBlogTags($id, false, false);
				echo "Your journal information has been successfully updated.~###~{$tagStr}";

			}
			else
			{
				echo "Error occured. Please try again later.";
			}
		}
		else
		{
			echo "Invalid request.";
		}
		exit;		
	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 1-Nov-2010
	 * @Description: Used to delete journal post and corresponding data from database
	 */       
	public function deletePostAction()
	{
		
		$id	= $this->_getParam('blog_id');
		//$id	= base64_decode($id);
		if(isset($id))
		{
			$objBlog = new Application_Model_Blog();
			
			//added by Mahipal Adhikari on 5-jan-2011, move Blogs to deleted table before deleting permanently
			$objBlog->deleteBlog($id);
			
			//delete blog
			//$objBlog->delete("id = $id");
			
			//delete blog tags
			//$objBlogTag = new Application_Model_BlogTag();
			//$objBlogTag->delete("blog_id = $id");
			
			//delete blog comments
			//$objBlogCom = new Application_Model_Comment();
			//$objBlogCom->delete("item_type='blog' AND item_id = $id");
			
			//delete blom votes
			//$objBlogVot = new Application_Model_Vote();
			//$objBlogVot->delete("item_type='blog' AND item_id = $id");
			
			$_SESSION["flash_msg"] = "Post has been deleted successfully!";
		}
		else
		{
			$_SESSION["flash_msg"] = "Error occured please try again later.";
		}
		$this->_redirect($this->view->seoUrl('/journal/my-journals/'));
	}
	
	public function journalSettingsAction()
	{
		$this->_helper->layout->setLayout('3column-my-account');
		$this->view->siteUrl=Zend_Registry::get('siteurl');
		$request = $this->getRequest();
		
		$userNs		= new Zend_Session_Namespace('members');
		$journalM	= new Application_Model_Journal();
		
		$journal	= $journalM->fetchRow("user_id='{$userNs->userId}'");
		
		//added by Mahipal Adhikari on 24-dec-2010
		$this->view->noJournal = 0; //journal is not published
		
		if(false!==$journal)
		{
			//added by Mahipal Adhikari on 24-dec-2010
			if($journal->getPublish()=="published")
			{
				$this->view->noJournal = 1; //journal is published
			}			
			
			$this->view->userId = $userNs->userId;
			if ($this->getRequest()->isPost())
			{
				$params=$request->getParams();
				if(isset($params['save']))
				{
					$journal->setTitle($params['title']);
					$journal->setStatus($params['status']);
					if($journal->save())
					{
						//update user permission settings
						$permission_id = 4;
						$where	=	"user_id='{$userNs->userId}' AND permission_id={$permission_id}";
						$user_permission = new Application_Model_UserPermission();
						$user_permission = $user_permission->fetchRow($where);
						if(false!==$user_permission)
						{
							$user_permission->setFriendGroupId($params["friend_group_id"]);
							$user_permission->save();
						}
						$this->view->success=1;
					}
					else
					{
						$this->view->success=0;
					}
				}
				else if(isset($params['remove']))
				{
					$journal->setPublish('trash');
					if($journal->save())
					{
						$this->_helper->redirector('journal-settings','journal',"default");
					}
				}
				else if(isset($params['activate']))
				{
					$journal->setPublish('published');
					if($journal->save())
					{
						$this->_helper->redirector('journal-settings','journal',"default");
					}
				}
				else if(isset($params['view']))
				{
					//$this->_helper->redirector('my-journals','journal',"default");
					 $this->_redirect($this->view->seoUrl('/journal/my-journals/'));
				}
			}
			$this->view->title	=	$journal->getTitle();
			$this->view->status	=	$journal->getStatus();
		}
		else
		{
			$this->view->error_msg = "No Journal is found for your profile, please contact System Administrator.";
		}
	}//end of function

        public function viewPostAction()
        {
            $this->_helper->layout->setLayout('journal-layout-2column');
            $blog_id	=	$this->_getParam("blog_id");
            
			$blogM		=	new Application_Model_Blog();
            //$whereCond	=	"id={$blog_id} AND status=5 AND publish='published'";
			$whereCond	=	"id={$blog_id} AND publish='published'";
			$blog		=	$blogM->fetchRow($whereCond);
			$this->view->blog = $blog;
			
			//get logged in user session User ID
			$userNs		=	new Zend_Session_Namespace('members');
            $this->view->userId	=	$loggedin_id	=	$userNs->userId;
			
			if($blog)
			{			
				//get blog Journal public/published information
				$journalM	=	new Application_Model_Journal();
				$journalM	=	$journalM->find($blog->getJournalId());
				
				if($journalM)
				{
					$this->view->jStatus	= $jStatus	=	$journalM->getStatus();
					$this->view->jPublish	= $jPublish	=	$journalM->getPublish();
					
					if($jStatus!="public" || $jPublish!="published")
					{
						$this->view->message = "Post journal is either private or not published.";
						$this->render('error');
					}
					else
					{
						//now check logged in user connection, permission from user to logged in user
						
						$blogUserId			= $blog->getUserId();
						/*
						$userM 				= new Application_Model_User();
						$view_my_journal 	= $userM->checkUserPrivacySettings($blogUserId, $loggedin_id, 4);
						*/
						//above code is commented by Mahipal on 19-jan-2011 as we don't need to check user permissions
						
						$blogM				= new Application_Model_Blog();
						$view_my_journal	= $blogM->checkBlogPrivacySettings($blogUserId, $loggedin_id, $blog->getStatus());
						if(!$view_my_journal)
						{
							$this->view->message = "You are not authorised to view this post.";
							$this->render('error');
						}						
					}
				}
				else
				{
					$this->view->message = "Journal is either not created OR not published by user.";
					$this->render('error');
				}
			}//end of if
				
           
			//if not blog found then redirect user to Journal page
			if(false===$blog)
			{
               $this->_helper->redirector()->gotoUrl('/journal/index/');
               exit;
            }
        }

        public function userLikeThisAction()
        {
            $this->_helper->layout->setLayout('journal-layout-2column');
            //$item_id = $this->_getParam("blog_id");
			$item_id = $this->_getParam("item_id");
			$item_type = $this->_getParam("type");
            
			//$userNs = new Zend_Session_Namespace('members');
            //$this->view->userId = $userNs->userId;
			
			$item = false;
			$itemTypeText = "";
			if($item_type!="")
			{
				if($item_type=='blog')
				{
					$blogM = new Application_Model_Blog();
					$this->view->blog = $item = $blogM->find($item_id);
					$itemTypeText = "Journal Post";
				}
				if($item_type=='status_comment' || $item_type=='blog_comment')
				{
					$commentM = new Application_Model_Comment();
					$item = $commentM->find($item_id);
					$itemTypeText = "Comment";
					$item_type = "comment";
				}
				if($item_type=='status')
				{
					$wallM = new Application_Model_Wall();
					$item = $wallM->find($item_id);
					$itemTypeText = "Wall Post";
				}
				$this->view->itemTypeText = $itemTypeText;	
            }
			
			//if item is not exists then redirect to Journal home page
            if(false===$item)
			{
               $this->_helper->redirector()->gotoUrl('/journal/index/');
                exit;
            }
            
			//Now get all positive votes of item
            //$where		= "item_id = $item_id AND vote=1 AND item_type='blog'";
			$where	= "item_id = $item_id AND vote=1";
			if($item_type=='comment')
			{
				$where .= " AND (item_type='status_comment' OR item_type='blog_comment')";
			}
			else
			{
				$where .= " AND item_type='{$item_type}'";
			}
				
            $voteM		= new Application_Model_Vote();
            $rawdata 	= $voteM->fetchAll($where);
			
            //Get all users ID voted on an item
			if(false!==$rawdata)
			{
				$user_array = array();
				foreach($rawdata as $row )
				{
					$user_array[] = $row->getUserId();
				}
			}	
			
			//get all users information from above User Ids
			$this->view->totalUsers	=	0;
            if(count($user_array)>0)
            {
            	$usrstr = implode(",",$user_array);
            	$userM = new Application_Model_User();
            	$whereuser = "id IN ($usrstr) AND status='active'";
            	$userData = $userM->fetchAll($whereuser, "first_name ASC");
            	$this->view->userData = $userData;
				
				$settings	=	new Admin_Model_GlobalSettings();
				$page_size	=	$settings->settingValue('pagination_size');
				//$page_size = 1;	
				$page		=	$this->_getParam('page',1);
				$pageObj	=	new Base_Paginator();
				
				$paginator	=	$pageObj->fetchPageData($userM, $page, $page_size, $whereuser);

				$this->view->totalUsers = $pageObj->getTotalCount(); 
				$this->view->paginator	= $paginator;
            }
        }//end of function	
      
}
