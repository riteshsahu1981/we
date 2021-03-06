<?php
class ProfileController extends Base_Controller_Action
{

    public function preDispatch()
    {
        parent::preDispatch();
        $this->_helper->layout->setLayout('3column-profile-user');

        $userid = $this->_getParam('id');
			
        $userM = new Application_Model_User();
		$userObject = $userM->find($userid);
		$this->view->userObject = $userObject;
	}
	
    public function __call($method,$args)
    {   
       
    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 3-Jan-2011
	 * @Description	: Check user status, if status is deleted then redirect user to home page
	 * @Input		: int
	 * @Return		: none
	 */
	public function redirectUserAction($user_id)
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
			
		$userM = new Application_Model_User();
		if(true===$userM->checkUserActiveStatus($user_id))
		{
			return true;
			//echo "here=".$user_id;
		}
		else
		{
			$this->_helper->redirector('index','index');
		}
	}
	
	public function indexAction()
	{
		$this->_helper->layout->setLayout('3column-profile-user-where-i-am');
		$this->view->otherUserId=$this->view->userId= $userid = $this->_getParam('id');
		$userM = new Application_Model_User();
		$userM = $userM->find($userid);
		$this->view->userObject=$userM;
		
		//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
		if(false===$userM->checkUserActiveStatus($userid))
		{
			$this->_helper->redirector('index','index');
		}
			
		//get logged in user id
		$userNs 		= new Zend_Session_Namespace('members');
        $loggedin_id	= $userNs->userId;
		
		//redirect user to Where-I-Am page if viewing own profile, added by mahipal on 7-Feb-2011
		if($loggedin_id == $userid)
		{
			$this->_redirect($this->view->seoUrl('/gapper/where-i-am/'));
		}
		
		/************************ Check user Whre-I-Am privacy settings START *****************/
		$user_id		= $userid;
		//echo "user id=".$user_id." and Login id=".$loggedin_id;
			
		//now check user where-i-am privacy permissions for Whole page
		$view_profile = false;
		$userObj = new Application_Model_User();
		$view_profile = $userObj->checkUserPrivacySettings($user_id, $loggedin_id, 1);
		//if logged in user has no permission then display error page
		$renderErrorPage = false;
		if(!$view_profile)
		{
			$this->view->user_id = $user_id;
			$this->render('error');
			$renderErrorPage = true;
		}
		
		//get Where I am (Map) permission
		$view_map = false;
		$view_map = $userObj->checkUserPrivacySettings($user_id, $loggedin_id, 3);
		$this->view->view_map = $view_map;
		
		//get Travel Wall permission
		$view_travelwall = false;
		$view_travelwall = $userObj->checkUserPrivacySettings($user_id, $loggedin_id, 2);
		$this->view->view_travelwall = $view_travelwall;
		
		if($view_map==false && $view_travelwall==false && $renderErrorPage==false)
		{
			$this->view->user_id = $user_id;
			$this->render('error');
			//$this->_helper->redirector('view','profile','default', array('username' => $userM->getUsername()));
		}
		/************************ Check user privacy settings END *****************/
		
		$this->view->postWallAccess = false;
		if(false!==$userObj->getUserConnection($user_id, $loggedin_id))
		{
			$this->view->postWallAccess = true;
		}		
		
		$this->view->countryName = $userM->getCountryName();
		$this->view->cityName =    $userM->getCityName();
		$this->view->userThumb =   $userM->getThumbnail();
		$this->view->fullName =    $userM->getFirstName()." ".$userM->getLastName();

		$destinationM = new Application_Model_Destination();
		$destination = $destinationM->fetchAll();
		$this->view->destination = $destination;

		$experienceM = new Application_Model_Experiences();

		$destinationId = $this->getRequest()->getParam('destination_id');

		/*--find the current location coordinates --*/
		$gapperLocationM = new Application_Model_GapperLocation();
		$where="user_id='{$userid}'";
		$order="addedon desc";
		$gapperLocation = $gapperLocationM->fetchRow($where, $order);
		if(false==$gapperLocation)
		{
			//these are default coordinates.
			$this->view->myLongitude	=	"";
			$this->view->myLatitude		=	"";
			$this->view->myAddress		=	"";
			
			//if user have no coordinates then redirect its profile page
			$this->_helper->redirector('view','profile','default',array('username' => $userM->getUsername()));
		}
		else
		{
			$this->view->myLongitude = $gapperLocation->getLongitude();
			$this->view->myLatitude = $gapperLocation->getLatitude();
			$this->view->myAddress = $gapperLocation->getAddress();
		}
	}

    public function viewPostAction()
    {
        
    }

    public function getMyJourneyAction()
    {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $userId=$this->_getParam('userId');
        $gapperLocationM=new Application_Model_GapperLocation();
        $where="user_id='{$userId}'";
        $order="addedon desc";
        $gapperLocations=$gapperLocationM->fetchAll($where, $order);
        if(count($gapperLocations)>0)
        {
            $i=0;
            foreach($gapperLocations as $location){
                $coord[$i]['lat']=$location->getLatitude();
                $coord[$i]['lng']=$location->getLongitude();
                $coord[$i]['id']=$location->getId();
                $i++;
            }
            $arrayResult=Array('error'=>0,'coord'=>$coord);
        }
        else
        {
            $arrayResult=Array('error'=>1);
        }
        echo Zend_Json::encode($arrayResult);
    }


    /******** user profile action ***********/

    public function viewAction()
	{
            $username	= $this->_getParam('username');
            $userM		= new Application_Model_User();            
            $userRes	= $userM->getDataByUsername($username);
			$user_id 	= $userRes->getId();
			
			//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
			if(false===$userM->checkUserActiveStatus($user_id))
			{
				$this->_helper->redirector('index','index');
			}
			
			$userNs 		= new Zend_Session_Namespace('members');
			$loggedin_id	= $userNs->userId;
			//echo "user id=".$user_id." and Login id=".$loggedin_id;
			
			//now check user profile privacy permissions
			$view_profile = false;
			$view_profile = $userM->checkUserPrivacySettings($user_id, $loggedin_id, 6);
			//if logged in user has no permission then display error page
			if(!$view_profile)
			{
				//$this->view->userName = $username;
				//$this->view->error_message = "You are not authorised to view <b>".$userRes->getFirstName()." ".$userRes->getLastName()."</b>'s profile.";
				$this->view->user_id = $user_id;
				$this->render('error');
			}
			
			//only user can view own personal profile information
			$this->view->viewOwn	=	false;
			if($user_id==$loggedin_id)
			{
				$this->view->viewOwn	=	true;
			}	
			$this->view->userObject = $userRes;
    }

