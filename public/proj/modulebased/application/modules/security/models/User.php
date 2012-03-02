<?php
class Security_Model_User {
    
    protected $_id;
    protected $_email;
    protected $_username;
    protected $_password;
    protected $_firstName;
    protected $_middleName;
    protected $_lastName;
    protected $_mobile;
    protected $_dob;
    protected $_sex;
    protected $_profilePicture;
    protected $_status;
    protected $_groupId;
    protected $_subGroupId;
    protected $_roleId;
    protected $_correspondenceAddress;
    protected $_createdOn;
    protected $_updatedOn;
    
    protected $_createdBy;
    protected $_updatedBy;
    protected $_userThumbImage;
    protected $_userProfileImage;
    protected $_mapper;
    
    protected $_rowGuid;
    protected $_rowVersion;
    protected $_rowMaxId;

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
            $this->setMapper(new Security_Model_UserMapper());
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

    public function getMiddleName()
    {
        return $this->_middleName;
    }

    public function setMiddleName($middleName)
    {
        $this->_middleName = (string) $middleName;
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
    
    public function getProfilePicture()
    {
        return $this->_profilePicture;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->_profilePicture = (string) $profilePicture;
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
    
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }

    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = (int) $createdOn;
        return $this;
    }
    
     public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function setCreatedBy($createdby)
    {
        $this->_createdBy = (int) $createdby;
        return $this;
    }  
    
    public function getUpdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setUpdatedBy($updatedby)
    {
        $this->_updatedBy = (int) $updatedby;
        return $this;
    }
    
    public function getUpdatedOn()
    {
        return $this->_updatedOn;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->_updatedOn= (int) $updatedOn;
        return $this;
    }

    public function getRoleId()
    {
        return $this->_roleId;
    }

