<?php

class Security_Model_UserRole {
	
	 /**
     * @var int
     */
    protected $_id;
    
    /**
     * @var string
     */
    protected $_identifire;
    
    /**
     * @var string
     */
    protected $_role;
    
    /**
     * @var status
     */
    protected $_status;

     /**
     * @var int
     */
    protected $_addedon;
        

     /**
     * @var int
     */
    protected $_updatedon;
    
   protected $_mapper;
    protected $_createdBy;
    protected $_updatedBy;
    protected $_rowGuid;
    /**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        return $this->$method();
    }

    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Security_Model_User
     */
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
            $this->setMapper(new Security_Model_UserRoleMapper());
        }
        return $this->_mapper;
    }
    
 	/**
     * Set entry id
     * 
     * @param  int $id 
     * @return Security_Model_UserLevel
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Retrieve entry id
     * 
     * @return null|int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set identifire
     * 
     * @param  string $identifire 
     * @return Security_Model_UserLevel
     */
    public function setIdentifire($identifire)
    {
        $this->_identifire= (string) $identifire;
        return $this;
    }

 
    /**
     * Get identifire
     * 
     * @return null|string
     */
    public function getIdentifire()
    {
        return $this->_identifire;
    }
    
   /**
     * Get label
     * 
     * @return null|string
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Set label
     * 
     * @param  string $label 
     * @return Security_Model_UserLevel
     */
    public function setRole($role)
    {
        $this->_role = (string) $role;
        return $this;
    }   

    
     
   	/**
     * Get status
     * 
     * @return null|string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Set status
     * 
     * @param  string $status 
     * @return Security_Model_UserLevel
     */
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    

   	/**
     * Get addedon
     * 
     * @return null|int
     */
    public function getAddedon()
    {
        return $this->_addedon;
    }

    /**
     * Set addedon
     * 
     * @param  int $addedon 
     * @return Security_Model_UserLevel
     */
    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    
 
   	/**
     * Get updated
     * 
     * @return null|int
     */
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
    /**
     * Set updatedon
     * 
     * @param  int $updatedon 
     * @return Security_Model_UserLevel
     */
    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
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
    
    public function getupdatedBy()
    {
        return $this->_updatedBy;
    }

    public function setUpdatedBy($updatedby)
    {
        $this->_updatedBy = (int) $updatedby;
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

	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
 			$model = new Security_Model_UserRole();
            $model->setId($row->id)
                 ->setIdentifire($row->identifire)
                  ->setRole($row->role)
                  ->setStatus($row->status)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setRowGuid($row->row_guid)
                  ->setCreatedBy($row->created_by)
                  ->setUpdatedBy($row->updated_by)
                  ;
    	
             return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  $usersNs-userId;
    	$data = array(
                'identifire'   => $this->getIdentifire(),
        	'role'   => $this->getRole(),
        	'status'   => $this->getStatus(),
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time(); 
            $data['created_by']=$usersNs-userId;
            $data['row_guid']=Base_Uuid::guid();
          return  $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updated_by']=$usersNs-userId;
        	$data['updatedon']=time();
        	
          return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
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
    /*----Data Manupulation functions ----*/    

    /*------Data utility functions------*/
    public function getUserRole()
    {
    	$obj=new Security_Model_UserRole();
         $entries=$obj->fetchAll("status='active'");
         $arrUserRole=array();
         foreach($entries as $entry)
         { 	
         	$arrUserRole[$entry->getId()]=$entry->getRole();
         }
         return $arrUserRole;	
    }
    /*------Data utility functions------*/
    
}

?>