    public function travelWallAction()
    {
		$username = $this->_getParam('username');
		$user = $this->getLeftPanel($username);
		$this->view->userObject = $user;
		$userM = new Application_Model_User();
		
		//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
		if(false===$userM->checkUserActiveStatus($user->getId()))
		{
			$this->_helper->redirector('index','index');
		}
		
		/************************ Check user privacy settings START *****************/
		$userNs 		= new Zend_Session_Namespace('members');
		$loggedin_id	= $userNs->userId;
		$user_id		= $user->getId();
		
		//now check user profile privacy permissions
		$view_profile = false;
		$view_profile = $userM->checkUserPrivacySettings($user_id, $loggedin_id, 2);
		
		//if logged in user has no permission then display error page
		if(!$view_profile)
		{
			$this->view->user_id = $user_id;
			$this->render('error');
		}
		/************************ Check user privacy settings END *****************/	
		
		//only users friend can post on Travel Wall
		$this->view->postWallAccess = false;
		if(false!==$userM->getUserConnection($user_id, $loggedin_id))
		{
			$this->view->postWallAccess = true;
		}
		$this->view->loginUrl = "";
		$facebook = $this->view->facebook();
		if($user->getFacebookId()=="" || is_null($user->getFacebookId()))
		{
			$this->view->loginUrl = $facebook->getLoginUrl();
		}

		if ($this->getRequest()->isPost())
		{
			
			$userId = $user->getId();

			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			$params = $this->getRequest()->getParams();
			//$params['userId'] = $userId;
			
			//Added by Mahipal Adhikari on 28-Jan-2011, to save user profile id in which wall is posted and commented above
			$params['userId'] = $loggedin_id;
			$params['status']	=	nl2br($params['status']);
			$wall	=	new Application_Model_Wall($params);
			$id		=	$wall->save();
			if($id>0)
			{
				//added by mahipal on 28-jan-2011
				/********  send email to User to whom wall is submitted START *************/				
				$userM				= new Application_Model_User();
				
				//get user details who submit comment
				$user				= $userM->find($loggedin_id);
				$CommentedByName	= $user->getFirstName()." ".$user->getLastName();
				
				//get user details to whom wall is posted
				$objCommentedUser	= $userM->find($params['profileId']);
		
				$mailOptions['CommentedPersonName'] = $objCommentedUser->getFirstName();
				$mailOptions['Comment']				= $params['status'];
				$mailOptions['wall_id']				= $id;
				$mailOptions['CommentedByName']     = $CommentedByName;
				$mailOptions['email']               = $objCommentedUser->getEmail();
				
				//send email to user if not posting own profile
				if($params['profileId'] != $loggedin_id)
				{
					$mail = new Base_Mail(); 
					$mail->sendTravelWallEmail($mailOptions);
				}
				/********  send email to User to whom wall is submitted END *************/
				
				$arrayResult=Array("id"=>$id,'error'=>0);
				//insert into feeds for logged in user
				$userM=new Application_Model_User();
				$userM=$userM->find($userId);
				$feed="<b>".$userM->getFirstName()." ".$userM->getLastName()."</b> | ".$params['status']."<br>";
				$feed.="<span>1 Min ago</span> | <span>Comment</span> | <span><b>Like</b>";
				$feeds=new Application_Model_Feeds();
				$feeds->setUserId($userId);
				$feeds->setType('wall');
				$feeds->setFeed($feed);
				$feeds->save();
				// insert into feeds for friends
			}
			else
			{
				$arrayResult=Array('error'=>1);
			}	
			
			if(isset($params['facebook']))
			{
				if($user->getFacebookId()<>"" && !is_null($user->getFacebookId()))
				{
					$statusUpdate = $facebook->api('/'.$user->getFacebookId().'/feed', 'post', array('message'=> $params['status'], 'cb' => ''));
				}

			}
			echo Zend_Json::encode($arrayResult);
		}
		
		//Get last update
		$whereUser	=	"username='{$username}'";
                $arrUser	=	$userM->fetchAll($whereUser);
		$userId	=	$arrUser[0]->id;
		 
		$objModelWall	=	new Application_Model_Wall();
		
		//$whereWall	=	"active_status=1 AND user_id={$userId}";
		$whereWall	=	"active_status=1 AND user_id={$userId} AND profile_id={$userId}";
		$orderWall	=	"addedon DESC";
		$countWall	=	1;
		$offsetWall	=	0;
		$arrWall	=	$objModelWall->fetchAll($whereWall, $orderWall, $countWall, $offsetWall);

		if($arrWall)
		{
			$latestUpdates		=	$arrWall[0]->status;
			$latestupdatesDate	=	date("d F Y, g:i a",$arrWall[0]->addedon);
			
			$this->view->latestUpdates		=	$latestUpdates;
			$this->view->latestupdatesDate	=	$latestupdatesDate;
		}
    }

