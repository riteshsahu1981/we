<?php
class Application_Model_Request {

    protected $_id;
    protected $_department; 
    protected $_departmentId; 
    protected $_request;
    protected $_status; //open, close
    protected $_remarks;
    protected $_requestedBy;
    protected $_requestedByObj;
    protected $_userId;
    protected $_user;
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
            $this->setMapper(new Application_Model_RequestMapper());
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

   public function setDepartment($department)
    {
        $this->_department = (string) $department;
        return $this;
    }

    public function getDepartment()
    {
        return $this->_department;
    }

    public function setDepartmentId($departmentId)
    {
        $this->_departmentId = (int) $departmentId;
        return $this;
    }

    public function getDepartmentId()
    {
        return $this->_departmentId;
    }
    public function setRequest($request)
    {
        $this->_request = (string) $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->_request;
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
    
    public function setRemarks($remarks)
    {
        $this->_remarks = (string) $remarks;
        return $this;
    }

    public function getRemarks()
    {
        return $this->_remarks;
    }
    public function setRequestedBy($requestedBy)
    {
        $this->_requestedBy = (int) $requestedBy;
        return $this;
    }

    public function getRequestedBy()
    {
        return $this->_requestedBy;
    }
    public function setRequestedByObj($requestedByObj)
    {
        $this->_requestedByObj =  $requestedByObj;
        return $this;
    }

    public function getRequestedByObj()
    {
        return $this->_requestedByObj;
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
    	
    		
            $model = new Application_Model_Request();
            $model->setId($row->id)
                    ->setDepartmentId($row->department_id)
                    ->setRequest($row->request)
                    ->setStatus($row->status)
                    ->setRequestedBy($row->requested_by)
                    ->setRemarks($row->remarks)
                    ->setUserId($row->user_id)
                    ->setAddedon($row->addedon)
                    ->setUpdatedon($row->updatedon)
                	;
        if($department=$row->findParentRow("Application_Model_DbTable_Department"))
                $model->setDepartment($department->title);
          else
              $model->setDepartment("N/A");
          
          if($user=$row->findParentRow("Application_Model_DbTable_User","User"))
          {
            $userM=new Application_Model_User();
            $user=$userM->setModel($user);
            $model->setUser($user);
          }
          else
              $model->setUser(null);
          
          if($user=$row->findParentRow("Application_Model_DbTable_User","RequestedBy"))
          {
            $userM=new Application_Model_User();
            $user=$userM->setModel($user);
            $model->setRequestedByObj($user);
          }
          else
              $model->setRequestedByObj(null);
          
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'department_id'   => $this->getDepartmentId(),
            'request'   => $this->getRequest(),
            'status'    => $this->getStatus(),
            'requested_by' => $this->getRequestedBy(),
            'remarks' => $this->getRemarks(),
            'user_id'   => $this->getUserId(),
           
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
   
    
}