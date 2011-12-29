<?php
class Application_Model_User {
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
    
    protected $_doj;
    protected $_marriageAnniversary;
    protected $_fatherName;
    protected $_designationId;
    protected $_departmentId;
    protected $_correspondenceAddress;
    protected $_pan;
    protected $_contactNo;
    protected $_extensionNo;
    protected $_employeeCode;
    protected $_skype;
    protected $_addedon;
    protected $_updatedon;
    protected $_userLevelId;
    
    protected $_userThumbImage;
    protected $_userProfileImage;
    protected $_mapper;
    
    protected $_designation;
    protected $_department;

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
    
    public function getMobile()
    {
        return $this->_mobile;
    }

    public function setMobile($mobile)
    {
        $this->_mobile= (string) $mobile;
        return $this;
    }
    
    public function getDoj()
    {
        return $this->_doj;
    }

    public function setDoj($doj)
    {
        $this->_doj= (string) $doj;
        return $this;
    }
    public function getMarriageAnniversary()
    {
        return $this->_marriageAnniversary;
    }

    public function setMarriageAnniversary($marriageAnniversary)
    {
        $this->_marriageAnniversary= (string) $marriageAnniversary;
        return $this;
    }
    public function getFatherName()
    {
        return $this->_fatherName;
    }

    public function setFatherName($fatherName)
    {
        $this->_fatherName= (string) $fatherName;
        return $this;
    }
    public function getDesignationId()
    {
        return $this->_designationId;
    }

    public function setDesignationId($designationId)
    {
        $this->_designationId= (int) $designationId;
        return $this;
    }
    public function getDepartmentId()
    {
        return $this->_departmentId;
    }