    public function reloadWallAction()
	{
		$this->_helper->layout->disableLayout();
		$userNs=new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId; 

		$username = $this->_getParam('username');
        $userM = new Application_Model_User();
        $user = $userM->getDataByUsername($username);
        $userId = $user->getId(); 
		$this->view->user_profile_id = $userId;

		//fetch all user friends
		/*$friendM	=	new Application_Model_Friend();
		$friends	=	$friendM->getUserFriend($userId);
		$friendStr	=	$userId;
		
		if(false!==$friends)
		{
			$friendStr	=	implode(',',$friends);
			$friendStr	=	$userId.", ".$friendStr;
		}*/
		
		$order	=	"addedon DESC";
        //$where	=	"active_status=1 AND user_id in ({$friendStr} )";
		
		$where	= "active_status=1";
		$where .= " AND (user_id={$userId} AND profile_id=0)"; //get user status
		$where .= " OR (user_id={$userId} AND profile_id={$userId})"; //get user own wall
		$where .= " OR (user_id!={$userId} AND profile_id={$userId})"; //get walls posted in users profile
		
		// Fetch all hided post id
		$WallHideUserPostM	=	new Application_Model_WallHideUserPost();
		$hidedPost			=	$WallHideUserPostM->getAllHidePostId($userId);
		if(count($hidedPost)>0)
		{
			$hidePost = implode(",", $hidedPost);
			$where .= " AND id NOT IN({$hidePost})";
		}	
		
		// Fetch all hided post user id
		$WallHideUserAllM	=	new Application_Model_WallHideUserAll();
		$hidedAllUsersPost	=	$WallHideUserAllM->getAllPosterId($userId);	
		if(count($hidedAllUsersPost)>0)
		{
			$hidedAllUsersPost = implode(",", $hidedAllUsersPost);
			$where .= " AND user_id NOT IN({$hidedAllUsersPost})";
		}
		
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('friend_page_size');
		/*------------------------- Set paging END------------------------*/
		
		$feeds	=	new Application_Model_Wall();
		$data	=	$feeds->fetchAll($where, $order, $page_size);
		$this->view->data=$data;
	}//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Dec-2010
	 * @Description: Used to display more wall on "View More" link from User Travel Wall page
	 */
	public function viewMorewallAction()
	{
		$this->view->layout()->disableLayout();
		
		//get logged in user Id
		$userNs=new Zend_Session_Namespace('members');
        $this->view->userId = $userNs->userId;
		
		//Get user Id
		$userId		= $this->_getParam('user_id');
		$this->view->user_profile_id = $userId;
		
		//fetch all user friends
		/*
		$friendM	=	new Application_Model_Friend();
		$friends	=	$friendM->getUserFriend($userId);
		$friendStr	=	$userId;
		if(false!==$friends)
		{
			$friendStr = implode(',',$friends);
			$friendStr = $userId.", ".$friendStr;
		}*/
		
		$order	=	"addedon DESC";
        //$where	=	"active_status=1 AND user_id in ({$friendStr} )";
        
		$where	= "active_status=1";
		$where .= " AND (user_id={$userId} AND profile_id=0)"; //get user status
		$where .= " OR (user_id={$userId} AND profile_id={$userId})"; //get user own wall
		$where .= " OR (user_id!={$userId} AND profile_id={$userId})"; //get walls posted in users profile
		
		// Fetch all hided post id
		$WallHideUserPostM	=	new Application_Model_WallHideUserPost();
		$hidedPost			=	$WallHideUserPostM->getAllHidePostId($userId);
		if(count($hidedPost)>0)
		{
			$hidePost = implode(",", $hidedPost);
			$where .= " AND id NOT IN({$hidePost})";
		}	
		
		// Fetch all hided post user id
		$WallHideUserAllM	=	new Application_Model_WallHideUserAll();
		$hidedAllUsersPost	=	$WallHideUserAllM->getAllPosterId($userId);	
		if(count($hidedAllUsersPost)>0)
		{
			$hidedAllUsersPost = implode(",", $hidedAllUsersPost);
			$where .= " AND user_id NOT IN({$hidedAllUsersPost})";
		}
		
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('friend_page_size');
		//$page_size	= 10;
        $page		= 	$this->_getParam("page");
        $offset		=	($page-1)*$page_size;
		/*------------------------- Set paging END------------------------*/
		
		$feeds	=	new Application_Model_Wall();
		//$data	=	$feeds->fetchAll($where, $order, $limit);
		$data 	=	$feeds->fetchAll($where, $order, $page_size, $offset);
		$this->view->data=$data;
		
		//if no record found then no need to render view and exit
		if(count($data)==0)
		{
			$this->_helper->viewRenderer->setNoRender(true);
			exit("nodata");
        }				
	}//end of function

        public function friendsAction()
        {
            $username 				= $this->_getParam('username');
            $this->view->userName 	= $username;
            $user 					= $this->getLeftPanel($username);
            $this->view->userObject = $user;
			
			$userM = new Application_Model_User();
			
			//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
			if(false===$userM->checkUserActiveStatus($user->getId()))
			{
				$this->_helper->redirector('index','index');
			}
		
            $userNs			=	new Zend_Session_Namespace("members");
			$loggedInUser	=	$userNs->userId;
			$this->view->loggedInUser	=	$loggedInUser;
			
			/************************ Check user privacy settings START *****************/
			$loggedin_id	= $loggedInUser;
			$user_id		= $user->getId();
			//echo "user id=".$user_id." and Login id=".$loggedin_id;
				
			//now check user profile privacy permissions
			$view_profile = false;
			$userObj = new Application_Model_User();
			$view_profile = $userObj->checkUserPrivacySettings($user_id, $loggedin_id, 6);
			
			//if logged in user has no permission then display error page
			if(!$view_profile)
			{
				$this->view->user_id = $user->getId();
				$this->render('error');
			}
			/************************ Check user privacy settings END *****************/
            
            $where="user_id='{$user->getId()}' AND status='accept'";

            $params = $this->getrequest()->getParams();
            $extra  = array();
			
            //search by Connection Type
			if(isset($params['searchkey']) && $params['searchkey']!='')
            {
                $key = $params['searchkey'];
                $this->view->ctype=$key;
                $where .= " AND connection_type = '$key'";
                $extra['searchkey'] = $key;
            }
			//search by Name
            if(isset($params['searchname']) && $params['searchname']!='' && $params['searchname']!='Search Names')
            {
                $userarray[] = -1;
                $searchname = trim($params['searchname']);
                $this->view->searchname=$searchname;
                $user_where_sql = "";
				$user_where_sql .= " CONCAT(first_name,' ',last_name ) LIKE '%$searchname%' || username LIKE '%$searchname%'";
				$userdata = $userM->fetchAll($user_where_sql);
                if(count($userdata)>0)
                {
					foreach($userdata as $userrow)
					{
							$userarray[] = $userrow->getId();
					}
                }
                $userstr  = implode(',',$userarray);
                $where .= " AND friend_id IN ($userstr)";

                $extra['searchname'] = $searchname;
				
				//set message if no record found
				$this->view->no_record = "Try another search to find what you're looking for.";
            }
			
			$friendM=new Application_Model_Friend();
			
			$settings=new Admin_Model_GlobalSettings();
			$page_size=$settings->settingValue('friend_page_size');
			$this->view->page_size	=	$page_size;
			//$page_size = 1;
			
			$page = $this->_getParam('page',1);
			
			$pageObj=new Base_Paginator();
			$paginator=$pageObj->fetchPageData($friendM,$page,$page_size,$where);
			$this->view->totalFriends=$pageObj->getTotalCount();
			//$this->view->paginator=$paginator;
			
			$data = $friendM->fetchAll($where, "addedon DESC", $page_size);
			$this->view->data	=	$data;
        }
		/**
		 * @Created By : Mahipal Singh Adhikari
		 * @Created On : 17-Nov-2010
		 * @Description: Used to display more friend of a user on "Show More" link from User profile page
		 */
		public function showMorefriendsAction()
		{
			$this->view->layout()->disableLayout();
			
			$username 		= $this->_getParam('username');
            $user 			= $this->getLeftPanel($username);
            
            $userNs			=	new Zend_Session_Namespace("members");
			$loggedInUser	=	$userNs->userId;
            
            $where = "user_id='{$user->getId()}' AND status='accept'";

            $params = $this->getrequest()->getParams();
            
            //search by Connection Type
			if(isset($params['searchkey']) && $params['searchkey']!='')
            {
                $key = $params['searchkey'];
                $where .= " AND connection_type = '$key'";
            }
			//search by Name
            if(isset($params['searchname']) && $params['searchname']!='' && $params['searchname']!='Search Names')
            {
                $userarray[] = -1;
                $searchname = trim($params['searchname']);
                $userM = new Application_Model_User();
                $user_where_sql = "";
				$user_where_sql .= " CONCAT(first_name,' ',last_name ) LIKE '%$searchname%' || username LIKE '%$searchname%'";
				$userdata = $userM->fetchAll($user_where_sql);
                if(count($userdata)>0)
                {
					foreach($userdata as $userrow)
					{
						$userarray[] = $userrow->getId();
					}
                }
                $userstr  = implode(',',$userarray);
                $where .= " AND friend_id IN ($userstr)";
            }
			
			$friendM = new Application_Model_Friend();
			
			/*------------------------- Set paging START------------------------*/
			$settings	=	new Admin_Model_GlobalSettings();
			$page_size	=	$settings->settingValue('friend_page_size');
			//$page_size  = 1;		
			$page		= 	$this->_getParam("page");
			$offset		=	($page-1)*$page_size;
			/*------------------------- Set paging END------------------------*/
			
			$data = $friendM->fetchAll($where, "addedon DESC", $page_size, $offset);
			if(count($data)==0)
			{
				$this->_helper->viewRenderer->setNoRender(true);
				exit("nodata");
			}
			$this->view->userName 		= $username;
			$this->view->userObject 	= $user;
			$this->view->loggedInUser	= $loggedInUser;
			$this->view->data			= $data;				
		}//end of function
    


