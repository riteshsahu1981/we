<?php
class Application_Model_Friend
{
  
    protected $_id;
    protected $_userId;
    protected $_friendId;
    protected $_connectionType;
    protected $_status;
    protected $_addedon;
    protected $_updatedon;
    protected $_userObj;
    protected $_friendObj;
    protected $_mapper;
	
	//protected $image;
	//protected $first_name;
	//protected $last_name;
    
     /**
	 * @return the $_updatedon
	 */
	public function get_updatedon() {
		return $this->_updatedon;
	}

	/**
	 * @param $_updatedon the $_updatedon to set
	 */
	public function set_updatedon($_updatedon) {
		$this->_updatedon = $_updatedon;
	}

	public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
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
    
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Friend property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Friend property');
        }
        return $this->$method();
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

	public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
        
	public function setFriendId($friendId)
    {
        $this->_friendId = (int) $friendId;
        return $this;
    }

    public function getFriendId()
    {
    	 return $this->_friendId;
    }    

	public function setConnectionType($connectionType)
    {
        $this->_connectionType = (string) $connectionType;
        return $this;
    }

    public function getConnectionType()
    {
        return $this->_connectionType;
    }
	
	public function setStatus($status)
	{
		$this->_status = (string) $status;
		return $this;
	}
	
	public function getStatus()
	{
		return $this->_status;
	}
	
	public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }

    public function getAddedon()
    {
        return $this->_addedon;
    }
    
	public function setUpdatedon($updatedon)
    {
        $this->_updatedon = (int) $updatedon;
        return $this;
    }

    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
    
	public function setUserObj($userObj)
	{
		$this->_userObj=$userObj;
		return $this;
	}
	public function getUserObj()
	{
		return $this->_userObj;
	}
	
	public function setFriendObj($friendObj)
	{
		$this->_friendObj=$friendObj;
		return $this;
	}
	public function getFriendObj()
	{
		return $this->_friendObj;
	}
	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_FriendMapper());
        }
        
    	return $this->_mapper;
    }
    
    
    
 /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$user=$row->findParentRow('Application_Model_DbTable_User','User');
    	$friend=$row->findParentRow('Application_Model_DbTable_User','Friend');
    	$model=new Application_Model_Friend();
        $model->setId($row->id)
                  ->setUserId($row->user_id)
                  ->setFriendId($row->friend_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setConnectionType($row->connection_type)
                  ->setStatus($row->status)
                  ->setUserObj($user)
                  ->setFriendObj($friend)
                  ;
             return $model;
    }   
    
	public function save()
    {
      	$data = array(
            'friend_id'   => $this->getFriendId(),
        	'user_id' => $this->getUserId(),
  	  		'connection_type'=>$this->getConnectionType(),
  	  	     'status' => $this->getStatus()
  	  		
        );
		
    	if (null === ($id = $this->getId()))
		{
			unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
        	/**
			 * @Added By: Mahipal Adhikari on 23-Dec-2010
			 * @Modification: Following line of code added to update added date of friend request while re-sending(updating) freind request
			 */
			if($this->getAddedon())
			{
				$data['addedon'] = time();
			}
			$data['updatedon']=time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
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
    
    
    public function acceptFriend($friendId,$userId,$type)
    {
    	if($type=='decline')
    	{
    		$this->delete("friend_id=$friendId and user_id=$userId");
    		
    	}
    	if($type=='accept')
    	{
    	   $db=Zend_Registry::get('db');
	       $db->query("update friend set status='accept' where friend_id=$friendId and user_id=$userId");
    	}
    }

    public function getUserFriend($user_id, $detail=false)
    {
        $arrFriend=array();
        $friendM=new Application_Model_Friend();
        $friends=$friendM->fetchAll("user_id='{$user_id}' and status='accept'");
          if(count($friends)>0)
          {
                foreach($friends as $friend)
                {
                    if($detail==false)
                    {
                        $arrFriend[]=$friend->getFriendId();
                    }
                    else
                    {
                        //send friend detail
                    }
                }
            }
            else
            {
                return false;
            }
            return $arrFriend;
    }
    
    public function addAsFriend($sender_id, $user_id)
    {
    	$senderM=new Application_Model_User();
    	if($senderM->find($sender_id))
    	{
    		$this->setFriendId($user_id);
    		$this->setUserId($sender_id);
    		$this->setStatus("accept");
    		$this->setConnectionType("friend");
    		$this->save();
    	}
    }
	public function getThumbnail($profile_image="", $facebook_id="", $sex="")
    {
        $cdnuri = new Base_View_Helper_CdnUri();
		/*
		$userObj		= $this->getUserObj();
		$profile_image	= $userObj->image;
		$facebook_id	= $userObj->facebook_id;
		$sex			= $userObj->sex;
		*/
		//echo "<br>img=>".$image." fac=>".$facebook_id." user id=>".$user_id;
        
		//Set default profile image according to user Gender
		$thumb = $cdnuri->cdnUri()."/images/no_image_female.jpeg";
		if($sex=="male")
		{
			$thumb = $cdnuri->cdnUri()."/images/no-image.jpg";
		}
				
		//now set profile image		
		if($profile_image=="")
        {
            if($facebook_id != "")
            {
                $thumb = "https://graph.facebook.com/".$facebook_id."/picture";
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
    }//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 24-Feb-2011
	 * @Description: Get count of user's friends of any connection type
	 */
	public function countUserFriends($user_id)
    {
		$arrFriend = array();
		$totalFriends	= 0;
		$friends		= 0;
		$family			= 0;
		$travelmate		= 0;
		
		//count total friends connections
		$totalFriendsRes = $this->fetchAll("user_id='{$user_id}' AND status='accept'");
		if(false!==$totalFriendsRes)
		{
			$totalFriends = count($totalFriendsRes);
		}
		//count total friends
		$friendsRes = $this->fetchAll("user_id='{$user_id}' AND connection_type='friend' AND status='accept'");
		if(false!==$friendsRes)
		{
			$friends = count($friendsRes);
		}
		//count total family
		$familyRes = $this->fetchAll("user_id='{$user_id}' AND connection_type='family' AND status='accept'");
		if(false!==$familyRes)
		{
			$family = count($familyRes);
		}
		//count total travelmate
		$travelmateRes = $this->fetchAll("user_id='{$user_id}' AND connection_type='travelmate' AND status='accept'");
		if(false!==$travelmateRes)
		{
			$travelmate = count($travelmateRes);
		}
		$arrFriend = array("totalFriends"=>$totalFriends,"friends"=>$friends,"family"=>$family,"travelmate"=>$travelmate);
		return $arrFriend;
    }//end function
}
