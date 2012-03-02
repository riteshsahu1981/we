<?php
class GapperController extends Base_Controller_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        $this->_helper->layout->setLayout('3column-my-account');
        $blockM=new Base_View_Block();
        $path="/layouts/scripts/page/blocks/myaccount";
        $blocks=array("name"=>"weather", "order"=>"11", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

        $blocks=array("name"=>"time", "order"=>"9", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

         $blocks=array("name"=>"adv", "order"=>"8", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

        $blocks=array("name"=>"people", "order"=>"7", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

        $blocks=array("name"=>"whats-going-on", "order"=>"6", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

        $blocks=array("name"=>"journal", "order"=>"5", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');
        $blocks=array("name"=>"request", "order"=>"7", "path"=>$path);
        $blockM->addBlock($blocks, 'myaccount');

    }

	public function journalSettingsAction()
	{
		$this->view->siteUrl=Zend_Registry::get('siteurl');
		$request = $this->getRequest();
		if ($this->getRequest()->isPost()) 
		{
			$params=$request->getParams();
			if($params['title']<>""){
						$userNs=new Zend_Session_Namespace('members');
			$params['userId']=$userNs->userId;
			$params['journalId']=1;
			}
		}
	}
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 26-Oct-2010
	 * @Description	: Used to display list of friend requests sent by user
	 * 
	 * @Modified By	: Mahipal Singh Adhikari
	 * @Modified On	: 22-dec-2010
	 * @Modification: Modified code to display both incoming & Outgoing requests i.e. all friend requests Received/Sent
	 **/
	public function requestsAction()
	{
		$blockM	=	new Base_View_Block();
		$blockM->removeBlock("weather", "myaccount");
		$blockM->removeBlock("time","myaccount");
		$blockM->removeBlock("whats-going-on","myaccount");
		$blockM->removeBlock("journal","myaccount");
		
		$userNs	=	new Zend_Session_Namespace("members");
		
		$friendM	=	new Application_Model_Friend();
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('friend_page_size');
		//$page_size  =	1;
		
		/************** Received friend request START ********************/
		//set search conditions
		$where	=	"friend_id='{$userNs->userId}'";
		$where .= " AND status='pending'";
		 
		$reqReceived =	$friendM->fetchAll($where, "addedon DESC",$page_size);
		$this->view->reqReceived = $reqReceived;
		/************** Received friend request END ********************/
		
		/************** Sent friend request START ********************/
		//set search conditions
		$where	=	"user_id='{$userNs->userId}'";
		$where .= " AND (status='decline' OR status='pending')";
		
		$reqSent =	$friendM->fetchAll($where, "addedon DESC",$page_size);
		$this->view->reqSent = $reqSent;
		/************** Sent friend request END ********************/
	}
	/**
	 * @Created By: Mahipal Singh Adhikari
	 * @Created On: 23-Dec-2010
	 * @Description: Used to display friends requests received by user
	 **/
	public function requestReceivedAction()
	{
		$mode = $this->_getParam("mode");
		
		$userNs	=	new Zend_Session_Namespace("members");
		$where	=	"friend_id='{$userNs->userId}'";
		$where .= " AND status='pending'";
		 
		$friendM	= new Application_Model_Friend();
		$settings	= new Admin_Model_GlobalSettings();
		$page_size	= $settings->settingValue('friend_page_size');
		//$page_size  = 1;	
		$page		= $this->_getParam('page1');
		$offset		= ($page-1)*$page_size;
		
		$reqReceived =	$friendM->fetchAll($where, "updatedon DESC",$page_size, $offset);
		$this->view->reqReceived = $reqReceived;
		
		if($mode=="ajax")
		{
			$this->view->layout()->disableLayout();
			if(count($reqReceived)==0)
			{
				$this->_helper->viewRenderer->setNoRender(true);
				exit("nodata");
			}
		}
	}
	/**
	 * @Created By: Mahipal Singh Adhikari
	 * @Created On: 23-Dec-2010
	 * @Description: Created to display friends requests sent by user
	 **/
	public function requestSentAction()
	{
		$mode = $this->_getParam("mode");
		
		$userNs	=	new Zend_Session_Namespace("members");
		$where	=	"user_id='{$userNs->userId}'";
		$where .= " AND (status='decline' OR status='pending')";
		 
		$friendM	= new Application_Model_Friend();
		$settings	= new Admin_Model_GlobalSettings();
		$page_size	= $settings->settingValue('friend_page_size');
		//$page_size  = 1;	
		$page		= $this->_getParam('page2');
		$offset		= ($page-1)*$page_size;
		
		$reqSent =	$friendM->fetchAll($where, "updatedon DESC",$page_size, $offset);
		$this->view->reqSent = $reqSent;
		
		if($mode=="ajax")
		{
			$this->view->layout()->disableLayout();
			if(count($reqSent)==0)
			{
				$this->_helper->viewRenderer->setNoRender(true);
				exit("nodata");
			}
		}
	}
	/**
	 * @Created By: Mahipal Singh Adhikari
	 * @Created On: 26-Oct-2010
	 * @Description: Used to remove a request sent by user
	 **/
	public function removeRequestsAction()
	{
		$id=$this->getRequest()->getParam('id');
		$friendm = new Application_Model_Friend();
		$friendm->delete("id = $id");
		$this->_redirect('/gapper/requests/msg/success');
	}

	/**
	 * @Created By: Mahipal Singh Adhikari
	 * @Created On: 26-Oct-2010
	 * @Description: Created to re-send friend request
	 **/
	public function resendRequestAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$id			=	$this->getRequest()->getParam('id');
		$status		=	$this->getRequest()->getParam('status');
		
		$params['id']		=	$id;
		$params['status']	=	$status;
		
		$response	= "";
		$response	= "<span style='color:#EF4733;'>";
		
		$friend		= "";
		$friendm	= new Application_Model_Friend();
		$friendm	= $friendm->find($id);
		if(false!==$friendm)
		{
			$friendm->setStatus($status);
			$addedon = time();
		    $friendm->setAddedon($addedon);
			$friend	=  $friendm->save();
		
			if($friend)
			{
				//send friend request email to user
				$userObj	= new Application_Model_User();
				$userId		= $friendm->getUserId();
				$friendId	= $friendm->getFriendId();
				$connectionType = $friendm->getConnectionType();
				
				//get sender information
				$Sender   = $userObj->find($userId);
				$mailOptions['sender_email']= $Sender->getEmail();
				$mailOptions['sender_name']	= ucwords($Sender->getFirstName()).' '.ucwords($Sender->getLastName());
				
				//get receiver information
				$Receiver   = $userObj->find($friendId);
				$mailOptions['receiver_email']	= $Receiver->getEmail();
				$mailOptions['receiver_name']	= ucwords($Receiver->getFirstName()).' '.ucwords($Receiver->getLastName());
				$mailOptions['con_type']		= ucwords($connectionType);
				
				//create mail class object and send the email
				$Mail	=	new Base_Mail();
				$Mail->sendFriendRequest($mailOptions);
					
				//set confirmation message to display
				$response .= "Friend request has been sent.";
			}
			else
			{
				$response .= "Error occured. Please try again later.";
			}
		}
		else
		{
			$response .= "Invalid request";
		}
		$response	.= "</span>";
		//sleep(5);
		echo $response;
		exit;
	}
	/**
	 * @Created By: Mahipal Singh Adhikari
	 * @Created On: 27-Oct-2010
	 * @Description: Used to display all pending friend requests received by user
	 **/
	public function viewAllRequestsAction()
	{
		$userNs	=	new Zend_Session_Namespace("members");
		
		//set search conditions
		$where	=	"friend_id='{$userNs->userId}'";
		$where .= " AND status='pending'";
		 
		$friendM	=	new Application_Model_Friend();
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
			
		$page=$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		
		$paginator	=	$pageObj->fetchPageData($friendM, $page, $page_size, $where);

		$this->view->totalFriends=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
	}

public function checkAction()
{
 
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	
	 $db=Zend_Registry::get('db');        
    // $select = $db->select($db);
     $aa="select*from temp where id='1'";
	 $db->query($aa);     
     echo "record submitted";
}

public function phpinfoAction()
{
	$filter=new Base_Filter_AddSlashes();echo get_magic_quotes_gpc();
	$str="ritesh's";
	echo $str=$filter->filter($str);
	exit;
	//phpinfo();exit;
}

public function excelAction()
{
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);

	print "<pre>";
	
	$filter=new Base_Filter_AddSlashes();
	$filename = "data/destinationlist.xls";

	$objPHPExcel = Base_Excel_PHPExcel_IOFactory::load($filename);

	set_time_limit(0);	
	//echo date('H:i:s') . " Iterate worksheets\n";
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
	{
		//echo '- ' . $worksheet->getTitle() . "\r\n";

		foreach ($worksheet->getRowIterator() as $row) 
		{
			echo '    - Row number: ' . $row->getRowIndex() . "\r\n";
			if($row->getRowIndex()<>1){ //we do not need first row(column name)
				
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				
				$counter=0;
				$arrRow=array();
				foreach ($cellIterator as $cell) 
				{
					$counter++;
					if (!is_null($cell)) 
					{
						//do database inserts here	
						if($counter==1)
						{
							$arrRow['continent']=$filter->filter($cell->getCalculatedValue());
						}
						else if($counter==2){
							$arrRow['country']=$filter->filter($cell->getCalculatedValue());	
						}
						
						else if($counter==3){
							$arrRow['city']=$filter->filter($cell->getCalculatedValue());	
						}
						//echo '        - Cell: ' . $cell->getCoordinate() . ' - ' . $cell->getCalculatedValue() . "\r\n";
					}
					
				}
				
				//----insert into continent
					$continent_id=0;
					$continentM=new Application_Model_Continent();
				
					$continent=$continentM->fetchRow("name='{$arrRow['continent']}'");
					if(false===$continent)
					{
						$continentM->setName($arrRow['continent']);
						try{
						$continent_id=$continentM->save();
						}catch (Exception $e){
							echo $arrRow['continent']." continent not inserted <br>\n";
						}	
					}
					else
					{
						$continent_id=$continent->getId();
					}
				//--------------------------
				
				//----insert into country
					$country_id=0;
					$countryM=new Application_Model_Country();
					
					$country=$countryM->fetchRow("name='{$arrRow['country']}' and continent_id='{$continent_id}'");
					if(false===$country){
						$countryM->setName($arrRow['country']);
						$countryM->setContinentId($continent_id);
						try{
						$country_id=$countryM->save();	
						}catch(Exception $e){
							echo $arrRow['country']." country not inserted <br>\n";
						}
					}else{
						$country_id=$country->getId();
					}
					
				//-------------------------------
			
					
 
				///------insert into city
					
					if($arrRow['city']<>""){
						$cityM=new Application_Model_City();
						$city=$cityM->fetchRow("name='{$arrRow['city']}' and country_id='{$country_id}'");
						if(false===$city){
							$cityM->setName($arrRow['city']);
							$cityM->setCountryId($country_id);
							try{
								$city_id=$cityM->save();	
							}catch(Exception $e){
							echo $arrRow['city']." city not inserted <br>\n";
							
							}
						}
					}
				//------------------------
					
				
			}
			
		}
	}


}


public function xmlAction()
{
	
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	echo "<pre>";
	$filename = "data/sample - Chiang Mai.xml";
	$xml_parser = new Base_Xml_Parser(null, $filename); 
	
	$continentName=$xml_parser->Data['identification']['geoTag1'];
	$countryName=$xml_parser->Data['identification']['geoTag2'];
	$cityName=$xml_parser->Data['identification']['geoTag3'];
	//----insert into continent
		$continent_id=0;
		$continentM=new Application_Model_Continent();
	
		$continent=$continentM->fetchRow("name='{$continentName}'");
		if(false===$continent)
		{
			$continentM->setName($continentName);
			$continent_id=$continentM->save();
		}
		else
		{
			$continent_id=$continent->getId();
		}
	//--------------------------
	
	//----insert into country
		$country_id=0;
		$countryM=new Application_Model_Country();
		$country=$countryM->fetchRow("name='{$countryName}' and continent_id='{$continent_id}'");
		if(false===$country){
			$countryM->setName($countryName);
			$countryM->setContinentId($continent_id);
			$country_id=$countryM->save();	
		}else{
			$country_id=$country->getId();
		}
		
	//-------------------------------

		
 
	///------insert into city
		$city_id=0;
		$cityM=new Application_Model_City();
		$city=$cityM->fetchRow("name='{$cityName}' and country_id='{$country_id}'");
		if(false===$city){
			$cityM->setName($cityName);
			$cityM->setCountryId($country_id);
			$city_id=$cityM->save();	
		}else{
			$city_id=$city->getId();	
		}
	//------------------------

	if($continent_id>0 && $country_id>0 && $city_id>0 ){
		//it is city
		$locationType="city";
		$locationId=$city_id;
	}else if($continent_id>0 && $country_id>0){
		//it is country
		$locationType="country";
		$locationId=$country_id;
	}else if($continent_id>0){
		//it is continent
		$locationType="continent";
		$locationId=$continent_id;
	}
	

	
	
	$title=$xml_parser->Data['content']['title'];
	$introduction=$xml_parser->Data['content']['introduction'];
	$destinationM=new Application_Model_Destination();
	$destinationM->setTitle($title);
	$destinationM->setIntroduction($introduction);
	$destinationM->setLocationId($locationId);
	$destinationM->setLocationType($locationType);
	$destination_id=$destinationM->save();
	
	
	
		
	
	
	foreach ($xml_parser->Data['content']['experiences'] as $experiences) 
	{ 
		
		foreach($experiences as $_item){
			//print_r($_item);die();
			$experiencesM=new Application_Model_Experiences();
			$experiencesM->setTitle($_item['title']);
			$experiencesM->setDestinationId($destination_id);
			$experiencesM->setCopy($_item['copy']);
			$experiencesM->save();
		}
	} 
	 
	foreach ($xml_parser->Data['content']['practicalities'] as $practicalities) 
	{ 
		
		foreach($practicalities as $_item){
			
			$practicalitiesM=new Application_Model_Practicalities();
			$practicalitiesM->setTitle($_item['title']);
			$practicalitiesM->setDestinationId($destination_id);
			$practicalitiesM->setCopy($_item['copy']);
			$practicalitiesM->save();
		}
	}
	
	
	foreach ($xml_parser->Data['content']['eatSleepDrink'] as $eatsleepdrink) 
        { 
		
		foreach($eatsleepdrink as $_item){
			//print_r($_item);die();
			
			$EatSleepDrinkM=new Application_Model_EatSleepDrink();
			$EatSleepDrinkM->setTitle($_item['title']);
			$EatSleepDrinkM->setDestinationId($destination_id);
		    $EatSleepDrinkM->setBackPackerCopy($_item['backpackerCopy']);
		    $EatSleepDrinkM->setLocalCopy($_item['localCopy']);
		    
			$EatSleepDrinkM->save();
		}
	}
	
	
	
	//print_r($xml_parser->Data); 
}


public function myFriendsAction()
{
	$userNs = new Zend_Session_Namespace("members");
    $where = "user_id='{$userNs->userId}' AND status='accept'";
	
    $params = $this->getrequest()->getParams();
    $extra  = array();
    //search by connection type
	if(isset($params['searchkey']) && $params['searchkey']!='')
    {
    	$key = $params['searchkey'];
    	$this->view->ctype=$key;
    	$where .= " AND connection_type = '$key'";
    	$extra['searchkey'] = $key;
    	
    }
	//search by friends name
	if(isset($params['searchname']) && $params['searchname']!='' && $params['searchname']!='Search Names')
    {
    	$userarray[] = -1;
    	$searchname = $params['searchname'];
    	$this->view->searchname=$searchname;
    	$userM = new Application_Model_User();
		$user_where_sql = "";
		//$user_where_sql .= "status='active'";
		//$user_where_sql .= " AND (first_name LIKE '%$searchname%' || last_name LIKE '%$searchname%' || username LIKE '%$searchname%')";
		//$user_where_sql .= " CONCAT(first_name,' ',last_name ) LIKE '%$searchname%' || username LIKE '%$searchname%'";
        $user_where_sql .= " CONCAT(first_name,' ',last_name ) LIKE '%$searchname%'";

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
	$friendM	= new Application_Model_Friend();
	
	$settings	= new Admin_Model_GlobalSettings();
	$page_size= $settings->settingValue('friend_page_size');
	//$page_size	= 1;
	$this->view->page_size	=	$page_size;
	$page 		= $this->_getParam('page',1);
	
	$pageObj	= new Base_Paginator();
	$paginator	= $pageObj->fetchPageData($friendM, $page, $page_size, $where);
	$this->view->totalFriends=$pageObj->getTotalCount(); 
	
	$data = $friendM->fetchAll($where, "addedon DESC", $page_size);
	$this->view->data	=	$data;
}

/**
 * @Created By : Mahipal Singh Adhikari
 * @Created On : 18-Nov-2010
 * @Description: Used to display more friend of a user on "Show More" link from My Friends page
 */
public function showMorefriendsAction()
{
	$this->view->layout()->disableLayout();
	
	$userNs = new Zend_Session_Namespace("members");
    $where = "user_id='{$userNs->userId}' AND status='accept'";
	
    $params = $this->getrequest()->getParams();
    $extra  = array();
	
    //search by connection type
	if(isset($params['searchkey']) && $params['searchkey']!='')
    {
    	$key = $params['searchkey'];
    	$where .= " AND connection_type = '$key'";
    }
	//search by friends name
	if(isset($params['searchname']) && $params['searchname']!='' && $params['searchname']!='Search Names')
    {
    	$userarray[] = -1;
		$searchname = $params['searchname'];
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
	//search by particular friend, this is used to append single friend record to My Friend list when user accepts a friend request
	if(isset($params['append_friend_id']) && $params['append_friend_id']!='')
    {
    	$append_friend_id = $params['append_friend_id'];
    	$where .= " AND friend_id = {$append_friend_id}";
    }
	
    $friendM	= new Application_Model_Friend();
	
	/*------------------------- Set paging START------------------------*/
	$settings	=	new Admin_Model_GlobalSettings();
	$page_size	=	$settings->settingValue('friend_page_size');
	//$page_size	= 1;
	$page		= 	$this->_getParam("page");
	$offset		=	($page-1)*$page_size;
	/*------------------------- Set paging END------------------------*/
	
	$data = $friendM->fetchAll($where, "addedon DESC", $page_size, $offset);
	if(count($data)==0)
	{
		$this->_helper->viewRenderer->setNoRender(true);
		exit("nodata");
	}
	$this->view->data	=	$data;				
}//end of function


public function addAConnectionAction()
{
	$form = new Application_Form_Invite();
	$elements=$form->getElements();
	$form->clearDecorators();
	foreach($elements as $element)
		$element->removeDecorator('label');

	$this->view->form = $form;
	$this->view->successMsg="";
	
	//remove form elements
	$form->removeElement("name");
	
	if ($this->getRequest()->isPost())
	{
		$params= $this->getRequest()->getPost();
		
		if ($form->isValid($params))
		{
			$errorMsg1	=	"";
			$errorMsg2	=	"";
			$siteurl	=	Zend_Registry::get('siteurl');
			$usersNs	=	new Zend_Session_Namespace("members");
			$userId		=	base64_encode($usersNs->userId);
			
			//get sender information
			$userM		=	new Application_Model_User();
			$userRes	=	$userM->find($usersNs->userId);
			$params["name"]		=	ucwords($userRes->getFirstName()." ".$userRes->getLastName());
			$params["email"]	=	$userRes->getEmail();
			$params["invitation_link"]	=	"{$siteurl}/index/register/sender/{$userId}";
			$mail	=	new Base_Mail();
			
			if(isset($params["inviteEmail"]))
			{
				if($params["contacts"]=="")
				{
					$errorMsg1 = "Please add your contacts.";
				}
				if($params["contacts"]!="")
				{
					$total_contacts = explode(",",$params['contacts']);
					$receiver_email = "";
					$emailValidateObj = new Zend_Validate_EmailAddress();
					$emailError = "";
					$contactEmail = array();
					for($i=0;$i<count($total_contacts);$i++)
					{
						$receiver_email = trim($total_contacts[$i]);
						if($receiver_email!="" && $emailValidateObj->isValid($receiver_email)==false)
						{
							$emailError .= "<br /><b>{$receiver_email}</b> is not a valid email address.";							
						}
						else
						{
							$contactEmail[] = $receiver_email;
						}						
					}
					if($emailError!="")
					{
						$errorMsg1	= "Please fix following error(s):".$emailError;						
					}
					//set valid emails in new option
					$params['contactEmail'] = $contactEmail;
				}
				$this->view->errorMsg1 = $errorMsg1;
				
				//if no errors found then send invitation email
				if($errorMsg1=="")
				{
					$comment_url = $siteurl."/index/register/sender/".$userId;
					$invitation_link = "<a href='".$comment_url."' target='_blank'>".$comment_url."</a>";
					$params["invitation_link"] = $invitation_link;
					$params["message"] = "Join Gap Daemon";
					$returnMail = $mail->sendInvitationToEmails($params); //send invitation email to contact entered by user
					//print_r($params);
					$this->_helper->redirector('thanks','gapper',"default");
				}	
			}
			else
			{
				if($params['total_contacts']=="")
				{
					$errorMsg2 = "Please add your contacts.";
				}
				$this->view->errorMsg2 = $errorMsg2;
				
				//if no errors found then send invitation email
				if($errorMsg2=="")
				{
					$mail->sendInvitation($params); //send invitation email using open inviter
					$this->_helper->redirector('thanks','gapper',"default");
				}	
			}					
		}//end if
	}//end if post form
}

public function thanksAction()
{

}
public function ___addAConnectionAction()
{  
	$userNs=new Zend_Session_Namespace("members");
    $where="user_id='{$userNs->userId}'";
    
	$form = new Application_Form_Invite();
	$elements=$form->getElements();
	$form->clearDecorators();
	foreach($elements as $element)
		$element->removeDecorator('label');
		
	$this->view->form = $form;    	
	$this->view->successMsg="";
	if ($this->getRequest()->isPost()) 
	{
		$params= $this->getRequest()->getPost();          
		if ($form->isValid($params)) 
		{
			$siteurl=Zend_Registry::get('siteurl');
			$usersNs = new Zend_Session_Namespace("members");
			$userId=base64_encode($usersNs->registration_id);
			$params['invitation_link']="{$siteurl}/index/register/id/{$userNs->userId}";
			$mail=new Base_Mail();
			$mail->sendInvitation($params);
			
			//$this->_helper->redirector('thanks','index',"default");
		}
	}
}
public function loadContactsAction()
{
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
		$email=$this->_getParam('email');          
		$password=$this->_getParam('password');
		$provider=$this->_getParam('provider');
		
        
		$ers=array();
		if (empty($email))
			$ers['email']="Email missing !";
		if (empty($password))
			$ers['password']="Password missing !";
		if (empty($provider))
			$ers['provider']="Provider missing !";
		if (count($ers)==0)
		{
			$inviter=new Base_Openinviter();
			$oi_services=$inviter->getPlugins();
			$inviter->startPlugin($provider);
			$internal=$inviter->getInternalError();
			if ($internal)
			$ers['inviter']=$internal;
			elseif (!$inviter->login($email,$password))
			{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
			}
			elseif (false===$contacts=$inviter->getMyContacts())
			{
				$ers['contacts']="Unable to get contacts !";
			}			
		}
		
    	if(count($ers)==0)
		{
			//print_r($contacts);
			$address=array();
			$address=array_keys($contacts);
			$data=implode(", ",$address);
			$result=array('error'=>0, 'data'=>$data);
		}
		else
		{
			$ers=implode(", ",$ers);
			$result=array('error'=>1, 'data'=>$ers);
			
		}
		echo Zend_Json::encode($result);
}
	
	public function reloadWallAction()
	{
		$this->_helper->layout->disableLayout();
		
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->userId	=	$userNs->userId;

		//fetch all user friends
		$friendM	=	new Application_Model_Friend();
		$friends	=	$friendM->getUserFriend($userNs->userId);
		$friendStr	=	$userNs->userId;
		
		// Fetch all hided poster User ids
		$objModelWallHideUserAll	=	new Application_Model_WallHideUserAll();
		$poster						=	$objModelWallHideUserAll->getAllPosterId($userNs->userId);
		
		if(!empty($friends))
		{
			$arrPostedFriend = array_diff($friends, $poster);
		}	
		$arrPostedFriend[] = $userNs->userId;
		
		if(false!==$arrPostedFriend)
		{
			$friendStr = implode(',',$arrPostedFriend);
		}
        
		$order = "addedon DESC";
        $where = "active_status=1 AND user_id IN ({$friendStr} )";
		
		// Fetch all hided post ids
		$WallHideUserPostM	=	new Application_Model_WallHideUserPost();
		$hidedPost			=	$WallHideUserPostM->getAllHidePostId($userNs->userId);
		if(count($hidedPost)>0)
		{
			$hidePost = implode(",", $hidedPost);
			$where .= " AND id NOT IN({$hidePost})";
		}
		
		//Get particular wall information to display, added by mahipal on 10-Dec-2010
		$wall_id = $this->_getParam('wall_id');
		if(isset($wall_id) && $wall_id!="")
		{
			$this->view->wall_id = $wall_id;
			$where = " id={$wall_id}";
		}
		
        /*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('friend_page_size');
		/*------------------------- Set paging END--------------------------*/
		
		$feeds	=	new Application_Model_Wall();
		$data	=	$feeds->fetchAll($where, $order, $page_size);
		$this->view->data		=	$data;
		//$this->view->hidedPost	=	$hidedPost;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Dec-2010
	 * @Description: Used to display more wall on "View More" link from My Travel Wall page
	 */
	public function viewMorewallAction()
	{
		$this->view->layout()->disableLayout();
		
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->userId=$userNs->userId;
		
		//fetch all user friends
		$friendM	=	new Application_Model_Friend();
		$friends	=	$friendM->getUserFriend($userNs->userId);
		$friendStr	=	$userNs->userId;
		
		// Fetch all hided poster id
		$objModelWallHideUserAll	=	new Application_Model_WallHideUserAll();
		$poster						=	$objModelWallHideUserAll->getAllPosterId($userNs->userId);
		
		if(!empty($friends))
		{
			$arrPostedFriend = array_diff($friends, $poster);
		}	
		$arrPostedFriend[] = $userNs->userId;
		
		if(false!==$arrPostedFriend)
		{
			$friendStr = implode(',',$arrPostedFriend);
		}
		$order	=	"addedon DESC";
		$where	=	"active_status=1 AND user_id IN ({$friendStr} )";
		
		// Fetch all hided post ids
		$WallHideUserPostM	=	new Application_Model_WallHideUserPost();
		$hidedPost			=	$WallHideUserPostM->getAllHidePostId($userNs->userId);
		if(count($hidedPost)>0)
		{
			$hidePost = implode(",", $hidedPost);
			$where .= " AND id NOT IN({$hidePost})";
		}
		
		/*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('friend_page_size');
		$page		= 	$this->_getParam("page");
        $offset		=	($page-1)*$page_size;
		/*------------------------- Set paging END------------------------*/	
		
		//now create wall object and get data
		$feeds	=	new Application_Model_Wall();
		$data 	=	$feeds->fetchAll($where, $order, $page_size, $offset);
		
		$this->view->data		=	$data;
		$this->view->hidedPost	=	$hidedPost;
		
		//if no record found then no need to render view and exit
		if(count($data)==0)
		{
			$this->_helper->viewRenderer->setNoRender(true);
			exit("nodata");
        }				
	}//end of function
	
	public function reloadWallMyAction()
	{
		$this->_helper->layout->disableLayout();
		
		$userNs=new Zend_Session_Namespace('members');
		$this->view->userId	=	$userId	=	$userNs->userId;
		
		$order = "addedon DESC";
        //$where = "active_status=1 AND user_id IN ({$friendStr} )";
		
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
		
		//get particular wall information to display, added by mahipal on 10-Dec-2010
		/*
		$wall_id = $this->_getParam('wall_id');
		if(isset($wall_id) && $wall_id!="")
		{
			$this->view->wall_id = $wall_id;
			$where = " id={$wall_id}";
		}*/
		
        /*------------------------- Set paging START------------------------*/
		$settings	=	new Admin_Model_GlobalSettings();
        $page_size	=	$settings->settingValue('friend_page_size');
		/*------------------------- Set paging END--------------------------*/
		
		$feeds	= new Application_Model_Wall();
		$data	= $feeds->fetchAll($where, $order, $page_size);
		$this->view->data		=	$data;
		//$this->view->hidedPost	=	$hidedPost;
	}
	
	public function viewMorewallMyAction()
	{
		$this->view->layout()->disableLayout();
		
		$userNs	=	new Zend_Session_Namespace('members');
		$this->view->userId = $userId = $userNs->userId;
		
		$order	=	"addedon DESC";
        //$where = "active_status=1 AND user_id IN ({$friendStr} )";
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
		
		//now create wall object and get data
		$feeds	=	new Application_Model_Wall();
		$data 	=	$feeds->fetchAll($where, $order, $page_size, $offset);
		
		$this->view->data		=	$data;
		//$this->view->hidedPost	=	$hidedPost;
		
		//if no record found then no need to render view and exit
		if(count($data)==0)
		{
			$this->_helper->viewRenderer->setNoRender(true);
			exit("nodata");
        }				
	}//end of function
	
	public function createBlogAction()
	{
	 	$request = $this->getRequest();
        $form    = new Application_Form_Blog();
	
         $elements=$form->getElements();
    		$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    	
    	
        if ($this->getRequest()->isPost()) 
        {
            $params=$request->getParams();
			$params['weight'] = 1;
            if ($form->isValid($params)) 
            {
            	$userNs=new Zend_Session_Namespace('members');
                $params['userId']=$userNs->userId;
                $journalM=new Application_Model_Journal();
                $journal=$journalM->fetchRow("user_id='{$userNs->userId}'");
                if(false!==$journal){
                    $params['journalId']=$journal->getId();
                    $params['featured']=0;
                    $blogM=new Application_Model_Blog($params);
                    $blog_id=$blogM->save();
                    if($blog_id>0)
                    {
                            /*-----tags--------*/
                    if($params['tags']<>""){
                    $arrTags=explode(",",$params['tags']);
                    foreach($arrTags as $_tag)
                    {
                            $_tag=trim($_tag);
                            $tagsM=new Application_Model_Tags();
                            $tag=$tagsM->fetchRow("tag='{$_tag}'");
                            if(false===$tag){
                                    $tagsM->setTag($_tag);
                                    $tag_id=$tagsM->save();
                            }else{
                                    $tag_id=$tag->getId();
                            }
                            $albumTagM=new Application_Model_BlogTag();
                            $albumTagM->setBlogId($blog_id);
                            $albumTagM->setTagId($tag_id);
                            $albumTagM->save();

                    }
                    }
                    /*----------tags-------*/
                            $_SESSION["flash_msg"] = "Journal has been created successfully.";
                            $form->reset();
                    }
                    else
                    {
                            $_SESSION["flash_msg"] = "Faild to create journal. Please try again.";
                    }
                }
				else
				{
                     $_SESSION["flash_msg"] = "Faild to create journal. You have removed your journal.";
                }
				//redirect user
				///$this->_redirect('/journal/my-journals/');
                $this->_redirect($this->view->seoUrl('/journal/my-journals/'));
            }			
        }

        $this->view->form = $form;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 1-Nov-2010
	 * @Description: Used to edit blog post information
	 */
	public function editBlogAction()
	{
	 	$request = $this->getRequest();
        $form    = new Application_Form_Blog();
		$form->removeElement("weight");
		
		//get blog information for edit
		$blog_id    = $this->_getParam('id');
		//$blog_id	= base64_decode($blog_id);
		
		if(isset($blog_id))
		{
			$objBlog	= new Application_Model_Blog();
			$blog		= $objBlog->find($blog_id);
			
			//get blog tags
			$tag	=	new Application_Model_Tags();
			$tags	=	$blog->getTags();
			$tags	=	$tag->getTagsForEdit($blog_id);
			
			$blog_info["title"]		= $blog->getTitle();
			$blog_info["status"]	= $blog->getStatus();
			$blog_info["categoryId"]= $blog->getCategoryId();
			$blog_info["location"]	= $blog->getLocation();
			$blog_info["tags"]		= $tags;
			$blog_info["content"]	= $blog->getContent();
			$blog_info["comment"]	= $blog->getComment();
			$blog_info["publish"]	= $blog->getPublish();
			$blog_info["weight"]	= $blog->getWeight();
			$form->populate($blog_info);
		}
			
        $elements=$form->getElements();
    	$form->clearDecorators();
    	
		
		foreach($elements as $element)
    	$element->removeDecorator('label');
    	    	
        if ($this->getRequest()->isPost()) 
        {
            $params = $request->getParams();
			
			if ($form->isValid($params)) 
            {
            	$userNs		=	new Zend_Session_Namespace('members');                
                $journalM	= 	new Application_Model_Journal();
                $journal	=	$journalM->fetchRow("user_id='{$userNs->userId}'");
				
                if(false!==$journal)
				{
                    $params['userId'] 		= $userNs->userId;
					$params['journalId']	= $journal->getId();
                    $params['featured']		= $blog->getFeatured();
					$params['weight'] 		= $blog->getWeight();
					//$params['id']	= $blog_id;
                    $blogM	=	new Application_Model_Blog($params);
                    
					$blog	=	$blogM->save();
                    if($blog && $blog_id!="")
                    {
						//now first delete tags
						$albumTagM	=	new Application_Model_BlogTag();
						//$objBlogTag = 	new Application_Model_BlogTag();
						$albumTagM->delete("blog_id = $blog_id");
						
						//insert/update blog tags
						if($params['tags']<>"")
						{
							$arrTags	=	explode(",",$params['tags']);
							foreach($arrTags as $_tag)
							{
								$_tag	=	trim($_tag);
								$tagsM	=	new Application_Model_Tags();
								$tag	=	$tagsM->fetchRow("tag='{$_tag}'");
								if(false===$tag)
								{
									$tagsM->setTag($_tag);
									$tag_id	=	$tagsM->save();
								}
								else
								{
									$tag_id	=	$tag->getId();
								}
								//$albumTagM=new Application_Model_BlogTag();
								$albumTagM->setBlogId($blog_id);
								$albumTagM->setTagId($tag_id);
								$albumTagM->save();
							}//end of foreach
						}//end of if
						/*----------tags-------*/
						$_SESSION["flash_msg"] = "Journal post has been updated successfully.";
						$form->reset();
						
                    }//end of if
                    else
                    {
                         $_SESSION["flash_msg"] = "Failed to update journal post. Please try again later.";
                    }
                }//end of if
				else
				{
					$_SESSION["flash_msg"] = "Failed to update journal post because you have removed your journal.";
                }
				//redirect user
				//$this->_redirect('/journal/my-journals/');
                $this->_redirect($this->view->seoUrl('/journal/my-journals/'));
            }//end of if
        }//end of if
		
        $this->view->form = $form;
	}//end of function
	
	
	public function searchAction()
	{}
	
	public function whereIAmAction()
	{
           
            $this->_helper->layout->setLayout('3column-my-account');

            $userNs=new Zend_Session_Namespace('members');
            $this->view->userId=$userId=$userNs->userId;
            $user=new Application_Model_User();

            $user=new Application_Model_User();
            $this->view->loc=$user->getNearByUser($userId,1000,20);
          //var_dump($this->view->loc);
            $user=$user->find($userNs->userId);
            $this->view->loginUrl ="";
            $facebook=$this->view->facebook();
            if($user->getFacebookId()=="" || is_null($user->getFacebookId()))
            {
            	$return_url=Zend_Registry::get('siteurl')."/index/do-fb-return/";
				$cancel_url=Zend_Registry::get('siteurl')."/index/cancel-facebook";
                $this->view->loginUrl=$loginUrl = $facebook->getLoginUrl(array("cancel_url"=>$cancel_url,"next"=>$return_url,"req_perms"=>"offline_access,publish_stream,read_stream,email,user_birthday,user_location","display"=>"popup"));
            }

            $userM=new Application_Model_User();
            $userM=$userM->find($userId);
            $this->view->countryName=$userM->getCountryName();
            $this->view->cityName=$userM->getCityName();
            $this->view->userThumb=$userM->getThumbnail();
            $this->view->fullName=$userM->getFirstName()." ".$userM->getLastName() ;

            $destinationM=new Application_Model_Destination();
            $destination=$destinationM->fetchAll();
            $this->view->destination=$destination;

            $experienceM=new Application_Model_Experiences();

            $destinationId=$this->getRequest()->getParam('destination_id');

            /*--find the current location coordinates --*/
            $gapperLocationM=new Application_Model_GapperLocation();
            $where="user_id='{$userId}'";
            $order="addedon desc";
            $gapperLocation=$gapperLocationM->fetchRow($where, $order);
            if(false==$gapperLocation){
                //these are default coordinates.
                $this->view->myLongitude="";
                $this->view->myLatitude="";
                $this->view->addedon="";
            }else{
                $this->view->myLongitude=$gapperLocation->getLongitude();
                $this->view->myLatitude=$gapperLocation->getLatitude();
                $this->view->addedon=$gapperLocation->getAddedon();
            }
            /*------------------------------------------*/
            
            


            

	}
	/**
	 * @Created By : Mahipal Adhikari
	 * @Created On : 29-Oct-2010
	 * @Description: Used to save/update map location permission from where-i-am page
	 */ 
	function updateLocationPermissionAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$id = $this->getRequest()->getParam('perm_id');
		$friend_group_id	=	$this->getRequest()->getParam('friend_group_id');
		
		$response = "";
		
		$UserPermissionObj	= new Application_Model_UserPermission();
		$UserPermissionObj	= $UserPermissionObj->find($id);
		if(false!==$UserPermissionObj)
		{
			$UserPermissionObj->setFriendGroupId($friend_group_id);
			$respPermission	=  $UserPermissionObj->save();
			//set confirmation message to display
			if($respPermission)
			{
				//get permission name to set selected
				$FriendGroupObj = new Application_Model_FriendGroup();
				$whereCond			= "id='{$friend_group_id}'";
				$FriendGroup		= $FriendGroupObj->fetchRow($whereCond);
				$PermissionName		= $FriendGroup->getName();
				
				$response .= "<span style='color:#EF4733;'>Location permission has been saved.</span>";
				$JsonResultArray = Array('msg'=>$response, 'set_permission'=>$PermissionName);
			}
			else
			{
				$response = "<span style='color:#EF4733;'>Error occured. Please try again later.</span>";
				$JsonResultArray = Array('msg'=>$response);
			}
		}
		else
		{
			$response = "<span style='color:#EF4733;'>Invalid request.</span>";
			$JsonResultArray = Array('msg'=>$response);
        }
		//sleep(5);
		echo Zend_Json::encode($JsonResultArray);
        exit;
	}//end function
		
        function removeDestinationAction()
        {
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $id=$this->getRequest()->getParam('id');
            $gapperLocationM=new Application_Model_GapperLocation();
            $where="id='{$id}'";
            if($gapperLocationM->delete($where)){
                  $arrayResult=Array('error'=>0);
            } else
            {
                $arrayResult=Array('error'=>1);
            }
            echo Zend_Json::encode($arrayResult);
        }
        
	public function myGapDeamonAction(){
		//$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	public function myProfileAction()
	{
		/*--- find user data and populate the edit form ----*/
		$userNs = 	new Zend_Session_Namespace('members');
        $userId=$userNs->userId;
		
		//$user	=	unserialize($userNs->userObj);
		//$userId	=	$user->getId();

		$userM=new Application_Model_User();
		$user=$userM->find($userId);
		
		$params['firstName']		=	$user->getFirstName();
		$params['lastName']			=	$user->getLastName();
        $params['email']			=	$user->getEmail();
		$params['countryPassport']	=	$user->getCountryPassport();
		$params['preferredLanguage']=	$user->getPreferredLanguage();
		$params['otherLanguages']	=	$user->getOtherLanguages();
		$params['cityId']			=	$user->getCityId();
		$params['cityName']			=	$user->getCityName();
		$arrDob=explode("-",$user->getDob());
		if(count($arrDob)>0){
			$params['year']=$arrDob[0];	
			$params['month']=$arrDob[1];
			$params['day']=$arrDob[2];
		}
		$params['sex']=$user->getSex();
		$params['firstTimeTraveller']=$user->getFirstTimeTraveller();
		$params['mobileCountryCode']=$user->getMobileCountryCode();
		$params['mobile']=$user->getMobile();
		$params['dreamDestination']=$user->getDreamDestination();
		$params['wayToTravel']=$user->getWayToTravel();
		$params['travelGear']=$user->getTravelGear();
		$params['yearGoal']=$user->getYearGoal();
		$params['leaveHomeWithout']=$user->getLeaveHomeWithout();
		$params['interests']=$user->getInterests();
		
		$params['evenTakenGapYear']=$user->getEvenTakenGapYear();
		$params['nextTravelToDoList']=$user->getNextTravelToDoList();
		$params['favouriteTravelExperience']=$user->getFavouriteTravelExperience();
		
		$this->view->username	=	$user->getUsername();
		/*-------------------------------------------------------*/
		
		$form=new Application_Form_Profile();
		$form->populate($params);
		
		$elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    		
	if ($this->getRequest()->isPost()) 
        {
            $params= $this->getRequest()->getPost();
            
            /*---- email validation ----*/
            
              if($params['email']!=$user->getEmail())
                {
                    $form->getElement('email')->addValidators(array(
                	array('Db_NoRecordExists', false, array(
        			'table' => 'user',
	       			'field' => 'email',
	       			'messages'=>'Email already exists, Please choose another email address'
	    			))

            	));
                }
            /*-------------------------*/

                
            /*--- validations for change password -------*/

            if(trim($params['currentPassword'])<>"")
            {
            	$params['currentPassword']=md5($params['currentPassword']);
            	$form->getElement('currentPassword')->addValidators(array(
                	array('Db_RecordExists', false, array(
        			'table' => 'user',
	       			'field' => 'password',
	       			'messages'=>'Incorrect current password'
	    			))
            			
            	));
            	$form->getElement('password')->setRequired(true);
            }
            
        	if(trim($params['password'])<>"" &&  $params['currentPassword']=="")
            {
            	$form->getElement('currentPassword')->setRequired(true);
            	$form->getElement('currentPassword')->addValidators(array(
                	array('NotEmpty', false, array('messages'=>array('isEmpty'=>'You must enter the current password')))
            			
            	));
            }
            
            /*--- validations for change password -------*/
            
            if ($form->isValid($params) ) 
            {
				$upload = new Zend_File_Transfer_Adapter_Http();
				//---main image
		        if($upload->isValid('image'))
		        {
		        	//unlink existing images
					if($user->getImage()!="" && file_exists("media/picture/profile/".$user->getImage()))
					{
						unlink("media/picture/profile/".$user->getImage()); //main uploaded image
						unlink("media/picture/profile/thumb_".$user->getImage()); //thumb image
					}	
					
					$upload->setDestination("images/uploads/");
		        	try 
		        	{
					 	$upload->receive('image');
					 	
					 } 
					 catch (Zend_File_Transfer_Exception $e) 
					 {
					 	$msg= $e->getMessage();
					 }			 
								 
					 $upload->setOptions(array('useByteString' => false));
					 
					 $id=$userId;
					 $file_name = $upload->getFileName('image');
		 		 	 $cardImageTypeArr = explode(".", $file_name);
		 		 	 $ext=strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]); 			 	 
		 		 	 $target_file_name = "profile_".$id.".{$ext}";
				 	 $targetPath = 'media/picture/profile/'.$target_file_name;
				 	 $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					 $filterFileRename -> filter($file_name);
					 $params['image']=$target_file_name;
					 
					 
					/*--- Generate Thumbnail ---*/ 
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(200,200);
					$thumb->save($targetPath = 'media/picture/profile/thumb_'.$target_file_name);
				}
		        //-----------
            	
            	$params['dob']=$params['year']."-".$params['month']."-".$params['day'];
            	$pass=$user->getPassword();
            	if(trim($params['password'])<>"")
	   				$params['password']=md5($params['password']);
	   			else
	   				$params['password']=$pass;
				
	   			$user->setOptions($params);	
				$user->save();
				$this->view->msg="Profile updated successfully!";
				$userNs->userObj=serialize($user);
            }
            //$this->_helper->_redirector->gotoUrl($this->view->seoUrl("/gapper/my-profile"));
            //$this->_redirect($this->view->seoUrl("/gapper/my-profile"));
            
        }
            $this->view->thumbImage	=	$user->getThumbnail();
            $this->view->image_name	=	$user->getImage();
			$this->view->gender		=	$user->getSex();
            $this->view->form		=	$form;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 16-Nov-2010
	 * @Description: Used to delete profile image
	 */
	public function removeProfileimageAction()
	{
		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
		
		$userNs = new Zend_Session_Namespace('members');
        $id		= $userNs->userId;
		
		if(is_null($userNs->userId) && !numeric($userNs->userId))
		{
			$response = "<span style='color:#ff0000;'>Please login to remove profile image.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		if($this->_getParam('image')=="")
		{
			$response = "<span style='color:#ff0000;'>Profile image does not exists.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		//remove profile image
		$userm	= new Application_Model_User();
		$userm	= $userm->find($id);
		
		if(false!==$userm)
		{
			$resp = "";
			$userm->setImage(null);
			$resp	=  $userm->save();
			//unlink images from uploaded directory
			if(file_exists("media/picture/profile/".$this->_getParam('image')))
			{
				unlink("media/picture/profile/".$this->_getParam('image')); //main uploaded image
				unlink("media/picture/profile/thumb_".$this->_getParam('image')); //thumb image
			}	
			
			$response = "<span style='color:#ff0000;'>Profile image has been deleted.</span>";
			$JsonResultArray = Array('error'=>2, 'response'=>$response);
		}
		else
		{
			$response = "<span style='color:#ff0000;'>Invalid request, please try again later.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
        }
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end function	
	
	public function myTravelWallAction()
	{
		$userNs	=	new Zend_Session_Namespace('members');		
		
		//get particular wall information to display, added by mahipal on 10-Dec-2010
		$wall_id = "";
		$wall_id = $this->_getParam('wall_id');
		if(isset($wall_id) && $wall_id!="")
		{
			$this->view->wall_id = $wall_id;
		}		
		
		$blockM	=	new Base_View_Block();
		$blockM->removeBlock("weather", "myaccount");
		$blockM->removeBlock("time","myaccount");
		$blockM->removeBlock("whats-going-on","myaccount");
		$blockM->removeBlock("journal","myaccount");
        
		$user		=	new Application_Model_User();
		$user		=	$user->find($userNs->userId);
		$this->view->loginUrl =	"";
		$facebook	=	$this->view->facebook();
		
		if($user->getFacebookId()=="" || is_null($user->getFacebookId()))
		{
			//$return_url=Zend_Registry::get('siteurl')."/index/facebook-connect/";
			$return_url=Zend_Registry::get('siteurl')."/index/do-fb-return/";
		    $cancel_url=Zend_Registry::get('siteurl')."/index/cancel-facebook";
    		$this->view->loginUrl=$loginUrl = $facebook->getLoginUrl(array("cancel_url"=>$cancel_url,"next"=>$return_url,"req_perms"=>"offline_access,publish_stream,read_stream,email,user_birthday,user_location","display"=>"popup"));
		}
		//get user facebook friend list, for testing
        //$statusUpdate = $facebook->api('/'.$user->getFacebookId().'/friends', 'get');
        ///https://api.facebook.com/method/liveMessage.send?recipient=qa&event_name=asdfads&message=asdfdasfadsf&access_token=...
        //$statusUpdate = $facebook->api('/100001442260018/feed', 'post', array('message'=> "please join gd", 'cb' => ''));
        //var_dump($statusUpdate );
                
		/*----facebook----*/
		/*$me=array();
		$facebook=$this->view->facebook();
		$session=$facebook->getSession();
		if ($session) 
		{
		  try {
		    $me = $facebook->api('/me');
		  	} catch (FacebookApiException $e) {
		    error_log($e);
		  	}
		}
		if($me){
	  		$this->view->loginUrl="";
	  	}else{
	  		$this->view->loginUrl = $facebook->getLoginUrl();
	  	}*/
	
		/*-----------------*/	
		if ($this->getRequest()->isPost())
		 {
			$userId = $user->getId();
			
			$this->_helper->layout->disableLayout();	
			$this->_helper->viewRenderer->setNoRender(true);
			$params	=	$this->getRequest()->getParams();
			$params['userId']		=	$userId;
			
			//Added by Mahipal Adhikari on 28-Jan-2011, to save user profile id in which wall is posted
			$profileId = 0;
			//if($params["wall_flag"] != "my-travel-feed")
			$profileId = $userId;//posting on own wall
			$params['profileId']	=	$profileId;
			$params['status']	=	nl2br($params['status']);
			$wall	=	new Application_Model_Wall($params);
			
			$id	=	$wall->save();
			if($id>0)
			{
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
				//------------------------
			}
			else
			$arrayResult=Array('error'=>1);
			
			if(isset($params['facebook']))
			{
				if($user->getFacebookId()<>"" && !is_null($user->getFacebookId()))
				{
					$statusUpdate = $facebook->api('/'.$user->getFacebookId().'/feed', 'post', array('message'=> $params['status'], 'cb' => ''));	
				}
				
			}
			echo Zend_Json::encode($arrayResult);
		}		
	}


	public function updateMyLocationAction()
	{
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $userNs=new Zend_Session_Namespace('members');
            $userId=$userNs->userId;

            
            $location=new Application_Model_GapperLocation();
            $data['latest']=0;
            $location->getMapper()->getDbTable()->update($data, array('user_id = ?' => $userId));

            
            $params=$this->getRequest()->getParams();
            $params['userId']=$userId;
            $params['latest']=1;

            $location=new Application_Model_GapperLocation($params);
            
            $id=$location->save();
            if($id>0)
                $arrayResult=Array("id"=>$id,'error'=>0);
            else
                $arrayResult=Array('error'=>1);
            echo Zend_Json::encode($arrayResult);
	}
	
	public function permissionAction()
	{
		$userNs	=	new Zend_Session_Namespace('members');
		$userId	=	$userNs->userId;

		$form	=	new Application_Form_UserPermission();
		$this->view->form	=	$form;
		if ($this->getRequest()->isPost()) 
		{
			$params = $this->getRequest()->getPost();
			if ($form->isValid($params))
			{
				$where = "user_id='{$userId}' AND permission_id NOT IN (1)";
				$user_permission=new Application_Model_UserPermission();
				$user_permission=$user_permission->fetchAll($where);
				foreach($user_permission as $_permission)
				{
					$_permission->setFriendGroupId($params["friend_group_id_".$_permission->getPermissionId()]);
					$_permission->save();
					$this->view->msg="Your permissions have been updated successfully.";
				}
			}
		}
	}//end function
	
	public function myMessagesAction()
	{		
		$this->_helper->layout->setLayout('2column');
		$userNs		=	new Zend_Session_Namespace('members');
		$userId		=	$userNs->userId;
		$msg 		=	$this->_getParam('msg');
		$reply		=	$this->_getParam('reply');
		$username	=	$this->_getParam('username');
		
		$form=new Application_Form_CreateMessages();
		$this->view->form=$form;
		
		$this->view->selectedTab	=	0;
		
		//set update messages
		if(isset($_SESSION['session_error_msg']) && $_SESSION['session_error_msg']!="")
		{
			$session_error_msg = $_SESSION['session_error_msg'];
			if($session_error_msg=="success")
			{
				$this->view->msg	=	"Message has been sent.";
				$this->view->selectedTab	=	2;
			}
			if($session_error_msg=="failed")
			{
				$this->view->msg	=	"Message can not be sent, please try again later.";
				$this->view->selectedTab	=	2;
			}
			if($session_error_msg=="accept")
			{
				$this->view->msg	=	"Friend request has beed accepted.";
				$this->view->selectedTab	=	1;
			}
			if($session_error_msg=="decline")
			{
				$this->view->msg	=	"Friend request has beed declined.";
				$this->view->selectedTab	=	1;
			}
			unset($_SESSION['session_error_msg']);	
		}
			
		//set reply message
		if(!empty($reply))
		{				
			$id		= base64_decode($reply);
			$modelMessages	=	new Application_Model_Message();
			$modelUser		=	new Application_Model_User();			
			$valMessages	=	$modelMessages->find($id);
			
			$messageSenderId	=	$valMessages->getFromId();
			$valUser			=	$modelUser->find($messageSenderId);
			$senderName			=	$valUser->getFirstName().' '.$valUser->getLastName();
			
			$valMessage		=	$modelMessages->find($id);	
			$msg_subject	= 	"Re: ".$valMessage->getSubject();
			$this->view->receipentArr = array("receipent_id"=>$messageSenderId, "receipent_name"=>$senderName,"msg_subject"=>$msg_subject);
			
			//$form->getElement('toEmail')->setValue($senderName);
			//$form->getElement('toId')->setValue($messageSenderId);	
			//$form->getElement('subject')->setValue($valMessage->getSubject());			
			$this->view->selectedTab	=	2;
		}
		
		//send message to particuar user
		if(!empty($username))
		{				
			$id				=	base64_decode($username);
			$modelUser		=	new Application_Model_User();			
			$userRes		=	$modelUser->find($id);
			if(false!==$userRes)
			{
				$senderName		=	$userRes->getFirstName().' '.$userRes->getLastName();
				$msg_subject	= 	"Hello";
				$this->view->receipentArr = array("receipent_id"=>$id, "receipent_name"=>$senderName,"msg_subject"=>$msg_subject);
			}	
			$this->view->selectedTab	=	2;
		}
		
		//get inbox message and search
		$messageM = new Application_Model_Message();		
		$searchParams = $this->getRequest()->getParams();		
		
		$where="to_id='{$userId}'";
		$search_message = false;
		if(isset($searchParams['msgsearch']) && $searchParams['msgsearch']!='' && $searchParams['msgsearch']!='Search Messages')
		{
			$msgsearch = $searchParams['msgsearch'];
			$where .=" and (subject like '%$msgsearch%' OR body like '%$msgsearch%')";
			$this->view->msgsearch = $msgsearch;
			$this->view->param = array("msgsearch"=>$msgsearch);
			$this->view->selectedTab	=	0;
			$search_message = true;
		}

		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('message_pagination_size');
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($messageM,$page,$page_size,$where,'id desc');
		$this->view->total=$pageObj->getTotalCount();			
		
		$this->view->messages	=	$paginator;
		
		/*----------------------- START SENT MESSAGE ------------------------*/
		$whereSent="from_id='{$userId}'";
		
		$paginator	=	$pageObj->fetchPageData($messageM,$page,$page_size,$whereSent,'id desc');
		
		$this->view->totalSent	=	$pageObj->getTotalCount();			
		
		$this->view->sentMessages	=	$paginator;
		/*------------------------ END SENT MESSAGE -------------------------*/
		
		$friendM = new Application_Model_Friend();
		$where="friend_id='{$userId}' and status='pending'";
		$friendMN=$friendM->fetchAll($where);
		
		$this->view->friend = $friendMN;	   
		
		//send message
		if ($this->getRequest()->isPost() && $search_message==false) 
		{
			$params = $this->getRequest()->getPost();
			
			$error  = "";
			if(!isset($params['toEmail']) || count($params['toEmail'])<1)
			{
				$error = "Please select receipents."; 
			}
			if(empty($params['subject']) || $params['subject']=="")
			{
				$error .= "<br />Subject can not be left blank.";
			}
			if(empty($params['body']) || $params['body']=="")
			{
				$error .= "<br />Message can not be left blank.";
			}
			
			if($error=="")
			//if ($form->isValid($params))
			{
				//send email to all receipents
				for($cntR=0; $cntR<count($params['toEmail']); $cntR++)
				{
					//if(!empty($params['toId']))
					if(is_numeric($params['toEmail'][$cntR]))
					{
						$params['toId']		=	$params['toEmail'][$cntR];
						$params['status']	=	'inbox'; 
						$params['fromId']	=	$userId;
						$params['parentId']	=	0;
						$params['read']		=	0;
						
						$messages	=	new Application_Model_Message($params);
						$savemsg	=	$messages->save();
						/*------------------------- NOTIFICATION EMAIL ---------------------------*/				
						
						$userObj		=	new Application_Model_User();
						$valTo			=	$userObj->find($params['toId']);
						$toFirstName	=	$valTo->getFirstName();
						$toLastName		=	$valTo->getLastName();
						
						$option['toName']	=	$toFirstName.' '.$toLastName;
						$option['toEmail']	=	trim($valTo->getEmail());
						$option['message']	=	$params['body'];				
						$option['messageId']=	$savemsg;
						
						$userNs				=	new Zend_Session_Namespace('members');
						$loggedInUserId		=	$userNs->userId;
						$valfrom			=	$userObj->find($loggedInUserId);
						$option['fromName']	=	$valfrom->getFirstName().' '.$valfrom->getLastName();			
						
						$mail=new Base_Mail(); 
						$mail->sendNotificationMail("message_notification", $option);
					}
					else
					{
						$_SESSION['session_error_msg'] = "failed";
						$this->_redirect($this->view->seoUrl('/gapper/my-messages/'));
					}
				}//end of for
				$_SESSION['session_error_msg'] = "success";
				$this->_redirect($this->view->seoUrl('/gapper/my-messages/'));
			}//end if
			else
			{
				$form->getElement('subject')->setValue($params['subject']);
				$form->getElement('body')->setValue($params['body']);
				$this->view->msg	=	$error;
				$this->view->selectedTab	=	2;
			}
			$this->view->form=$form;		    
		}//end if
	}
	
	public function autoEmailAction()
   	{ 
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		/*-------------- FIND FRIEND IDS ----------------------*/
		$userNs	=	new Zend_Session_Namespace('members');
		$userId	=	$userNs->userId;
		$modelFriend	=	new Application_Model_Friend();
		$whereFriend	=	"user_id='{$userId}' AND status='accept'";
		$arrFriend		=	$modelFriend->fetchAll($whereFriend);
		$strFriend		=	"";
		foreach($arrFriend as $frnd)
		{
			$strFriend	=	$strFriend.",".$frnd->friendId;
		}
		
		$myFriend	=	substr($strFriend, 1, strlen($strFriend));
		/*-----------------------------------------------------*/
		$where	=	"(first_name like '%{$q}%' || last_name like '%{$q}%' || email like '%{$q}%') AND id IN ($myFriend)";
		$userM	=	new Application_Model_User();
		$res	=	$userM->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row) 
		{
			array_push($result, array("id"=>$row->getId(), "value" => $row->getFirstName()." ".$row->getLastName()));
		}
		echo Zend_Json::encode($result);
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 6-Jan-2011
	 * @Description: Used to selects users friend and print array in JSOn format
	 */
	public function selectFriendsAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		
		//get logged in user id from session
		$userNs	=	new Zend_Session_Namespace('members');
		$userId	=	$userNs->userId;
		
		//get users friends ids
		$modelFriend	=	new Application_Model_Friend();
		$whereFriend	=	"user_id='{$userId}' AND status='accept'";
		$arrFriend		=	$modelFriend->fetchAll($whereFriend);
		$strFriend		=	"";
		foreach($arrFriend as $frnd)
		{
			$strFriend	=	$strFriend.",".$frnd->friendId;
		}
		
		$myFriend	=	substr($strFriend, 1, strlen($strFriend));
		
		//select friends from user table using above friends user Ids
		$where	=	"id IN ($myFriend)";
		$userM	=	new Application_Model_User();
		$res	=	$userM->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row) 
		{
			$name = $row->getFirstName()." ".$row->getLastName();
			array_push($result, array("caption"=>$name, "value"=>$row->getId()));
		}
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		//$result = array( array("caption"=>"mahipal", "value"=>4), array("caption"=>"mahipal Adhikari", "value"=>3), array("caption"=>"Adhikari Singh", "value"=>5));
		echo Zend_Json::encode($result);
	}
   	
   	public function autoNameAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$where = "status = 'active'";
		//$where .= " AND (username LIKE '%{$q}%' OR first_name LIKE '%{$q}%' OR  last_name LIKE '%{$q}%')";
		$where .= " AND (CONCAT(first_name,' ',last_name ) LIKE '%$q%' OR username LIKE '%$q%')";
		$userM=new Application_Model_User();
		$res=$userM->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row) 
		{
			//array_push($result, array("id"=>$row->getId(), "value" => $row->getFirstName()));
			//$name = $row->getFirstName();
			$name = $row->getFirstName()." ".$row->getLastName();
			array_push($result, array("id"=>$row->getId(), "value" => $name));
		}
		echo Zend_Json::encode($result);
   	}
   	
   	
   	
   	public function autoFriendNameAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$userNs = new Zend_Session_Namespace('members');
		$userId = $userNs->userId;
		
		$friendM = new Application_Model_Friend();
		
		$frienddata = $friendM->fetchAll("status='accept' AND user_id = $userId");
		$friendids  = array();
		foreach($frienddata as $friend)
		{
			$friendids[] = $friend->getFriendId();
		}
		
		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$where = "";
		//$where="first_name like '%{$q}%'";
		$where .= " (CONCAT(first_name,' ',last_name ) LIKE '%$q%' OR username LIKE '%$q%')";
		
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
   	
   	
   	
	public function updateMyEmailAction()
	  {
		$usersNs = new Zend_Session_Namespace("members");
		$userM=new Application_Model_User();
		$user=$userM->find($usersNs->userId);
		$form=new Application_Form_Email();
                $form->populate(Array("email"=>$user->getEmail()));
		$this->view->form=$form;
		if ($this->getRequest()->isPost()) 
                {
                    $params= $this->getRequest()->getPost();
                    //print_r($params);die();
                    if ($form->isValid($params))
                    {
                                        $user->setEmail($params['email']);
                                        $user->save();
                                        $this->view->msg="Your email hase been updated successfully";
                    }
                }
	}
	
	
	public function allFriendsAction()
	{
		$userNs = new Zend_Session_Namespace('members');
		$userId = $userNs->userId;
		$where = "1=1 AND id!='$userId'";	
		$where .= " AND status = 'active'";
		
		$name	=	"";
		if ($this->getRequest()->isPost())
		{
			$params	=	$this->getRequest()->getParams();
			$name	=	$params['nickname'];
		}
			
		if($name!="")
		{
			//$where .= " AND (username LIKE '%{$name}%' OR first_name LIKE '%{$name}%' OR  last_name LIKE '%{$name}%')";
			//$where .= " AND (CONCAT(first_name,' ',last_name ) LIKE '%$name%' OR username LIKE '%$name%')";
            $where .= " AND (CONCAT(first_name,' ',last_name ) LIKE '%$name%' )";
			$this->view->param = array('nickname'=>$name);
		}
		$friendM = new Application_Model_Friend();
		$frienddata = $friendM->fetchAll("user_id = $userId AND status = 'accept'");
		
		if(count($frienddata)>0)
		{
			foreach($frienddata as $friend)
			{
				$friendids[] = $friend->getFriendId();
			}
			$friend_str = implode(',',$friendids);
			$where .= " AND id NOT IN($friend_str)";
		}
		$userM = new Application_Model_User();
		$settings=new Admin_Model_GlobalSettings();
		$page_size=$settings->settingValue('pagination_size');
		$page=$this->_getParam('page',1);
		$pageObj=new Base_Paginator();
		$paginator=$pageObj->fetchPageData($userM,$page,$page_size,$where);
		$this->view->total=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
	}
	
	public function addFriendAction()
	{
	 	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$userNs = new Zend_Session_Namespace('members');
	    $userId = $userNs->userId;
        
		$params= $this->getRequest()->getParams();
        
        $friendId = $params['id']; 
        $connectionType = $params['ftype']; 
        
		//check user login
		if(!isset($userId) && !is_numeric($userId))
		{
			$userM = new Application_Model_User();
			$profileUser   = $userM->find($friendId);
			$profileUrl = "/";
			if(false!==$profileUser)
			{
				$profileUrl = "/".$profileUser->getUsername();
			}
			
			$JsonResultArray = Array('error'=>1, 'response'=>"Please login to make this request.", "profileUrl"=>$profileUrl);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
        $friendM    = new Application_Model_Friend();
        $frienddata = $friendM->fetchRow("user_id = '$userId' and friend_id = '$friendId'");
        $reqStatus = "";

        if(false!==$frienddata)
        {
			$reqStatus = $frienddata->getStatus();
			if($reqStatus=="pending")
			{
				$response = "You already have sent friend request to this user.";
			}	
			else if($reqStatus=="accept")
			{
				$response = "This user already added in your friend list.";
			}
			else if($reqStatus=="decline")
			{
				//update friend request status to pending
				$frienddata->setStatus("pending");
				$frienddata->save();
				
				//send friend request email to user
				$userObj = new Application_Model_User();
				
				//get sender information
				$Sender   = $userObj->find($userId);
				$mailOptions['sender_email']= $Sender->getEmail();
				$mailOptions['sender_name']	= ucwords($Sender->getFirstName()).' '.ucwords($Sender->getLastName());
				
				//get receiver information
				$Receiver   = $userObj->find($friendId);
				$mailOptions['receiver_email']	= $Receiver->getEmail();
				$mailOptions['receiver_name']	= ucwords($Receiver->getFirstName()).' '.ucwords($Receiver->getLastName());
				$mailOptions['con_type']		= ucwords($connectionType);
				
				//create mail class object and send the email
				$Mail	=	new Base_Mail();
				$Mail->sendFriendRequest($mailOptions);
				
				$response = "Your friend request has been sent.";
			}
			else
			{
				$response = "Error occured, please contact system administrator.";
			}
		}
		else
		{

        	$data['userId'] = $userId;
	        $data['friendId'] = $friendId;
	        $data['connectionType'] = $connectionType;
	        $data['status'] = 'pending';

	        $friendM        = new Application_Model_Friend($data);
	        $res = $friendM->save();
			if($res)
			{
				//send friend request email to user
				$userObj = new Application_Model_User();
				
				//get sender information
				$Sender   = $userObj->find($userId);
				$mailOptions['sender_email']= $Sender->getEmail();
				$mailOptions['sender_name']	= ucwords($Sender->getFirstName()).' '.ucwords($Sender->getLastName());
				
				//get receiver information
				$Receiver   = $userObj->find($friendId);
				$mailOptions['receiver_email']	= $Receiver->getEmail();
				$mailOptions['receiver_name']	= ucwords($Receiver->getFirstName()).' '.ucwords($Receiver->getLastName());
				$mailOptions['con_type']		= ucwords($connectionType);
				
				//create mail class object and send the email
				$Mail	=	new Base_Mail();
				$Mail->sendFriendRequest($mailOptions);
		
				$response = "Your friend request has been sent.";
			}
			else
			{
				$response = "Error occured please try again later.";
			}
        }

		$JsonResultArray = Array('error'=>2, 'response'=>$response);
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end function
	
	
	public function declineAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$params= $this->getRequest()->getParams();
		
		$id = $params['id'];
	  
		$friendM        = new Application_Model_Friend();
		$friendM->delete("id = $id");
		
		//set session and redirect user
	    $_SESSION['session_error_msg'] = "decline";
		$this->_redirect($this->view->seoUrl('/gapper/my-messages/'));	
	}
		

		
		public function acceptFAction()
		{
			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			
		    $params= $this->getRequest()->getParams();
	        
	        $id = $params['id'];
	        $friendM        = new Application_Model_Friend();
	        $friendM = $friendM->find($id);
	        $friendM->setStatus('accept');
	        $friendM->save();
	        
	        
	        $fdata['friendId'] = $friendM->getUserId();
	        $fdata['userId'] = $friendM->getFriendId();
	        $fdata['connectionType'] = $friendM->getConnectionType();
	        $fdata['status'] = 'accept';
	        //print_r($fdata);exit;
	        $friendM        = new Application_Model_Friend($fdata);
	        $friendM->save();
			
			//set session and redirect user
	        $_SESSION['session_error_msg'] = "accept";
			$this->_redirect($this->view->seoUrl('/gapper/my-messages/'));
	    }
		
		public function deleteMessagesAction()
		{
		     $params= $this->getRequest()->getParams();
		     
			 if(isset($params['del']))
			 {
			 	$messageM = new Application_Model_Message();
			 	foreach($params['del'] as $row)
			 	{
			 		$messageM->delete("id = $row");
			 	}
			 }       
	        //set session and redirect user
	        $_SESSION['session_error_msg'] = "delete";
			$this->_redirect($this->view->seoUrl('/gapper/my-messages/'));
		}
		
		public function removeTravelWallPostAction()
		{
			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			
			$params	= $this->getRequest()->getParams();
			
			$postId	=	$params['postId'];
			
			$objModelWall		=	new Application_Model_Wall();
			$objModelVote		=	new Application_Model_Vote();
			$objModelComment	=	new Application_Model_Comment();
			
			$whereWall		=	"id='{$postId}'";
			$whereVote		=	"item_id='{$postId}' AND item_type='status'";
			$whereComment	=	"item_id='{$postId}' AND item_type='status'";
			
			$arrComment		=	$objModelComment->fetchAll($whereComment);
			
			if(!(empty($arrComment)))
			{
				foreach($arrComment as $cmt)
				{
					$whereVt	=	"item_id='{$cmt->id}' AND item_type='status_comment'";
					$objModelVote->delete($whereVt);
				}
			}		
			
			$objModelVote->delete($whereVote);
			$objModelComment->delete($whereComment);
			$objModelWall->delete($whereWall);
			
			exit;
		}
		
		public function removeTravelWallPostCommentAction()
		{
			$this->_helper->layout->disableLayout();
			$params	= $this->getRequest()->getParams();
			
			$postId	=	$params['postId'];
			
			$objModelVote		=	new Application_Model_Vote();
			$objModelComment	=	new Application_Model_Comment();
			
			$whereVote		=	"item_id='{$postId}' AND item_type='status_comment'";
			$whereComment	=	"id='{$postId}'";
			
			
			$objModelVote->delete($whereVote);
			$objModelComment->delete($whereComment);
			
			exit;
		}
		
		public function messageDetailAction()
		{
			$id 	= $this->_getParam('id');
			$id		= base64_decode($id);
			
			/*------------ MARKED AS READ --------------------*/
			$modelMessages	=	new Application_Model_Message();
			$modelUser		=	new Application_Model_User();
			
			$valMessages	=	$modelMessages->find($id);
			
			$option['read']	=	1;
			$valMessages->setOptions($option);
			
			$savemsg	=	$valMessages->save();
			
			$messageSenderId	=	$valMessages->getFromId();
			$valUser	=	$modelUser->find($messageSenderId);
			
			$senderName	=	$valUser->getUsername();
			/*------------------------------------------------*/
			
			$valMessage			=	$modelMessages->find($id);
		    $this->view->body	=	nl2br(stripslashes($valMessage->getBody()));
			$this->view->subject=	$valMessage->getSubject();
			$this->view->addedon=	date("dS M Y",$valMessage->getAddedDate());		
			$this->view->senderName	=	$senderName;
			$this->view->msgId		=	base64_encode($id);
		}
		
		public function readMessageAction()
		{
			$this->_helper->layout->disableLayout();
			$params	= $this->getRequest()->getParams();
			
			$postId	=	$params['messagesId'];
			$status	=	$params['status'];
			$arrMessageIds	=	explode(',', $postId);
			
			foreach($arrMessageIds as $id)
			{
				$modelMessages	=	new Application_Model_Message();
				$valMessages	=	$modelMessages->find($id);
			
				$option['read']	=	$status;
				$valMessages->setOptions($option);
			
				$savemsg	=	$valMessages->save();
			
			}
			echo "success";
			exit;
		}
		
		public function deleteMessageAction()
		{
			$this->_helper->layout->disableLayout();
			$params	= $this->getRequest()->getParams();
			
			$postId	=	$params['messagesId'];
			
			$arrMessageIds	=	explode(',', $postId);
			
			foreach($arrMessageIds as $id)
			{
				$modelMessages	=	new Application_Model_Message();				
				$where	=	"id={$id}";				
				$valMessages	=	$modelMessages->delete($where);		
			}
			exit;
		}
		
		public function sentMessageDetailAction()
		{
			$id 	= $this->_getParam('id');
			$id		= base64_decode($id);
			$modelMessages	=	new Application_Model_Message();
			$valMessage	=	$modelMessages->find($id);
		    $this->view->body	=	nl2br(stripslashes($valMessage->getBody()));
			$this->view->subject=	$valMessage->getSubject();
			$this->view->addedon=	date("dS M Y",$valMessage->getAddedDate());	
			
			 $this->_helper->viewRenderer('message-detail');
		}
		
		public function showPostHideBlockAction()
		{
			$this->_helper->layout->disableLayout();
			$postId 	= 	$this->_getParam('postId');
			$posterId		=	$this->_getParam('userId');
			
			$html	 = "<a href=\"javascript://\" onclick=\"hide_this_post({$postId});\">Hide This Post</a>";
			$html	.= "<a href=\"javascript://\" onclick=\"hide_all_post({$posterId});\">Hide All By User</a>";
			$html	.= "<a href=\"javascript://\" onclick=\"reportAbuse({$postId},'wall');\">Report Abuse</a>";
			echo $html;
			exit;
		}
		
		public function hideThisPostAction()
		{
			$this->_helper->layout->disableLayout();
			$params	= $this->getRequest()->getParams();
			
			$userNs = new Zend_Session_Namespace('members');
			$userId = $userNs->userId;
			
			$objModelWallHideUserPost	=	new Application_Model_WallHideUserPost();
			
			$option['postId']	=	$params['postId'];
			$option['userId']	=	$userId;
			$option['addedon']	=	time();
			
			$objModelWallHideUserPost->setOptions($option);
			$objModelWallHideUserPost->save();
		
			exit;
		
		}
		
		public function hideAllPostAction()
		{
			$this->_helper->layout->disableLayout();
			$params	= $this->getRequest()->getParams();
			
			$userNs = new Zend_Session_Namespace('members');
			$userId = $userNs->userId;
			
			$objModelWallHideUserAll	=	new Application_Model_WallHideUserAll();
			
			$option['posterId']	=	$params['posterId'];
			$option['userId']	=	$userId;
			$option['addedon']	=	time();
			
			$objModelWallHideUserAll->setOptions($option);
			$objModelWallHideUserAll->save();
			
			exit;		
		}
		
		public function testAction()
		{
			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			
			$string="
			<a href = 'http://www.google.com'>google</a><br />
			<a href = 'http://www.google.com'>http://www.google.com</a><br />
			<a href='http://www.google.com'>www.google.com</a><br />
			<A HREF='http://yahoo.com'>Yahoo</A><br />
			https://google.com <br />
			http://www.yahoo.com <br />
			www.yahoo.com
			";
			/*
			$string = '<p>https://www.yahoo.com</p><p>You may experience a sudden change in your fortune today. Suddenly, it will seem like you attract attention no matter what you do! Your <a href="http://www.google.com?q=color">colourful</a>, playful way of dealing with people and situations will attract new friends and even some business connections. You could even try your luck at lottery today as everything seems to be going in your favour!</p>
			<p>You may experience a sudden change in your fortune today. <a href="http://www.google.com/q=suddenly">Suddenly</a>, it will seem like you attract attention no matter what you do! Your colourful, playful way of dealing with people and situations will attract new friends and even some business connections. You could even try your luck at lottery today as everything seems to be going in your favour!</p>
			<p>Yahoo website is: <a href="http://www.yahoo.com">www.yahoo.com</a></p>
			<p>Link1: http://gd.pbodev.info/gapper/edit-blog/id/30</p>
			<p>Link2: www.yahoo.com</p>
			<p>Link3: gd.pbodev.info</p>
			<p>Link 4: Please go to <a href="http://www.google.com">google</a> website to check this link.</p>';
			*/

			$string = preg_replace('@(\s+https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?\s+)@', '<a href="$1">$1</a>', $string);

			$string = preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $string);

			//var_dump($string);
			echo "<div>$string</div>";
		}
}