		public function messagesAction()
		{
			$username = $this->_getParam('username');
			$user = $this->getLeftPanel($username);
			
			//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
			$userM = new Application_Model_User();
			if(false===$userM->checkUserActiveStatus($user->getId()))
			{
				$this->_helper->redirector('index','index');
			}
			//diaply username on left panel of user profile page
			$this->view->userObject = $user;

			$userNs	=	new Zend_Session_Namespace('members');
			
			$form = new Application_Form_CreateMessages();
			if($userNs->userId)
			{
				$form->getElement('toEmail')->setValue($user->getFirstName().' '.$user->getLastName());
				$form->getElement('toId')   ->setValue($user->getId());
			}
			$this->view->form=$form;

			if ($this->getRequest()->isPost())
			{
				$params= $this->getRequest()->getPost();
				
				if($form->isValid($params))
				{
					$params['status']	=	'inbox';
					//$params['fromId']	=	$userId;
					$params['fromId']	=	$userNs->userId;
					$params['parentId']	=	0;
					$messages	= new Application_Model_Message($params);
					$savemsg	= $messages->save();
					if($savemsg)
					{
						/*------------------------- NOTIFICATION EMAIL ---------------------------*/				
						$userObj		=	new Application_Model_User();
						$valTo			=	$userObj->find($params['toId']);
						$toFirstName	=	$valTo->getFirstName();
						$toLastName		=	$valTo->getLastName();
						
						$option['toName']	=	$toFirstName.' '.$toLastName;
						$option['toEmail']	=	trim($valTo->getEmail());
						$option['message']	=	$params['body'];				
						$option['messageId']=	$savemsg;						
						
						$valfrom			=	$userObj->find($userNs->userId);
						$option['fromName']	=	$valfrom->getFirstName().' '.$valfrom->getLastName();			
						
						$mail=new Base_Mail(); 
						$mail->sendNotificationMail("message_notification", $option);
						$_SESSION["flash_msg"] = "Message has been sent.";
						$form->reset();
					}
					else
					{
						$_SESSION["flash_msg"] = "Error occured while sending message, please try again later.";
					}
					//redirect user
					$this->_redirect($this->view->seoUrl('/profile/messages/username/'.$username));
				}
				$this->view->form = $form;
			}

		}//end of function

        
        private function getLeftPanel($username){
            $userM = new Application_Model_User();
            $user = $userM->getDataByUsername($username);
            return $user;
        }



    public function autoFriendNameAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$userNs = new Zend_Session_Namespace('members');
		$userId = $userNs->userId;

		$friendM = new Application_Model_Friend();

		$frienddata = $friendM->fetchAll();
		$friendids  = array();
		foreach($frienddata as $friend)
		{
			$friendids[] = $friend->getFriendId();
		}

		$q = strtolower($this->_getParam('term'));
		if (!$q) return;

		$where = "status='active'";
		//$where = "first_name like '%{$q}%' ";
		$where .= " AND (CONCAT(first_name,' ',last_name ) LIKE '%$q%' OR username LIKE '%$q%')";