    public function setDepartmentId($departmentId)
    {
        $this->_departmentId= (int) $departmentId;
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
    public function getPan()
    {
        return $this->_pan;
    }

    public function setPan($pan)
    {
        $this->_pan= (string) $pan;
        return $this;
    }
    public function getContactNo()
    {
        return $this->_contactNo;
    }

    public function setContactNo($contactNo)
    {
        $this->_contactNo= (string) $contactNo;
        return $this;
    }
    
    public function getExtensionNo()
    {
        return $this->_extensionNo;
    }

    public function setExtensionNo($extensionNo)
    {
        $this->_extensionNo= (string) $extensionNo;
        return $this;
    }
       
    public function getSkype()
    {
        return $this->_skype;
    }

    public function setSkype($skype)
    {
        $this->_skype= (string) $skype;
        return $this;
    }
    
    public function getEmployeeCode()
    {
        return $this->_employeeCode;
    }

    public function setEmployeeCode($employeeCode)
    {
        $this->_employeeCode= (string) $employeeCode;
        return $this;
    }
    
    public function getDesignation()
    {
        return $this->_designation;
    }

    public function setDesignation($designation)
    {
        $this->_designation= (string) $designation;
        return $this;
    }
    
    public function getDepartment()
    {
        return $this->_department;
    }

    public function setDepartment($department)
    {
        $this->_department= (string) $department;
        return $this;
    }
	/*----Data Manupulation functions ----*/
    
    public function setModel($row)
    {
      
      $model = new Application_Model_User();
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
            ->setDoj($row->doj)    
            ->setMarriageAnniversary($row->marriage_anniversary)
            ->setFatherName($row->father_name)
            ->setDesignationId($row->designation_id)
            ->setDepartmentId($row->department_id)
            ->setCorrespondenceAddress($row->correspondence_address)
            ->setPan($row->pan)
            ->setContactNo($row->contact_no)
            ->setExtensionNo($row->extension_no)
            ->setSkype($row->skype)
            ->setEmployeeCode($row->employee_code)
            ->setAddedon($row->addedon)
            ->setUpdatedon($row->updatedon)
            ->setUserLevelId($row->user_level_id)
						;
          if($designation=$row->findParentRow("Application_Model_DbTable_Designation"))
                $model->setDesignation($designation->title);
          else
              $model->setDesignation("N/A");
          
          if($department=$row->findParentRow("Application_Model_DbTable_Department"))
                $model->setDepartment($department->title);
          else
              $model->setDepartment("N/A");
             return $model;
    }
    
    
    public function save()
    {
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
                'doj'                   => $this->getDoj(),
                'marriage_anniversary'  => $this->getMarriageAnniversary(),
                'correspondence_address'=> $this->getCorrespondenceAddress(),
                'pan'                   => $this->getPan(),
                'contact_no'            => $this->getContactNo(),
                'extension_no'          => $this->getExtensionNo(),
                'skype'                 => $this->getSkype(),
                'employee_code'            => $this->getEmployeeCode(),
                'father_name'            => $this->getFatherName(),
                'designation_id'            => $this->getDesignationId(),
                'department_id'            => $this->getDepartmentId(),
        	'user_level_id'		=> $this->getUserLevelId()
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
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
    
    public function uploadProfilePicture($id,$options)
    {
        $model=new Application_Model_User();
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
    
    
    public function getLeaveBalance($userId=null)
    {
        if(is_null($userId))
            $userId=$this->getId();
        $userLeaveAccount=new Application_Model_UserLeaveAccount();
        $leaveType=new Application_Model_LeaveType();
        $leaveType=$leaveType->fetchAll();
        foreach($leaveType as $lt)
        {
            //current financial year 20011-04-01 00:00:00 to 2012-03-31 00:00:00
            $credited=$userLeaveAccount->getBalanceLeave($lt->getId(),'credit',$userId);
            $debited=$userLeaveAccount->getBalanceLeave($lt->getId(),'debit',$userId);
            $balance=$credited-$debited;
            $arrLaveBalance[]=Array("id"=>$lt->getId(), "title"=>$lt->getTitle(), "debited"=>$debited,"credited"=>$credited, "balance"=>$balance );
        }
        return $arrLaveBalance;
        
    }
    
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
            $arrBG[$i]['emp_code']=$_user->getEmployeeCode();
            $arrBG[$i]['image']=$_user->getProfileImage();
            $arrBG[$i]['department']=$_user->getDepartment();
            $i++;
        }
        return $arrBG;
    }
    
    
    /*------Data utility functions------*/
    public function getAllUsers($status="")
    {
        $obj=new Application_Model_User();
        if($status=="")
            $entries=$obj->fetchAll();
        else
             $entries=$obj->fetchAll("status='active'");
        $arrUserLevel=array(''=>"Select");
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getFirstName()." ".$entry->getLastName()." - [ Code:".$entry->getEmployeeCode()." ]";
        }
        return $arrUserLevel;	
    }
    
    public function getLatestNotice()
    {
        $notice=new Application_Model_Notice();
        return $notice->getLatestNotice();
    }
    
    public function getLatestAppriciations()
    {
        $obj=new Application_Model_Appriciation();
        return $obj->getLatestAppriciations();
    }
    /*------Data utility functions------*/
    
    public function uploadEmployeeSheet()
    {
        $targetPath=false;
        $upload = new Zend_File_Transfer_Adapter_Http();
        if($upload->isValid('employeeSheet'))
        {
            $upload->setDestination("media/employee/");
            try
            {
                  $upload->receive('employeeSheet');
             }
             catch (Zend_File_Transfer_Exception $e)
             {
                    $msg= $e->getMessage();
             }

             $upload->setOptions(array('useByteString' => false));

             $file_name = $upload->getFileName('employeeSheet');
             $cardImageTypeArr = explode(".", $file_name);
             $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
             $target_file_name = "employee_".date("Y_m_d_H_i_s").".{$ext}";
             $targetPath = 'media/employee/'.$target_file_name;
             $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
             $filterFileRename -> filter($file_name);
        }
        return $targetPath;
    }
    
