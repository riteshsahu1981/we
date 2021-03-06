
<?php
class Application_Model_Appriciation{

    protected $_id;
    protected $_userId;
    protected $_user;
    protected $_appriciationTypeId;
    protected $_appriciationType;
    protected $_appriciationDate;
    protected $_remarks;
    protected $_addedon;
    protected $_updatedon;
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
            throw new Exception('Invalid property specified '.$method );
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
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
            $this->setMapper(new Application_Model_AppriciationMapper());
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

   public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setAppriciationDate($appriciationDate)
    {
        $this->_appriciationDate = (string) $appriciationDate;
        return $this;
    }

    public function getAppriciationDate()
    {
        return $this->_appriciationDate;
    }
    
    public function setAppriciationTypeId($appriciationTypeId)
    {
        $this->_appriciationTypeId = (int) $appriciationTypeId;
        return $this;
    }

    public function getAppriciationTypeId()
    {
        return $this->_appriciationTypeId;
    }
    
    public function setAppriciationType($appriciationType)
    {
        $this->_appriciationType = (string) $appriciationType;
        return $this;
    }

    public function getAppriciationType()
    {
        return $this->_appriciationType;
    }
    
    public function setRemarks($remarks)
    {
        $this->_remarks = (string) $remarks;
        return $this;
    }

    public function getRemarks()
    {
        return $this->_remarks;
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

	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		
            $model = new Application_Model_Appriciation();
            $model->setId($row->id)
                  	->setUserId($row->user_id)
                        ->setRemarks($row->remarks)
                        ->setAppriciationDate($row->appriciation_date)
                        ->setAppriciationTypeId($row->appriciation_type_id)
                	->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                	;
            if($appriciationType=$row->findParentRow("Application_Model_DbTable_AppriciationType",'AppriciationType'))
                $model->setAppriciationType ($appriciationType->title);
            if($user=$row->findParentRow("Application_Model_DbTable_User",'User'))
            {
                $userM=new Application_Model_User();
                $model->setUser($userM->setModel($user));
            }
            
                
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'remarks'   => $this->getRemarks(),
            'user_id'   => $this->getUserId(),
            'appriciation_type_id'      => $this->getAppriciationTypeId(),
            'appriciation_date' => $this->getAppriciationDate()
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
    
    public function fetchRow($where=null,$order=null)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where,$order);

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
    
    public function getLatestAppriciations()
    {
        $appAarr=array();
        $time=mktime(null, null, null, date("m")-1, date("d"), date("Y"));
        $app = $this->fetchAll("DATE_FORMAT(appriciation_date,'%Y-%m')='".date("Y-m")."' or DATE_FORMAT(appriciation_date,'%Y-%m')='".date("Y-m",$time)."'");
        $i=0;
        foreach($app as $a)
        {
            $user=$a->getUser();
            $date=explode("-",$a->getAppriciationDate());
            $time=mktime(null, null, null, $date[1], $date[2], $date[0]);
            
            $appAarr[$i]['appriciation_date']=$a->getAppriciationDate();
            $appAarr[$i]['display_date'] = date("M, Y",$time);
            $appAarr[$i]['remarks']=$a->getRemarks();
            $appAarr[$i]['name']=$user->getFirstName()." ".$user->getLastName();
            $appAarr[$i]['emp_code']=$user->getEmployeeCode();
            $appAarr[$i]['image']=$user->getProfileImage();
            $appAarr[$i]['department']=$user->getDepartment();
            $appAarr[$i]['appriciation_type']=$a->getAppriciationType();
            $i++;
        }
        return $appAarr;
    }
    
}