    public function setRoleId($roleId)
    {
        $this->_roleId= (int) $roleId;
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
    
   
    public function getGroupId()
    {
        return $this->_groupId;
    }

    public function setGroupId($groupId)
    {
        $this->_groupId= (int) $groupId;
        return $this;
    }
    public function getSubGroupId()
    {
        return $this->_subGroupId;
    }

    public function setSubGroupId($subGroupId)
    {
        $this->_subGroupId= (int) $subGroupId;
        return $this;
    }
    public function getCorrespondenceAddress()
    {
        return $this->_correspondenceAddress;
    }

    public function setCorrespondenceAddress($correspondenceAddress)
    {
        $this->_correspondenceAddress= (string) $correspondenceAddress;
        return $this;
    }
  
  
    public function setRowGuid($rowguid)
    {
        $this->_rowGuid = (int) $rowguid;
        return $this;
    }

    public function getRowGuid()
    {
        return $this->_rowGuid;
    }
       
    
    public function getRowMaxId()
    {
        return $this->_rowMaxId;
    }

    public function setRowMaxId($rowMaxId)
    {
        $this->_rowMaxId= (int) $rowMaxId;
        return $this;
    }
    public function getRowVersion()
    {
        return $this->_rowVersion;
    }

    public function setRowVersion($rowVersion)
    {
        $this->_rowVersion= (int) $rowVersion;
        return $this;
    }
	/*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      $model = new Security_Model_User();
      $model->setId($row->id)
            ->setEmail($row->email)
            ->setUsername($row->username)
            ->setPassword($row->password)
            ->setFirstName($row->first_name)
            ->setMiddleName($row->middle_name)
            ->setLastName($row->last_name)
            ->setDob($row->dob)
            ->setSex($row->sex)
            ->setProfilePicture($row->profile_picture)
            ->setMobile($row->mobile)                  
            ->setStatus($row->status)
            ->setGroupId($row->group_id)
            ->setSubGroupId($row->sub_group_id)
            ->setRoleId($row->role_id)
            ->setCorrespondenceAddress($row->correspondence_address)
            ->setCreatedOn($row->created_on)
            ->setUpdatedOn($row->updated_on)
            ->setCreatedBy($row->created_by)
            ->setUpdatedBy($row->updated_by)
            ->setRowGuid($row->row_guid)
            ->setRowVersion($row->row_version)
            ->setRowMaxId($row->row_max_id)
						;
        
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  
     	$data = array(
                'email'   		=> $this->getEmail(),
     		'username'   		=> $this->getUsername(),
        	'password'  		=> $this->getPassword(),
        	'first_name'		=> $this->getFirstName(),
                'middle_name'           => $this->getMiddleName(),
        	'last_name' 		=> $this->getLastName(),
        	'dob'   		=> $this->getDob(),
     		'sex'   		=> $this->getSex(),
                'profile_picture'   	=> $this->getProfilePicture(), 
     		'mobile'                => $this->getMobile(),
        	'status'		=> $this->getStatus(),
                'correspondence_address'=> $this->getCorrespondenceAddress(),
                'group_id'              => $this->getGroupId(),
                'sub_group_id'          => $this->getSubGroupId(),
        	'role_id'		=> $this->getRoleId(),
            );

        if (null === ($id = $this->getId())) 
        {
            $Db=new Base_Db();
            $id=$Db->genId("user", 'id');
            if(false!==$id)
            {
                $data['id']=$id;
                $data['created_by']=$usersNs->userId;
                $data['row_guid']=Base_Uuid::guid();
                $data['created_on']=time();
                $data['row_version']=0;
                if($this->getMapper()->getDbTable()->insert($data))
                {
                   return $id; 
                }
                
            }
            else
            {
                return false;
            }
        } 
        else 
        {
            $data['updated_by']=$usersNs->userId;
            $data['updated_on']=time();
            $data['row_version']=$this->getRowVersion() + 1;
            $res=$this->getMapper()->getDbTable()->update($data, array("id = '$id' and row_version = '{$this->getRowVersion()}'" ));
            if(1==$res)
                return true;
            else
                return false;
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
    	$user=new Security_Model_User();
    	$user=$user->fetchRow("username='{$username}'");
    	return $user;
    }
    
    public function uploadProfilePicture($id,$options)
    {
        $model=new Security_Model_User();
        $model=$model->find($id);
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->isValid('profilePicture'))
        {
            $upload->setDestination("media/picture/profile/");
            try
            {
                  $upload->receive('profilePicture');
             }
             catch (Zend_File_Transfer_Exception $e)
             {
                    $msg= $e->getMessage();
             }

             $upload->setOptions(array('useByteString' => false));

             $file_name = $upload->getFileName('profilePicture');
             $cardImageTypeArr = explode(".", $file_name);
             $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
             $target_file_name = "profile_".$id.".{$ext}";
             $targetPath = 'media/picture/profile/'.$target_file_name;
             $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
             $filterFileRename -> filter($file_name);
             $options['profilePicture'] = $target_file_name;


            /*--- Generate Thumbnail ---*/
            $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
            $thumb->resize(100,100);
            $thumb->save('media/picture/profile/thumb_'.$target_file_name);
            
             /*--- Generate Profile Picture ---*/
            $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
            $thumb->resize(200,200);
            $thumb->save('media/picture/profile/profile_'.$target_file_name);
            
            $model->setProfilePicture($options['profilePicture']);
            return $model->save();
        }
    }//end of function
    
    public function getUserThumbImage()
    {
        if (null === $this->_userThumbImage)
        {
            if($this->_profilePicture<>""){
            $thumbImage="thumb_".$this->_profilePicture;
            $this->setUserThumbImage($thumbImage);
            }
        }
        
    	return $this->_userThumbImage;
    }
    
    public function setUserThumbImage($thumbImage)
    {
    	$this->_userThumbImage=(string)$thumbImage;
    	return $this;
    }//end of function
    
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
        if(is_file("media/picture/profile/".$profile_image))
        {
            $thumb = $cdnuri->cdnUri()."/media/picture/profile/$profile_image";
        }
        return $thumb;
    }//end of function
    
    
    public function getUserProfileImage()
    {
        if (null === $this->_userProfileImage)
        {
            if($this->_profilePicture<>""){
                $profileImage="profile_".$this->_profilePicture;
                $this->setUserProfileImage($profileImage);
            }
        }
        
    	return $this->_userProfileImage;
    }
    
    public function setUserProfileImage($profileImage)
    {
    	$this->_userProfileImage=(string)$profileImage;
    	return $this;
    }//end of function
    
    public function getProfileImage()
    {
        $profile_image=$this->getUserProfileImage();
        $cdnuri=new Base_View_Helper_CdnUri();
		
        //Set default profile image according to user Gender
        $thumb = $cdnuri->cdnUri()."/images/no_image_female.jpeg";
        if($this->_sex=="male")
        {
            $thumb = $cdnuri->cdnUri()."/images/no-image.jpg";
        }
        
        if(is_file("media/picture/profile/".$profile_image))
        {
            $thumb = $cdnuri->cdnUri()."/media/picture/profile/$profile_image?".rand(1,63);
        }
        return $thumb;
    }//end of function
    
    
   
    
    public function getBirthdayGuys()
    {
        $arrBG=array();
        $users=$this->fetchAll("DATE_FORMAT(dob, '%m-%d')='".date("m-d")."' and status='active'");
        $i=0;
        foreach($users as $_user)
        {
            $arrBG[$i]['id']=$_user->getId();
            $arrBG[$i]['name']=$_user->getFirstName()." ".$_user->getLastName();
            $arrBG[$i]['email']=$_user->getEmail();
            $arrBG[$i]['image']=$_user->getProfileImage();
            $arrBG[$i]['role']=$_user->getGroup();
            $i++;
        }
        return $arrBG;
    }
    
    
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Security_Model_User();
        if($status=="")
            $entries=$obj->fetchAll();
        else
             $entries=$obj->fetchAll("status='active'");
        $arrUserLevel=array(''=>"Select");
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getFirstName()." ".$entry->getLastName() ;
        }
        return $arrUserLevel;	
    }
    
    public function getids()
    {
        $obj=new Security_Model_User();
        $entries=$obj->fetchAll();
        $arrUser=array();
        foreach($entries as $entry)
        { 	
            $arrUser[$entry->getId()]=$entry->getUsername();
        }
        return $arrUser;	
    }
  
}