    public function importEmployee($options, $targetPath)
    {
        
        include_once LIBRARY_PATH."/Base/Excel/PHPExcel.php";
       $objPHPExcel = new PHPExcel();
       $objPHPExcel = PHPExcel_IOFactory::load($targetPath);

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
        {
            if($worksheet->getTitle()=="user")
            {
                $rowctr=0;
                $insertctr=0;
                $updatectr=0;
                foreach ($worksheet->getRowIterator() as $row) 
                {
                    if($row->getRowIndex()!=1)
                    {
                       $options['employeeCode']=$worksheet->getCell("A".$row->getRowIndex())->getCalculatedValue();
                       $options['email']=$worksheet->getCell("B".$row->getRowIndex())->getCalculatedValue();
                       $options['username']=$worksheet->getCell("C".$row->getRowIndex())->getCalculatedValue();
                       //$options['password']=$worksheet->getCell("D".$row->getRowIndex())->getCalculatedValue();
                       $options['firstName']=$worksheet->getCell("E".$row->getRowIndex())->getCalculatedValue();
                       $options['middleName']=$worksheet->getCell("F".$row->getRowIndex())->getCalculatedValue();
                       $options['lastName']=$worksheet->getCell("G".$row->getRowIndex())->getCalculatedValue();
                       $options['dob']=$worksheet->getCell("H".$row->getRowIndex())->getCalculatedValue();
                       $options['sex']=$worksheet->getCell("I".$row->getRowIndex())->getCalculatedValue();
                       $options['mobile']=$worksheet->getCell("J".$row->getRowIndex())->getCalculatedValue();
                       $options['contactNo']=$worksheet->getCell("K".$row->getRowIndex())->getCalculatedValue();
                       $options['extensionNo']=$worksheet->getCell("L".$row->getRowIndex())->getCalculatedValue();
                       $options['skype']=$worksheet->getCell("M".$row->getRowIndex())->getCalculatedValue();
                       $options['doj']=$worksheet->getCell("N".$row->getRowIndex())->getCalculatedValue();
                       $options['marriageAnniversary']=$worksheet->getCell("O".$row->getRowIndex())->getCalculatedValue();
                       $options['fatherName']=$worksheet->getCell("P".$row->getRowIndex())->getCalculatedValue();
                       $options['correspondenceAddress']=$worksheet->getCell("Q".$row->getRowIndex())->getCalculatedValue();
                       $options['pan']=$worksheet->getCell("R".$row->getRowIndex())->getCalculatedValue();
                       $options['designationId']=$worksheet->getCell("S".$row->getRowIndex())->getCalculatedValue();
                       $options['departmentId']=$worksheet->getCell("T".$row->getRowIndex())->getCalculatedValue();
                       $options['status']='active';
                        
                        if($options['designationId']==""){$options['designationId']='15';} //other
                        if($options['departmentId']==""){$options['departmentId']='10';} //other
                        
                        if($options['employeeCode']=="53")
                        {
                            $options['userLevelId']='2';//super admin
                            $options['password']="2e355c62e2700da907332157c85b44d4";
                        }
                        elseif($options['employeeCode']=="2")
                        {
                            $options['userLevelId']='3'; //hr
                            $options['username']=$options['email'];
                        }
                        elseif($options['employeeCode']=="5")
                        {
                            $options['userLevelId']='4'; //pm
                            $options['username']=$options['email'];
                        }
                        else
                        {
                            $options['userLevelId']='1'; //employee
                            $options['username']=$options['email'];
                        }
            
                       $user=new Application_Model_User();
                       $user=$user->fetchRow("employee_code='{$options['employeeCode']}'");
                       if(false===$user)
                       {
                           //insert
                           $user=new Application_Model_User($options);
                           if($user->save()>0)
                               $insertctr++;
                       }
                       else
                       {
                           //update
                           $user->setOptions($options);
                           if($user->save())
                               $updatectr++;
                       }

                       $rowctr++;
                    }
                }//end of row iterator foreach
            }// If worksheet = Sheet1 
        }// end of worksheet iterator foreach
        
        return $rowctr;
        
    }
}
