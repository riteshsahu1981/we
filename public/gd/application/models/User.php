<?php
class Application_Model_User {
    protected $_id;
    protected $_email;
    protected $_username;
    protected $_password;
    protected $_firstName;
    protected $_lastName;
    
    protected $_countryPassport;
    protected $_preferredLanguage;
    protected $_otherLanguages;
    protected $_gapperOrFriend;
    protected $_gapperId;
    
    protected $_firstTimeTraveller;
    protected $_mobileCountryCode;
    protected $_mobile;
    protected $_userThumbImage;    
    
    protected $_image;
    protected $_dob;
    protected $_sex;
    
    protected $_cityId;
    protected $_facebookId;

    protected $_dreamDestination;
    protected $_wayToTravel;
    protected $_travelGear;
    protected $_yearGoal;
    protected $_leaveHomeWithout;
    protected $_interests;
    
    protected $_evenTakenGapYear;
    protected $_nextTravelToDoList;
    protected $_favouriteTravelExperience;
   
    protected $_newsletter;
    
    protected $_status;
    protected $_addedon;
    protected $_updatedon;
    protected $_userLevelId;
    protected $_mapper;
    

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }


    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified' . $method);
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
 	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_UserMapper());
        }
        return $this->_mapper;
    }

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

   	public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }

    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }   

    public function getFirstName()
    {
        return $this->_firstName;
    }

    public function setFirstName($firstName)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    } 

    public function getLastName()
    {
        return $this->_lastName;
    }

    public function setLastName($lastName)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }        
	
    public function getNewsletter()
    {
    	return $this->_newsletter;
    }
  
    public function setNewsletter($newsletter)
    {
    	$this->_newsletter=(string) $newsletter;	
    	return $this;
    }
    
    public function getImage()
    {
        return $this->_image;
    }

    public function setImage($image)
    {
        $this->_image= (string) $image;
        return $this;
    }
    
    public function getDob()
    {
        return $this->_dob;
    }

    public function setDob($dob)
    {
        $this->_dob = (string) $dob;
        return $this;
    }    
    public function getSex()
    {
        return $this->_sex;
    }

    public function setSex($sex)
    {
        $this->_sex = (string) $sex;
        return $this;
    }
    
    public function getCityId()
    {
        return $this->_cityId;
    }

    public function setCityId($cityId)
    {
        $this->_cityId= (int) $cityId;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }
 
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
	
	public function getAddedon()
    {
        return $this->_addedon;
    }

    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }

    public function getUpdatedon()
    {
        return $this->_updatedon;
    }

    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
        return $this;
    }

    public function getUserLevelId()
    {
        return $this->_userLevelId;
    }

    public function setUserLevelId($userLevelId)
    {
        $this->_userLevelId= (int) $userLevelId;
        return $this;
    }
    
 	public function getCountryPassport()
    {
        return $this->_countryPassport;
    }

    public function setCountryPassport($countryPassport)
    {
        $this->_countryPassport= (int) $countryPassport;
        return $this;
    }

   public function getPreferredLanguage()
    {
        return $this->_preferredLanguage;
    }

    public function setPreferredLanguage($preferredLanguage)
    {
        $this->_preferredLanguage= (int) $preferredLanguage;
        return $this;
    }
    
	public function getOtherLanguages()
    {
        return $this->_otherLanguages;
    }

    public function setOtherLanguages($otherLanguages)
    {
        $this->_otherLanguages= (string) $otherLanguages;
        return $this;
    }
    
	public function getGapperOrFriend()
    {
        return $this->_gapperOrFriend;
    }

    public function setGapperOrFriend($gapperOrFriend)
    {
        $this->_gapperOrFriend= (string) $gapperOrFriend;
        return $this;
    }
    
	public function getGapperId()
    {
        return $this->_gapperId;
    }

    public function setGapperId($gapperId)
    {
        $this->_gapperId= (int) $gapperId;
        return $this;
    }
    
	public function getFirstTimeTraveller()
    {
        return $this->_firstTimeTraveller;
    }

    public function setFirstTimeTraveller($firstTimeTraveller)
    {
        $this->_firstTimeTraveller= (string) $firstTimeTraveller;
        return $this;
    }
    
	public function getMobileCountryCode()
    {
        return $this->_mobileCountryCode;
    }

    public function setMobileCountryCode($mobileCountryCode)
    {
        $this->_mobileCountryCode= (string) $mobileCountryCode;
        return $this;
    }
    
	public function getMobile()
    {
        return $this->_mobile;
    }

    public function setMobile($mobile)
    {
        $this->_mobile= (string) $mobile;
        return $this;
    }
        
    public function getDreamDestination()
    {
    	return $this->_dreamDestination;
    }
    
    public function setDreamDestination($dreamDestination)
    {
    	$this->_dreamDestination = (string)$dreamDestination;
    	return $this;
    }
    
    public function getWayToTravel()
    {
		return $this->_wayToTravel;	
    }
    
    public function setWayToTravel($wayToTravel)
    {
    	$this->_wayToTravel=(string)$wayToTravel;
    	return $this;
    }
    
    public function getTravelGear()
    {
    	return $this->_travelGear;
    }
    
    public function setTravelGear($travelGear)
    {
    	$this->_travelGear=(string)$travelGear;
    	return $this;
    }
        
    public function getYearGoal()
    {
    	return $this->_yearGoal;
    }
    
	public function setYearGoal($yearGoal)
    {
    	$this->_yearGoal=(string)$yearGoal;
    	return $this;
    }
    
	public function getLeaveHomeWithout()
    {
    	return $this->_leaveHomeWithout;
    }
    
	public function setLeaveHomeWithout($leaveHomeWithout)
    {
    	$this->_leaveHomeWithout=(string)$leaveHomeWithout;
    	return $this;
    }

	public function getInterests()
    {
    	return $this->_interests;
    }
	public function setInterests($interests)
    {
    	$this->_interests=(string)$interests;
    	return $this;
    }
    
	public function getEvenTakenGapYear()
    {
    	return $this->_evenTakenGapYear;
    }
	public function setEvenTakenGapYear($evenTakenGapYear)
    {
    	$this->_evenTakenGapYear=(string)$evenTakenGapYear;
    	return $this;
    }
    
	public function getNextTravelToDoList()
    {
    	return $this->_nextTravelToDoList;
    }
	public function setNextTravelToDoList($nextTravelToDoList)
    {
    	$this->_nextTravelToDoList=(string)$nextTravelToDoList;
    	return $this;
    }
    
	public function getFavouriteTravelExperience()
    {
    	return $this->_favouriteTravelExperience;
    }
	public function setFavouriteTravelExperience($favouriteTravelExperience)
    {
    	$this->_favouriteTravelExperience=(string)$favouriteTravelExperience;
    	return $this;
    }
    
	public function getFacebookId()
    {
    	return $this->_facebookId;
    }
	public function setFacebookId($facebookId)
    {
    	$this->_facebookId=(string)$facebookId;
    	return $this;
    }
    
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
			$model = new Application_Model_User();
			
            $model->setId($row->id)
						->setEmail($row->email)
	                  	->setUsername($row->username)
	                  	->setPassword($row->password)
	                  	->setFirstName($row->first_name)
	                  	->setLastName($row->last_name)
	                  	->setImage($row->image)
	                  	->setDob($row->dob)
	                  	->setSex($row->sex)
	                  	->setCityId($row->city_id)
	                  	->setCountryPassport($row->country_passport)
	                  	->setPreferredLanguage($row->preferred_language)
	                  	->setOtherLanguages($row->other_languages)
	                  	->setGapperOrFriend($row->gapper_or_friend)
	                  	->setGapperId($row->gapper_id)
	                  	->setFirstTimeTraveller($row->first_time_traveller)
	                  	->setMobileCountryCode($row->mobile_country_code)
	                  	->setMobile($row->mobile)                  
	                  	->setStatus($row->status)
	               		->setDreamDestination($row->dream_destination)
	             		->setWayToTravel($row->way_to_travel)
	             		->setTravelGear($row->travel_gear)
	             		->setYearGoal($row->year_goal)
	             		->setLeaveHomeWithout($row->leave_home_without)
	             		->setInterests($row->interests)
	             		->setEvenTakenGapYear($row->even_taken_gap_year)
	             		->setNextTravelToDoList($row->next_travel_to_do_list)
	             		->setFavouriteTravelExperience($row->favourite_travel_experience)
	             		->setNewsletter($row->newsletter)
	                  	->setFacebookId($row->facebook_id)
	                  	->setAddedon($row->addedon)
	                  	->setUpdatedon($row->updatedon)
	                  	->setUserLevelId($row->user_level_id)
						;
    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
            'email'   			=> $this->getEmail(),
     		'username'   		=> $this->getUsername(),
        	'password'  		=> $this->getPassword(),
        	'first_name'		=> $this->getFirstName(),
        	'last_name' 		=> $this->getLastName(),
     		'image'	 			=> $this->getImage(),
        	'dob'   			=> $this->getDob(),
     		'sex'   			=> $this->getSex(),
     		'country_passport'	=> $this->getCountryPassport(),
     		'preferred_language'=> $this->getPreferredLanguage(),
     		'other_languages'	=> $this->getOtherLanguages(),
     		'gapper_or_friend'	=> $this->getGapperOrFriend(),
     		'gapper_id'			=>$this->getGapperId(),
     		'first_time_traveller'=> $this->getFirstTimeTraveller(),
     		'mobile_country_code'=> $this->getMobileCountryCode(),
     		'mobile'=> $this->getMobile(),
     		'facebook_id'=>$this->getFacebookId(),
     		'dream_destination'=>$this->getDreamDestination(),
     		'way_to_travel'=>$this->getWayToTravel(),
     		'travel_gear'=>$this->getTravelGear(),
     		'year_goal'=>$this->getYearGoal(),
     		'leave_home_without'=>$this->getLeaveHomeWithout(),
     		'interests'=>$this->getInterests(),
     		'even_taken_gap_year'=>$this->getEvenTakenGapYear(),
     		'next_travel_to_do_list'=>$this->getNextTravelToDoList(),
     		'favourite_travel_experience'=>$this->getFavouriteTravelExperience(),
    		'newsletter'=>$this->getNewsletter(),    	
        	
			'city_id'			=> $this->getCityId(),
        	'status'			=> $this->getStatus(),
     		
        	'user_level_id'		=> $this->getUserLevelId()
        	
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updatedon']=time();
            $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
            return false;
        }
        
        $row = $result->current();
		
		$res=$this->setModel($row);
		//print_r($res);exit;
        return $res;
    }
	

    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where, $order , $count , $offset);
        $entries   = array();
        foreach ($resultSet as $row) 
        {
            $res=$this->setModel($row);
            $entries[] = $res;
        }
        return $entries;
    }
    
    public function fetchRow($where)
    { 
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);

       	if(!empty($row))
       	{
 			$res=$this->setModel($row);
 			return $res;
       	}
       	else 
       	{
       		return false;
       	}
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    
    public function isExist($where)
    {
    	$res=$this->fetchRow($where);

    	if($res===false)
       	{
       		return false;
       	}
       	else 
       	{
       		return true;
       	}
    }
    
    /*----Data Manupulation functions ----*/

    
    public function getDataByUsername($username)
    {
    	$user=new Application_Model_User();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
    public function getCountryName()
    {
    	$country=new Application_Model_Country();
		$country=$country->find($this->getCountryPassport());
		if(false!==$country)
			return $country->getName();
		else
			return false;	
    }
	

   public function getPreferredLanguageName()
    {
    	$preferredLang=new Application_Model_Language();
		$preferredLang=$preferredLang->find($this->getPreferredLanguage());
                
		if(false!==$preferredLang)
			return $preferredLang->getName();
		else
			return false;
    }

    
   public function getCityName()
    {
    	$city=new Application_Model_City();
		$city=$city->find($this->getCityId());
		if(false!==$city)
			return $city->getName();
		else
			return false;	
    }
    
    
    public function setDefaultJournal($user_id)
    {
    	$userM=new Application_Model_User();
    	$user=$userM->find($user_id);
    	if(false!==$user){
	    	$journalM=new Application_Model_Journal();
	    	$journalM->setTitle($user->getFirstName()."'s Journal");
	    	$journalM->setPublish("published");
	    	$journalM->setStatus("public");
	    	$journalM->setUserId($user_id);
	    	$journalM->save();
	    	return true;
    	}
    	return false;
    }
    
    public function setDefaultPermissions($user_id)
    {
	    $permissionM=new Application_Model_Permission();
	   	$permissions=$permissionM->fetchAll();
	   	if(count($permissions)>0)
	   	{
	   		/*-- add default user friend group --*/
	   		/*$friend_group=new Application_Model_FriendGroup();
	   		$defaultG=$friend_group->getDefaultFriendGroups();
	   		$friend_group->setName($defaultG[0]);
	   		$friend_group->setUserId($user_id);
	   		$friend_group_id=$friend_group->save();*/
	   		/*-----------------------------*/
	   		
	   		
	   		foreach($permissions as $_permission)
	   		{
	   			$userPermission=new Application_Model_UserPermission();
	   			$userPermission->setPermissionId($_permission->getId());
	   			$userPermission->setFriendGroupId(5);//set 1 to 5 on 5-march-2011 by mahipal
	   			$userPermission->setUserId($user_id);
	   			$userPermission->save();
	   		}
	   		
	   		/*--- set all default friend group ----*/
	   		/*for($i=1;$i<count($defaultG);$i++)
	   		{
	   			$friend_group->setName($defaultG[$i]);
	   			$friend_group->setUserId($user_id);
	   			$friend_group->save();
	   		}*/
	   		/*--------------------------------------*/
	   	}	
    }
    
    
    public function getUserThumbImage()
    {
        if (null === $this->_userThumbImage)
        {
            if($this->_image<>""){
            $thumbImage="thumb_".$this->_image;
            $this->setUserThumbImage($thumbImage);
            }
        }
        
    	return $this->_userThumbImage;
    }
    
	public function setUserThumbImage($thumbImage)
    {
    	$this->_userThumbImage=(string)$thumbImage;
    	return $this;
    }
    
    
    public function facebookConnect($user_id)
    {
    	 $view=new Zend_view();
         $view->addHelperPath('Base/View/Helper/', 'Base_View_Helper');
	    	$facebook = $view->facebook();
	    	$session = $facebook->getSession();
	    	if($session)
	    	{
	    		$uid = $facebook->getUser();
	    		$user=new Application_Model_User();
			    $user=$user->find($user_id);
			    if(false!==$user)
			    {
			    	$user->setFacebookId($uid);
			    	$user->save();
			    	return true;
			    }
			    else
			    {
			    	return false;
			    }
	    	}
	    	else
	    	{
	    		return false;
	    	}
    }
    
    public function doFacebookLogin()
    {
                $view=new Zend_view();
                $view->addHelperPath('Base/View/Helper/', 'Base_View_Helper');
	    	$facebook = $view->facebook();
	    	$session = $facebook->getSession();
			if ($session) {
			  	try {
			  		
			  			$Auth = new Base_Auth_Auth();
			    		$uid = $facebook->getUser();
			    		$user=new Application_Model_User();
			    		$where="facebook_id='{$uid}'";
			    		$user=$user->fetchRow($where);
			    		
			    		if(false===$user)
			    		{
			    			
			    			//create new user	
			    			$me = $facebook->api('/me');
			    			$password=md5($Auth->passwordGenerator());
			    			$user=new Application_Model_User();
			    			if($me['email']<>"")
			    			{
				    			$where="email='{$me['email']}'";
				    			$user=$user->fetchRow($where);
				    			if(false===$user)
				    			{
				    				//insertex
				    				
				    				$user=new Application_Model_User();
					    			$user->setEmail($me['email']);
					    			$user->setUsername($me['id']);
					    			$user->setPassword($password);
					    			$user->setfirstName($me['first_name']);
					    			$user->setLastName($me['last_name']);
					    			$user->setSex($me['gender']);
					    			$user->setGapperOrFriend('gapper');
					    			$user->setFacebookId($me['id']);
					    			$user->setStatus('active');
					    			$user->setDob('0000-00-00');
					    			$user->setUserLevelId(1);
				    			}
				    			else
				    			{
				    				
				    				//update
				    				$user->setFacebookId($me['id']);
				    			}	
			    			}
			    			else
			    			{
		    					$user=new Application_Model_User();
				    			$user->setEmail($me['email']);
				    			$user->setUsername($me['id']);
				    			$user->setPassword($password);
				    			$user->setfirstName($me['first_name']);
				    			$user->setLastName($me['last_name']);
				    			$user->setSex($me['gender']);
				    			$user->setGapperOrFriend('gapper');
				    			$user->setFacebookId($me['id']);
				    			$user->setStatus('active');
				    			$user->setDob('0000-00-00');
				    			$user->setUserLevelId(1);
			    			}
			    			
			    			
			    			
			    			$user_id=$user->save();
			    			if($user_id>0)
			    			{
			    				
			    				$user->setDefaultPermissions($user_id);
			    				if($params['email']<>""){
				    				//send registration mail
			    				}
			    			}
			    		}
			    		
			    		//--do login --
		    			$params['email']=$user->getEmail();
		    			//$params['username']=$user->getUsername();
			    		$params['password']=$user->getPassword();
			    		$params['md5']="false";
			    		
			    		$Auth ->doLogout();
		        		$loginStatus=true;
		        		if($params['email']<>"")
						{
		        			$loginStatus=$Auth->doLogin($params, 'email');
						}	
		        		else
		        		{
		        			$params['email']=$user->getUsername();
			        		$loginStatus=$Auth->doLogin($params, 'username');
		        		}
		        		
			        	if($user->getEmail()=="" || is_null($user->getEmail()))
			        	{
			        		//echo "<a href='/gapper/update-your-email' >Click here</a>";
			        		//$this->_helper->redirector('update-your-email','gapper');
			        		$result['email']="no";
			        		return $result;			        		
			        	}
			        	
		        		if($loginStatus)
		        		{
		        			$result['email']="ok";
		        			return $result;
		        			//echo "<a href='/gapper/where-i-am' >Click here</a>";		        			
		        			//$this->_helper->redirector('where-i-am','gapper');        			
		        		}
		        		else 
		        		{ 
							if($user->getStatus()=="inactive")
							{
								exit("Please activate your account. <br><a href='#' onclick='window.close();'>Close</a>");
							}
                                                        else if($user->getStatus()=="deleted")
                                                        {
                                                            exit("Your account status is deleted. Please contact administrator.");
                                                        }
							else
							{
								exit("error while login");
							}
		        		}
			  		}
			  		catch (FacebookApiException $e) 
			  		{
				    	error_log($e);
				  	}
			}
    }

    public function getThumbnail()
    {
        $profile_image=$this->getUserThumbImage();
        $cdnuri=new Base_View_Helper_CdnUri();
		
        //Set default profile image according to user Gender
		$thumb = $cdnuri->cdnUri()."/images/no_image_female.jpeg";
		if($this->_sex=="male")
		{
			$thumb = $cdnuri->cdnUri()."/images/no-image.jpg";
		}
		
        //now set profile image
		if($profile_image=="")
        {
            if($this->getFacebookId()<>"")
            {
                $thumb="https://graph.facebook.com/".$this->getFacebookId()."/picture";
            }
		}
        else
		{
            if(file_exists("media/picture/profile/".$profile_image))
			{
				$thumb = $cdnuri->cdnUri()."/media/picture/profile/$profile_image";
			}
		}	
        return $thumb;
    }
    /*
    public function showThumbnail($width=100, $height=150, $size=null)
    {
        //set default size for user image
		if(isset($size) && $size!="")
		{
			if($size == "size_50")
			{
				$width = 50;
				$height = 50;
			}
			else if($size == "size_70")
			{
				$width = 70;
				$height = 70;
			}
			else if($size == "size_90")
			{
				$width = 90;
				$height = 110;
			}
		}
		$path	= $this->getThumbnail();
        $thumb	= Base_Image_PhpThumbFactory ::create($path);
		$thumb->resize($width, $height);
		$thumb->show();
    }*/

    public function getNearByUser($user_id,$distance=5,$page_size=6, $page=1)
    {
        $gapperLocationM=new Application_Model_GapperLocation();
        $latestlocationresult=$gapperLocationM->fetchRow("user_id='$user_id' and latest='1'");

        if(false===$latestlocationresult)
        {
            return false;
        }
        $varLatitude=$latestlocationresult->getLatitude();
        $varLongitude=$latestlocationresult->getLongitude();

        $query = "SELECT gl.address, gl.latest, gl.user_id, sqrt(power(69.1*(gl.latitude - ($varLatitude)),2)+ power(69.1*(gl.longitude-($varLongitude					))*cos(gl.latitude/57.3),2)) as dist ,gl.latitude, gl.longitude FROM
                                                                gapper_location gl  where gl.user_id<>'{$user_id}'  and gl.latest='1' group by gl.user_id,dist having dist<{$distance} order by dist
                                                        ";
        $pageObj=new Base_Paginator();
        $paginator=$pageObj->fetchPageDataRaw($query,$page,$page_size);

        $returnArray=array();
        foreach($paginator as $row)
        {
            /**
			 * @Modified By : Mahipal Singh Adhikari
			 * @Modified On : 15-Nov-2010
			 * @Modification: check other users publish location privacy to display others users locations in MAP
			 **/
			$view_map = false;
			
			$userNs = new Zend_Session_Namespace('members');
			$loggedin_id = $userNs->userId;
			$view_map = $this->checkUserPrivacySettings($row->user_id, $loggedin_id, 3);
			
			/*
			//now get user map permission settings
			$UserPermissionObj	= new Application_Model_UserPermission();
			$wherePerCond		= "user_id='{$row->user_id}' AND permission_id=3";
			$mapPermission		= $UserPermissionObj->fetchRow($wherePerCond);
			$permissionId		= $mapPermission->getId();
			$mapPermission		= $mapPermission->getFriendGroupId();
			//echo "<br />mapPermission=".$mapPermission." for id=".$row->user_id."<br />";
			if($mapPermission==1)
			{
				$view_map = true; //display to public
			}
			else
			{
				//now check logged in user connection type with other location users
				$friend_id	=	$user_id; //looged in user id as friend id
				
				$friendM		= new Application_Model_Friend();
				$friend_cond 	= "user_id='{$row->user_id}' AND friend_id='{$friend_id}' AND status='accept'";
				$conTypeObj		= $friendM->fetchRow($friend_cond);
				
                //if logged in user connected with this user
				if(false!==$conTypeObj)
				{
					$con_type		= $conTypeObj->getConnectionType();
					//echo "<br />connection type=".$con_type."<br />";
					
					if($con_type=="friend" && ($mapPermission==2 || $mapPermission==4))
					{
						$view_map = true; //display to Friends & Family AND Friends, Family and Mates
					}
					else if($con_type=="family" && ($mapPermission==2 || $mapPermission==4))
					{
						$view_map = true; //display to Friends & Family AND Friends, Family and Mates
					}
					else if($con_type=="travelmate" && ($mapPermission==3 || $mapPermission==4))
					{
						$view_map = true; //display to Travel Mates AND Friends, Family and Mates
					}
					else
					{
						$view_map = false;
					}
                }//end if
			}//end else
			*/
			
			//if user display map location is true then get user information
			if($view_map)
			{
				$userM = new Application_Model_User();
				$userM = $userM->find($row->user_id);
				if(false!==$userM)
					$returnArray[]=array("user_id"=>$row->user_id,"dist"=>$row->dist, "longitude"=>$row->longitude, "latitude"=>$row->latitude,"address"=>$row->address,'thumnail'=>$userM->getThumbnail(), 'firstName'=>$userM->getFirstName(), 'lastName'=>$userM->getLastName(), 'username'=>$userM->getUsername(), 'thumbnail'=>$userM->getThumbnail());
			}//end of if		
        }//end of foreach
		
        //var_dump($returnArray);exit;
        return $returnArray;
    }//end of function
   
	/**
	* @Created By 	: Mahipal Singh Adhikari
	* @Created On 	: 17-Nov-2010
	* @Description	: Check user privacy settings for his profile
	* @Input		: $user_id(int), $friend_id(int), $permission_id(int)
	* @Return		: boolean(True or False)
	**/
   public function checkUserPrivacySettings($user_id, $friend_id=0, $permission_id)
   {
		$permit = false;
		
		//echo "<br />user_id=".$user_id." friend_id=".$friend_id." permission_id=".$permission_id."<br />";
		
		//if no parameters sent, return false
		if( (!isset($user_id) && $user_id=="") || (!isset($permission_id) && $permission_id=="") )
		{
			return false;
		}
		
		//if logged in user viewing own
		if($user_id == $friend_id)
		{
			return true;
		}
		
		//now get user permission settings
		$UserPermissionObj	= new Application_Model_UserPermission();
		$wherePerCond		= "user_id='{$user_id}' AND permission_id={$permission_id}";
		$permission			= $UserPermissionObj->fetchRow($wherePerCond);
		
		if(false==$permission)
		{
			return false;
		}
		$permissionId	= $permission->getId();
		$permission		= $permission->getFriendGroupId();
		//echo "<br />permission=".$permission." for id=".$friend_id."<br />";
		
		//if permission is private(Just me) return false
		if($permission==4)
		{
			return false; //do not display to anyone
		}
		
		//if permission is public return true
		if($permission==5)
		{
			return true; //display to public
		}
		
		//now if user is logged in i.e. $friend_id is not null, check connection with user
		//if((isset($friend_id) && is_numeric($friend_id)))
		if((is_numeric($friend_id)) && $friend_id!=0)
		{
			//if permission is Gap Daemon Community return true
			if($permission==1)
			{
				return true; //display to all LoggeIn users
			}
			
			$friendM		= new Application_Model_Friend();
			$friend_cond 	= "user_id='{$user_id}' AND friend_id='{$friend_id}' AND status='accept'";
			$conTypeObj		= $friendM->fetchRow($friend_cond);
			
			//if logged in user connected with this user
			if(false!==$conTypeObj)
			{
				$con_type		= $conTypeObj->getConnectionType();
				//echo "<br />connection type=".$con_type."<br />";
				
				/*
				if($con_type=="friend" && ($permission==2 || $permission==4))
				{
					$permit = true; //display to Friends & Family AND Friends, Family and Mates
				}
				else if($con_type=="family" && ($permission==2 || $permission==4))
				{
					$permit = true; //display to Friends & Family AND Friends, Family and Mates
				}
				else if($con_type=="travelmate" && ($permission==3 || $permission==4))
				{
					$permit = true; //display to Travel Mates AND Friends, Family and Mates
				}*/
				if($con_type=="friend" && ($permission==2 || $permission==6))
				{
					$permit = true; //display to Friends, Friends & Family 
				}
				else if($con_type=="family" && ($permission==3 || $permission==6))
				{
					$permit = true; //display to Family, Friends & Family
				}
				else if($con_type=="travelmate" && $permission==2)
				{
					$permit = true; //display to Travel Mates Friends
				}
				else
				{
					$permit = false;
				}
			}//end if
			else
			{
				$permit = false;
			}
		}//end if
		
		return $permit;
   }//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 14-Dec-2010
	 * @Description	: Get Nationality name by ID (here country_passport is nationality)
	 * @Input		: none
	 * @Return		: string
	 */
	public function getNationality()
	{
		$country = new Application_Model_Country();
		$nationality = $country->getNationalityName($this->getCountryPassport());
		return 	$nationality;
	}//end function
	
	/**
	* @Created By 	: Mahipal Singh Adhikari
	* @Created On 	: 28-Dec-2010
	* @Description	: Get the Login User and User's connection
	* @Input		: $user_id(int), $friend_id(int)
	* @Return		: returns String(connection type) if exists relation otherwise returns False
	**/
   public function getUserConnection($user_id, $friend_id)
   {
		$connection = false;
		
		//if logged in user viewing own
		if($user_id == $friend_id)
		{
			$connection = "own";
		}
		
		//now if user is logged in i.e. $friend_id is not null, check connection with user
		if((isset($friend_id) && is_numeric($friend_id)))
		{
			$friendM		= new Application_Model_Friend();
			$friend_cond 	= "user_id='{$user_id}' AND friend_id='{$friend_id}' AND status='accept'";
			$conTypeObj		= $friendM->fetchRow($friend_cond);
			
			//if logged in user connected with this user
			if(false!==$conTypeObj)
			{
				$con_type	= $conTypeObj->getConnectionType();
				$connection = $con_type;
			}//end if			
		}//end if
		
		return $connection;
   }//end of function
   
	/**
	* @Created By 	: Mahipal Singh Adhikari
	* @Created On 	: 29-Dec-2010
	* @Description	: Get the list of users
	* @Input		: $user_level(int)
	* @Return		: returns array
	**/
	public function getUsersList($user_level_id=null, $option="")
	{
		$arrUsers = array();
		
		if(!is_null($option))
		{
			$arrUsers[''] = $option;
		}	
		$where = "status='active'";
		if(!is_null($user_level_id))
		{
			$where .= " AND user_level_id={$user_level_id}";
		}
		
		$userRes = $this->fetchAll($where, "first_name ASC");
		foreach($userRes as $row)
		{
			$userName = ucwords($row->getfirstName()." ".$row->getlastName()." (".$row->getusername().")");
			$arrUsers[$row->getId()] = $userName;
		}
		return $arrUsers;  	
	}
	
	// check the status of user
	public function checkUserActiveStatus($user_id)
    {
        $userRes = $this->fetchRow("id={$user_id}");
		if($userRes->getStatus()== 'active')
		{
			return true;
		}	
		else
		{
			return false;
		}
    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 3-Jan-2011
	 * @Description	: Update all tables associated with user while deleting a user from backend
	 * @Input		: $user_id (int) 
	 * @Return		: none
	 */
	public function deleteUserData($user_id)
    {
		$id = trim($user_id);
		
		if(is_numeric($id))
		{
			$db = Zend_Registry::get("db");
			
			//Update user's advice
			$advice = "UPDATE advice SET status='0' WHERE user_id=".$id;
			$db->query($advice);
			
			//Update user's album
			$album = "UPDATE album SET status=0 WHERE user_id=".$id;
			$db->query($album);
			
			//Update user's album photos
			$album_photo = "UPDATE album_photo SET status=0 WHERE user_id=".$id;
			$db->query($album_photo);
			
			//Update user's articles
			//$articles = "UPDATE articles SET status='0' WHERE user_id=".$id;
			//$db->query($articles);
			
			//move articles into deleted table associated with user
			$adSQL	= "INSERT INTO articles_deleted SELECT * FROM articles WHERE user_id={$id}";
			$db->query($adSQL);
			
			//now delete original Articles from table
			$delArticleSQL	= "DELETE FROM articles WHERE user_id={$id}";
			$db->query($delArticleSQL);
			
			//Update user's blogs
			//$blog = "UPDATE blog SET status='private', publish='draft' WHERE user_id=".$id;
			//$db->query($blog);
			
			//move blogs into deleted table associated with user
			$blogSQL	= "INSERT INTO blog_deleted SELECT * FROM blog WHERE user_id={$id}";
			$db->query($blogSQL);
			
			//now delete original Articles from table
			$delBlogSQL	= "DELETE FROM blog WHERE user_id={$id}";
			$db->query($delBlogSQL);			
			
			//Update user's comments
			$comment = "UPDATE comment SET publish='0' WHERE user_id=".$id;
			$db->query($comment);
			
			//Update contact table
			$contact = "UPDATE contact SET status=0 WHERE user_id=".$id;
			$db->query($contact);
			
			//update feeds table
			
			//update friend table
			$friend = "UPDATE friend SET status='deleted' WHERE friend_id=".$id;
			$db->query($friend);
			
			//Update gapper_location table
			$gapper_location = "UPDATE gapper_location SET latest='0' WHERE user_id=".$id;
			$db->query($gapper_location);
			
			//Update journal table
			$journal = "UPDATE journal SET status='private', publish='trash' WHERE user_id=".$id;
			$db->query($journal);
			
			//Update language table
			
			//Update message table(need to discuss)
			//$message = "UPDATE message SET status='trash' WHERE from_id=".$id;
			//$db->query($message);
			
			//Update pages table
			$pages = "UPDATE pages SET status='0' WHERE user_id=".$id;
			$db->query($pages);
			
			//Update poi_recommendation table
			$poi_recommendation = "UPDATE poi_recommendation SET status=0 WHERE user_id=".$id;
			$db->query($poi_recommendation);
			
			//Update user's newsletter subscribe status
			//$subscribe = "UPDATE subscribe SET status=0 WHERE user_id=".$id;
			//$db->query($subscribe);
			
			//Update user_album table
			//$user_album = "UPDATE user_album SET status='trash' WHERE user_id=".$id;
			//$db->query($user_album);
			
			//Delete from user_permission table
			//$user_permission = "DELETE FROM user_permission WHERE user_id=".$id;
			//$db->query($user_permission);
			
			//Update vote table
			$user_album = "UPDATE vote SET vote='-1' WHERE user_id=".$id;
			$db->query($user_album);
			
			//Update wall table
			$wall = "UPDATE wall SET status=0 WHERE user_id=".$id;
			$db->query($wall);
		}//end of if	
		
	}//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 17-Jan-2011
	 * @Description	: Update user newsletter status
	 * @Input		: $user_id (int) , $status->string
	 * @Return		: none
	 */
	public function newsletterSubscribe($user_id, $status=1)
    {
		$user_id = trim($user_id);
		
		if(is_numeric($user_id))
		{
			$db = Zend_Registry::get("db");
			
			//Update user's newsletter status
			//$sSQL = "UPDATE user SET newsletter='{$status}' WHERE id=".$user_id;
			
			$item		= "news";
			$status		= $status;
			$addedon	= time();
			
			//Check if user record already exists in database table
			$subscribeM		=	new Application_Model_Subscribe();
			$subscribeRes	=	$subscribeM->fetchRow("user_id={$user_id}");
			if($subscribeRes)
			{
				$sSQL = "UPDATE subscribe SET status={$status}, updatedon={$addedon} WHERE user_id={$user_id}";
			}
			else
			{
				$sSQL = "INSERT INTO subscribe (user_id, item, status, addedon) values({$user_id}, '{$item}', {$status}, {$addedon})";
			}	
			$db->query($sSQL);
			return true;
		}//end of if
		else
		{
			return false;
		}
		
	}//end of function
}