		$userM=new Application_Model_User();
		$res=$userM->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row)
		{
			if(in_array($row->getId(),$friendids))
			{
				//array_push($result, array("id"=>$row->getId(), "value" => $row->getFirstName()));
				$name = $row->getFirstName()." ".$row->getLastName();
				array_push($result, array("id"=>$row->getId(), "value" => $name));
			}
		}
		echo Zend_Json::encode($result);
   	}
	/**
	 * @Modified By : Mahipal Singh Adhikari
	 * @Modified On : 4-Nov-2010
	 * @Modification: Modified to display only public and published blogs, also set eror page for journal privacy
	 */
	public function journalsAction()
	{
		$username = $this->_getParam('username');
		$user     = $this->getLeftPanel($username);
		
		//Redirect user if not active, added by Mahipal Adhikari on 3-jan-2011
		$userM = new Application_Model_User();
		if(false===$userM->checkUserActiveStatus($user->getId()))
		{
			$this->_helper->redirector('index','index');
		}
		
		$this->view->userObject = $user;

		$userNs	= new Zend_Session_Namespace('members');
		$this->view->userId = $userNs->userId;
		
		//get blog owner Journal public/published information
		if($user->getId())
		{
			$journalM	=	new Application_Model_Journal();
			$journalM	=	$journalM->fetchRow("user_id='{$user->getId()}'");
			if($journalM)
			{
				$this->view->jStatus	= $jStatus	=	$journalM->getStatus();
				$this->view->jPublish	= $jPublish	=	$journalM->getPublish();
				
				if($jStatus!="public" || $jPublish!="published")
				{
					//$this->view->userName = $username;
					$this->view->user_id = $user->getId();
					$this->view->error_message = "Journal is either private or not published by <b>".$user->getFirstName()." ".$user->getLastName()."</b>";
					$this->render('error');
				}
			}
			else
			{
				//$this->view->userName = $username;
				$this->view->user_id = $user->getId();
				$this->view->error_message = "No Journal is created by <b>".$user->getFirstName()." ".$user->getLastName()."</b>";
				$this->render('error');
			}	
		}//end of if
		
		/************************ Check user privacy settings START *****************/
		
		$loggedin_id	= $userNs->userId;
		$user_id		= $user->getId();
		/*	
		//now check user journal privacy permissions
		$view_profile = false;
		$userObj = new Application_Model_User();
		$view_profile = $userObj->checkUserPrivacySettings($user_id, $loggedin_id, 4);
		
		//if logged in user has no permission then display error page
		if(!$view_profile)
		{
			$this->view->user_id = $user->getId();
			$this->render('error');
		}*/
		$view_profile = true; //above code is commented by Mahipal on 19-jan-2011 as we don't need to check user permissions
		/************************ Check user privacy settings END *****************/
		
		$settings	= new Admin_Model_GlobalSettings();
        $page_size	= $settings->settingValue('journal_page_size');
				
		$blogm	= new Application_Model_Blog();
		
		//get shared blog post from this user
		$loggedin_id	= $userNs->userId;
		$user_id		= $user->getId();
		$getSharedBlogs = $blogm->getUserSharedBlogs($user_id, $loggedin_id);
		//echo "ssss=>".$getSharedBlogs;
		$whereCond = "user_id='{$user->getId()}' AND status IN {$getSharedBlogs} AND publish='published'";
		$data		= $blogm->fetchAll($whereCond, "addedon DESC", $page_size);
		$this->view->data=$data;
		$this->view->userName = $username;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 4-Nov-2010
	 * @Description: Display more post on "View More" link from User Journals section
	 */
	public function viewMorejournalsAction()
	{
		$this->view->layout()->disableLayout();
		
		$username = $this->_getParam('username');
		$user     = $this->getLeftPanel($username);

		$this->view->userObject = $user;

		$userNs	= new Zend_Session_Namespace('members');
		$this->view->userId=$userNs->userId;		
		
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('journal_page_size');
		//$page_size	=	1;		
        $page		= 	$this->_getParam("page");
        $offset		=	($page-1)*$page_size;
		/*------------------------- Set paging END------------------------*/	
		
		$where	=	"user_id='{$userNs->userId}'"; 
		
		$blogm	= new Application_Model_Blog();
		
		//get shared blog post from this user
		$loggedin_id	= $userNs->userId;
		$user_id		= $user->getId();
		$getSharedBlogs = $blogm->getUserSharedBlogs($user_id, $loggedin_id);
		//echo "ssss=>".$getSharedBlogs;
		
		$whereCond = "user_id='{$user->getId()}' AND status IN {$getSharedBlogs} AND publish='published'";
		$data = $blogm->fetchAll($whereCond, "addedon DESC", $page_size, $offset);
		$this->view->data	=	$data;
		
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
	   $objComment = $objModelComment->fetchAll("item_id= {$id}","addedon ASC");
	   $this->view->comment = $objComment; 
	   
	}

        /*
         * Ravinesh Raj
         */
        
        public function photosAction()
        {
                $objModelUser       = new Application_Model_User();
                $objModelAlbum      = new Album_Model_Album();
                $objModelPhotoTag   = new Album_Model_PhotoTag();
		$objModelSetting    = new Admin_Model_GlobalSettings();
		$objPage            = new Base_Paginator();
                /*---------------------------------------------*/
                $username = $this->_getParam('username');
                $user = $this->getLeftPanel($username);
                $this->view->userName = $username;
                $this->view->userObject = $user;

                $userRecord	= $objModelUser->getDataByUsername($username);
                $userId = $userRecord->getId();
                $this->view->user_id = $userId;

                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUser = $userNs->userId;

                $relationCondition = $this->checkRelation($userId,$loggedInUser);
                $this->view->relationCondition = $relationCondition;
		
                $this->view->userFullName = $username;
		/*----------- GET ALBUM WITH PAGINATION VALUE --------------------*/
		$pageSize	=	$objModelSetting->settingValue('album_page_size');

		$page		=	$this->_getParam('page',1);

		$whereAlbum	=	"status=1 AND user_id='{$userId}' AND ($relationCondition)";

		$orderAlbum	=	"addedon DESC";

		$arrAlbum	=	$objPage->fetchPageData($objModelAlbum, $page, $pageSize, $whereAlbum, $orderAlbum);

		$this->view->totalAlbum	=	$objPage->getTotalCount();

		$this->view->arrAlbum	=	$arrAlbum;
		/*---------------------- GET ALL TAGGED PHOTO WHERE I AM ----------------------*/

               $this->getTaggedImageOfUser($userId, $username, $relationCondition);
		/*---------------------- GET USED PHOTO SIZE OF USER --------------------------*/
		$arrAlbumCapacity = $objModelAlbum->albumCapacity($userId);
		$this->view->capacityImage	=	$arrAlbumCapacity[0];
		$this->view->capacityPercent=	$arrAlbumCapacity[1];
        }

        public function albumPhotosAction()
	{
                $objModelUser = new Application_Model_User();
                $objModelAlbumPhoto = new Album_Model_AlbumPhoto();
                $objModelAlbum = new Album_Model_Album();
                $objModelSetting = new Admin_Model_GlobalSettings();
                $objModelVote =	new Application_Model_Vote();
		$objPage = new Base_Paginator();
            /*---------------------------------------------*/
                $username = $this->_getParam('username');
                $user = $this->getLeftPanel($username);
                $this->view->userName = $username;
                $this->view->userObject = $user;

                $userRecord	= $objModelUser->getDataByUsername($username);
                $userId = $userRecord->getId();

                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUserId = $userNs->userId;
                $this->view->userFullName = $username;
           /*------------------------ CHECK RELATION -------------*/
                $relationCondition = $this->checkRelation($userId,$loggedInUserId);
                $this->view->relationCondition = $relationCondition;
          /*-------------------------------------------------*/
		$albumId = $this->_getParam('id');
		
                $this->view->userId =	$userId;
                $this->view->albumId =	$albumId;
                
        /*----------- GET ALBUM WITH PAGINATION VALUE --------------------*/
		$pageSize = $objModelSetting->settingValue('album_photo_page_size');

		$page =	$this->_getParam('page',1);

		$whereAlbumPhoto = "album_id='{$albumId}' AND user_id='{$userId}' AND status=1 AND ($relationCondition)";

		$orderAlbumPhoto = "addedon DESC";

		$arrAlbumPhoto = $objPage->fetchPageData($objModelAlbumPhoto, $page, $pageSize, $whereAlbumPhoto, $orderAlbumPhoto);

		$this->view->totalAlbumPhoto = $objPage->getTotalCount();

		$this->view->arrAlbumPhoto = $arrAlbumPhoto;
		/*------------------- GET ALBUM DETAIL --------------------------*/
		$whereAlbum = "id='{$albumId}'";
		$arrAlbum = $objModelAlbum->fetchAll($whereAlbum);
		$this->view->arrAlbum =	$arrAlbum;

                $this->view->myLatitude = $latitude = $arrAlbum[0]->latitude;
		$this->view->myLongitude = $longitude =	$arrAlbum[0]->longitude;

		/*------------------- GET TAG OF ALBUM -------------------------*/
		$strTag = $this->getAlbumTags($albumId);
		$this->view->strTag = $strTag;
		/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/
		$whereVote = "item_type='album' AND item_id='{$albumId}' AND user_id='{$loggedInUserId}' AND vote='1'";
                $arrVote = $objModelVote->fetchAll($whereVote);

                if(count($arrVote) > 0){
                        $this->view->numVote = 1;
                }else{
                        $this->view->numVote = 0;
                }

              $this->view->likeSrcUrl = Zend_Registry::get('siteurl')."%2Fprofile%2Falbum-photos%2Fusername%2F".$username."%2Fid%2F".$albumId;
	}

        public function photoAction()
	{
            $photoId = $this->_getParam('id');
            $albumId = $this->_getParam('album');

            $objModelUser = new Application_Model_User();
            /*---------------------------------------------*/
                $username = $this->_getParam('username');
                $user = $this->getLeftPanel($username);
                $this->view->userName = $username;
                $this->view->userObject = $user;

                $userRecord	= $objModelUser->getDataByUsername($username);
                $userId = $userRecord->getId();

                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUserId = $userNs->userId;
                $this->view->userFullName = $username;
                $this->view->userId = $userId;
          /*----------------------------------*/
                $relationCondition = $this->checkRelation($userId,$loggedInUserId);
                $this->view->relationCondition = $relationCondition;
           
            $this->getPhotoInfo($photoId, $userId, $albumId);
	}

        public function likeAlbumAction()
	{
		$this->_helper->layout()->disableLayout();

		$arrPostVal	=	$this->getRequest()->getParams();

		$usersNs	=	new Zend_Session_Namespace("members");

		$item_id	=	$arrPostVal['album_id'];
		$item_type	=	$arrPostVal['item_type'];

                $this->view->album_id = $item_id;

		$id =	$this->like($item_id, $item_type);
	}
        
        public function unlikeAlbumAction()
	{
		$this->_helper->layout()->disableLayout();

		$arrPostVal	=	$this->getRequest()->getParams();

		$item_id	=	$arrPostVal['album_id'];
		$item_type	=	$arrPostVal['item_type'];

                $this->view->album_id = $item_id;

                $this->unlike($item_id, $item_type);
        }

        public function albumDownloadAction()
        {
            $this->_helper->layout()->disableLayout();

            $albumId = $this->_getParam('id');
            $this->view->albumId = $albumId;

            /*---------------------------------------------------------*/
                $objModelUser = new Application_Model_User();
                $username = $this->_getParam('username');
                $user = $this->getLeftPanel($username);
                $this->view->userName = $username;
                $this->view->userObject = $user;

                $userRecord	= $objModelUser->getDataByUsername($username);
                $userId = $userRecord->getId();
                $this->view->userId = $userId;

        }

        public function archiveAction()
        {
            $arrPostVal	= $this->getRequest()->getParams();

            $albumId = $arrPostVal['albumId'];
            $userId = $arrPostVal['userId'];
            $usersNs = new Zend_Session_Namespace("members");

            $userName = $usersNs->userUsername;
            $loggedInUserId = $usersNs->userId;
            /*------------------------ CHECK RELATION -------------*/
               $relationCondition = $this->checkRelation($userId,$loggedInUserId);
                $this->view->relationCondition = $relationCondition;
            /*-----------------------------------------------------*/

            $fileName = PUBLIC_PATH.'/tmp/'.$userName.'.zip';

            $downloadPath = '/tmp/'.$userName.'.zip';

            $folderPath = PUBLIC_PATH.'/tmp/'.$userName;

           $this->deleteDirectory($folderPath); // Remove Folder if exist

            if(is_file($fileName)){
                unlink($fileName);
            }

            mkdir($folderPath, 0777);

            $objModelAlbumPhoto = new Album_Model_AlbumPhoto();

            $whereAlbumPhoto = "album_id='{$albumId}' AND ($relationCondition)";

            $arrAlbumPhoto = $objModelAlbumPhoto->fetchAll($whereAlbumPhoto);

           foreach($arrAlbumPhoto as $albumPhoto)
           {
               $filePath = PUBLIC_PATH."/media/album/default/".$albumPhoto->image;
               $targetPath = $folderPath."/".$albumPhoto->image;

               $fileTransfer = Base_Image_PhpThumbFactory ::create($filePath);

               $fileTransfer->save($targetPath);
           }
               set_time_limit(0);
               $filter = new Zend_Filter_Compress(array(
                        'adapter' => 'zip',
                        'options' => array(
                        'archive' => $fileName
                        ),
                    ));

                $compressed = $filter->filter($folderPath);


                print $downloadPath;

                exit;
        }

        public function photoSlideAction()
	{
		$this->_helper->layout()->disableLayout();

		$arrPostVal = $this->getRequest()->getParams();

		$photoId = $arrPostVal['photoId'];
                $viewerId = $arrPostVal['viewerId'];

                $objModelUser = new Application_Model_User();
                $valUser = $objModelUser->find($viewerId);
                $this->view->userName = $valUser->getUsername();

		$this->getPhotoInfo($photoId, $viewerId);
	}

        public function taggedPhotoAction()
        {
                $photoId	=	$this->_getParam('id');

                $objModelUser = new Application_Model_User();
            /*---------------------------------------------*/
                $username = $this->_getParam('username');
                $user = $this->getLeftPanel($username);
                $this->view->userName = $username;
                $this->view->userObject = $user;

                $userRecord	= $objModelUser->getDataByUsername($username);
                $userId = $userRecord->getId();

                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUserId = $userNs->userId;
                $this->view->userFullName = $username;
                $this->view->userId = $userId;
          /*-------------------------------------------------*/

            $this->getTaggesPhotoInfo($photoId, $userId);
        }

        public function photoSlideTaggedAction()
	{
		$this->_helper->layout()->disableLayout();

		$arrPostVal = $this->getRequest()->getParams();

		$photoId = $arrPostVal['photoId'];

                $viewerId = $arrPostVal['viewerId'];
                $objModelUser = new Application_Model_User();
                $valUser = $objModelUser->find($viewerId);
                $this->view->userName = $valUser->getUsername();

		$this->getTaggesPhotoInfo($photoId,$viewerId);

	}

        public function getTaggesPhotoInfo($photoId, $userId)
	{
		$objModelAlbumPhoto = new Album_Model_AlbumPhoto();
		$objModelVote = new Application_Model_Vote();
                $objModelPhotoTag = new Album_Model_PhotoTag();

                /*--------- START CHECK NEXT TAGGED IMAGE EXIST OR NOT ---------------*/
                $whereTaggedPhoto = "photo_id='{$photoId}'";
                $arrTaggedPhoto	=	$objModelPhotoTag->fetchRow($whereTaggedPhoto);
                
                /*--------- END CHECK NEXT TAGGED IMAGE EXIST OR NOT ---------------*/
		$arrPhotoIds	=	array();

		$valAlbumPhoto	=	$objModelAlbumPhoto->find($photoId);

		$this->view->photo	=	$valAlbumPhoto->getImage();
		$this->view->name	=	$valAlbumPhoto->getName();
		$this->view->caption	=	stripslashes($valAlbumPhoto->getCaption());
		$this->view->location	=	$valAlbumPhoto->getLocation();
		$this->view->permission	=	$valAlbumPhoto->getPermission();

		$albumId	=	$valAlbumPhoto->getAlbumId();

		$this->view->myLatitude		=	$latitude	=	$valAlbumPhoto->getLatitude();
		$this->view->myLongitude	=	$longitude	=	$valAlbumPhoto->getLongitude();

		$this->getAlbumInfo($albumId);	// Get album info

		$this->view->albumId	=	$albumId;

		$this->view->photoId	=	$photoId;
	/*------------------------- CHECK RELATION ------------------------------*/
                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUserId = $userNs->userId;

                $relationCondition = $this->checkRelation($userId,$loggedInUserId);
                $this->view->relationCondition = $relationCondition;
	/*-----------------------------------------------------------------------*/

                $db = Zend_Registry::get('db');

                $where="tagged_id='{$userId}' AND ($relationCondition)";

                $query  =   $db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image","ap.id"))
                ->where($where)
                ->order(array('pt.created DESC'));

                $recordSet  =   $db->query($query);
                $arrRecord  =   $recordSet->fetchAll();
                $this->view->numRecord = $numRecord=count($arrRecord);

                foreach ($arrRecord as $photo)
		{
			$arrPhotoIds[]	=	$photo->id;
		}

                $position = array_search($photoId, $arrPhotoIds);

                $nextPosition	=	$position+1;
		$prevPosition	=	$position-1;
                $arrSize	=	count($arrPhotoIds);

                $this->view->photoPosition	=	$nextPosition;

		$this->view->numPhotoAlbum	=	$arrSize;

                if(array_key_exists($nextPosition, $arrPhotoIds))
		{
			$this->view->nextId	=	$arrPhotoIds[$nextPosition];
		}else{
			$this->view->nextId	=	$arrPhotoIds[0];
		}

		if(array_key_exists($prevPosition, $arrPhotoIds))
		{
			$this->view->prevId	=	$arrPhotoIds[$prevPosition];
		}else{
			$this->view->prevId	=	$arrPhotoIds[$arrSize-1];
		}

	/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/

		$whereVote	=	"item_type='album_photo' AND item_id='{$photoId}' AND user_id='{$loggedInUserId}' AND vote='1'";
                $arrVote	=	$objModelVote->fetchAll($whereVote);
            if(count($arrVote) > 0){
                    $this->view->numVote	=	1;
            }else{
                    $this->view->numVote	=	0;
            }
             
		/*----------------- GET ALL TAGE FOR PHOTO -------------------------*/
		$objAlbumPhotoTag = new Album_Model_AlbumPhotoTag();
		$objTag = new Application_Model_Tags();

		$allTagId = $objAlbumPhotoTag->fetchAll("photo_id='{$photoId}'");
		$tagStr = "";
		foreach($allTagId as $tagId)
		{
			$valTag = $objTag->find($tagId->tagId);
			$tagStr .= $valTag->getTag();
		}

		$this->view->tagStr = $tagStr;

                /*---------------------------------------------*/
                 $objModelUser = new Application_Model_User();
                 $valUser = $objModelUser->find($userId);
                 $frienUserName = $valUser->getUsername();
                /*---------------------------------------------*/

                 $this->view->likeSrcUrl = Zend_Registry::get('siteurl')."%2Fprofile%2Ftagged-photo%2Fusername%2F".$frienUserName."%2Fid%2F".$photoId;

	}

        public function getPhotoInfo($photoId, $userId=NULL, $albumId=NULL)
	{
		$objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
		$objModelVote		=	new Application_Model_Vote();
        /*------------------------- CHECK RELATION ------------------------------*/
                $userNs = new Zend_Session_Namespace('members');
                $this->view->loggedInUserId = $loggedInUserId = $userNs->userId;

                $relationCondition = $this->checkRelation($userId,$loggedInUserId);
                $this->view->relationCondition = $relationCondition;
	/*-----------------------------------------------------------------------*/
                $wherePhoto = "id='{$photoId}' AND ($relationCondition)";
		$arrPhotoIds	=	array();		
                $valAlbumPhoto	=	$objModelAlbumPhoto->fetchAll($wherePhoto);

                if(!empty($valAlbumPhoto))
                {
                    $this->view->photo	= $valAlbumPhoto[0]->image;
                    $this->view->name	= $valAlbumPhoto[0]->name;
                    $this->view->caption	= stripslashes($valAlbumPhoto[0]->caption);
                    $this->view->location	= $valAlbumPhoto[0]->location;
                    $this->view->permission	= $valAlbumPhoto[0]->permission;

                    $albumId = $valAlbumPhoto[0]->albumId;

                    $this->view->myLatitude	= $latitude = $valAlbumPhoto[0]->latitude;
                    $this->view->myLongitude = $longitude = $valAlbumPhoto[0]->longitude;
                }else{
                    $this->view->imageNotExist = 1;
                }

		$this->getAlbumInfo($albumId);	// Get album info

		$this->view->albumId	=	$albumId;

		$this->view->photoId	=	$photoId;

                $objModelUser = new Application_Model_User();
                $valUser = $objModelUser->find($userId);
                $frienUserName = $valUser->getUsername();

                $this->view->likeSrcUrl = Zend_Registry::get('siteurl')."%2Fprofile%2Fphoto%2Fusername%2F".$frienUserName."%2Falbum%2F".$albumId."%2Fid%2F".$photoId;
        

		$whereAlbumPhoto	=	"album_id='{$albumId}' AND status='1' AND ($relationCondition)";
		$orderAlbumPhoto	=	"addedon DESC";

		$arrAlbumPhoto		=	$objModelAlbumPhoto->fetchAll($whereAlbumPhoto, $orderAlbumPhoto);

		foreach ($arrAlbumPhoto as $photo)
		{
			$arrPhotoIds[]	=	$photo->id;
		}

		$position = array_search($photoId, $arrPhotoIds);

		$nextPosition	=	$position+1;
		$prevPosition	=	$position-1;
		$arrSize    =	count($arrPhotoIds);

		$this->view->photoPosition	=	$nextPosition;

		$this->view->numPhotoAlbum	=	$arrSize;

		if(array_key_exists($nextPosition, $arrPhotoIds))
		{
			$this->view->nextId	=	$arrPhotoIds[$nextPosition];
		}else{
                    if(isset($arrPhotoIds[0]))
                    {
			$this->view->nextId	=	$arrPhotoIds[0];
                    }
		}

		if(array_key_exists($prevPosition, $arrPhotoIds))
		{
			$this->view->prevId	=	$arrPhotoIds[$prevPosition];
		}else{
                    if(isset($arrPhotoIds[$arrSize-1]))
                    {
			$this->view->prevId	=	$arrPhotoIds[$arrSize-1];
                    }
		}

	/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/               

	$whereVote = "item_type='album_photo' AND item_id='{$photoId}' AND user_id='{$loggedInUserId}' AND vote='1'";
        $arrVote = $objModelVote->fetchAll($whereVote);
            if(count($arrVote) > 0){
                    $this->view->numVote	=	1;
            }else{
                    $this->view->numVote	=	0;
            }

	}

        public function getAlbumInfo($albumId)
	{
		$objModelAlbum	=	new Album_Model_Album();

		$valAlbum	=	$objModelAlbum->find($albumId);

		$albumName	=	$valAlbum->getName();
		$albumDesc	=	$valAlbum->getDescription();

		$this->view->albumName	=	$albumName;
		$this->view->description=	stripslashes($albumDesc);
	}

        function like($item_id, $item_type)
	{
		$objModelVote =	new Application_Model_Vote();

		$usersNs = new Zend_Session_Namespace("members");

                $userId	= $usersNs->userId;

                $whereVote = "item_type='{$item_type}' AND item_id='{$item_id}' AND user_id='{$userId}'";
                $arrVote = $objModelVote->fetchAll($whereVote);

                if(count($arrVote) > 0)
                {
                        $option['id'] =	$arrVote[0]->id;
                }
        	$option['vote'] = 1;
	        $option['itemType'] = $item_type;
	        $option['itemId'] = $item_id;
	        $option['addedon'] = time();
	        $option['updatedon'] = time();
	        $option['userId'] = $userId;
        	$objModelVote->setOptions($option);
	        $id = $objModelVote->save();
	        return $id;
	}

        function unlike($item_id, $item_type)
	{
		$objModelVote =	new Application_Model_Vote();

		$usersNs = new Zend_Session_Namespace("members");

                $userId	= $usersNs->userId;

                $whereVote = "item_type='{$item_type}' AND item_id='{$item_id}' AND user_id='{$userId}'";
                $arrVote = $objModelVote->fetchAll($whereVote);

		if(count($arrVote) > 0)
                {
                    $option['id'] = $arrVote[0]->id;
                }

                $option['vote']	= -1;
                $option['itemType'] = $item_type;
                $option['itemId'] = $item_id;
                $option['addedon'] = time();
                $option['updatedon'] = time();
                $option['userId'] = $userId;

                $objModelVote->setOptions($option);
                $id = $objModelVote->save();

                return $id;
	}

        public function getTaggedImageOfUser($userId, $username, $relationCondition)
        {
            $tag_page   =   $this->_getParam('tag_tage',1);
            $limit      =   12;
            $offset     =   $tag_page*$limit-$limit;

            $db = Zend_Registry::get('db');
                $where="tagged_id='{$userId}' AND ($relationCondition)";
                // Joining photo_tag, album_photo
                $select = $db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image"))
                ->where($where)
                ->order(array('created DESC'))
                ->limit($limit, $offset);

                $stmt = $db->query($select);

                $this->view->arrTaggedUser  =   $stmt->fetchAll();
                /*------------------------------------------------*/
                $query=$db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image"))
                ->where($where);

                $recordSet = $db->query($query);
                $arrRecord=$recordSet->fetchAll();
                $this->view->numRecord=$numRecord=count($arrRecord);
                /*------------------------------------------------*/
                $this->view->numPages   =   $numPages   =  ceil($numRecord/$limit);

                $nextPage   =   $tag_page+1;
                $prevPage   =   $tag_page-1;

                if($nextPage > $numPages){
                    $nextLink   =   "&gt;";
                }else{
                    $nextLink   =   "<a href='/profile/photos/username/{$username}/tag_tage/{$nextPage}'>&gt;</a>";
                }

                if($prevPage < 1){
                    $prevLink   =   "&lt;";
                }else{
                    $prevLink   =   "<a href='/profile/photos/username/{$username}/tag_tage/{$prevPage}'>&lt;</a>";
                }

                if($numPages == 0){$numPages++;};
                $pagingStr  =   "<span class='pages'>Page $tag_page of $numPages <span class='red-pagination'> $prevLink $nextLink </span></span>";

               // "";

                $this->view->pagingStr  =   $pagingStr;

        }

        public function getAlbumTags($albumId)
	{
		$objModelAlbumTag = new Album_Model_AlbumTag();
		$objModelTag = new Application_Model_Tags();

		$whereAlbumTag = "album_id='{$albumId}'";
		$arrTagId = $objModelAlbumTag->fetchAll($whereAlbumTag);

		$strTag	= "";
		if(!empty($arrTagId))
		{
			foreach($arrTagId as $tagId)
			{
				$tId = $tagId->tagId;

				$valTag	= $objModelTag->find($tId);

				$strTag	= $strTag.','.$valTag->getTag();
			}
			$strTag	= substr($strTag, 1, strlen($strTag));
		}
		return $strTag;
	}

        public function checkRelation($userId, $loggedinUserId)
        {
            
            $objModelUser = new Application_Model_User();

            $strPermission = "permission='5'";
            if($loggedinUserId != "")
            {
                $strPermission .= " OR permission='1'";
            }
            $relation = $objModelUser->getUserConnection($userId, $loggedinUserId);

                        switch ($relation)
                        {
                            case 'friend':
                                $strPermission .= " OR permission='2' OR  permission='6'";
                            break;
                            case 'own':
                                $strPermission .= " OR permission='2' OR  permission='3' OR  permission='4'";
                            break;
                            case 'family':
                                $strPermission .= " OR permission='3' OR  permission='6'";
                            break;
                        }

               return $strPermission;
        }

         public function deleteDirectory($dir)
        {
            $mydir = $dir."/";
            if (!file_exists($dir)) return true;

            $d = dir($mydir);
            while($entry = $d->read())
            {
                if ($entry!= "." && $entry!= "..")
                {
                    unlink($mydir."/".$entry);
                }
            }
            $d->close();
            rmdir($mydir);
            return true;
        }        

        
}//end of class
