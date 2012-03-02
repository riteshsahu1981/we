<?php

class Application_Model_DatabaseConfig {
    protected $_dbcnfId;
    protected $_configId;
    protected $_dbServerName;
    protected $_dbServerPort;
    protected $_dbName;
    protected $_dbUser;
    protected $_dbPassword;
    protected $_dbTransType;
    protected $_status;
    protected $_createdOn;
    protected $_updatedOn;
    protected $_mapper;
    protected $_createdBy;
    protected $_updatedBy;
    protected $_rowGuid;
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
            $this->setMapper(new Application_Model_DatabaseConfigMapper());
        }
        return $this->_mapper;
    }
    public function setDbcnfId($dbcnfId)
    {
    $this->_dbcnfId = (int) $dbcnfId;
        return $this;
    }
    public function getDbcnfId()
    {
        return $this->_dbcnfId;
    }
    public function setConfigId($configId)
    {
        $this->_configId= (int) $configId;
        return $this;
    }
    public function getConfigId()
    {
        return $this->_configId;
    }
  
    public function getDbServerName()
    {
        return $this->_dbServerName;
    }
    public function setDbServerName($dbServerName)
    {
        $this->_dbServerName = (string) $dbServerName;
        return $this;
    }
    
    public function getDbServerPort()
    {
        return $this->_dbServerPort;
    }
    public function setDbServerPort($dbServerPort)
    {
        $this->_dbServerPort = (int) $dbServerPort;
        return $this;
    }
    
    public function getDbName()
    {
        return $this->_dbName;
    }
    public function setDbName($dbName)
    {
        $this->_dbName = (string) $dbName;
        return $this;
    }
     public function getDbUser()
    {
        return $this->_dbUser;
    }
    public function setDbUser($dbUser)
    {
        $this->_dbUser = (string) $dbUser;
        return $this;
    }
     public function getDbPassword()
    {
        return $this->_dbPassword;
    }
    public function setDbPassword($dbPassword)
    {
        $this->_dbPassword = (string) $dbPassword;
        return $this;
    }
      public function getDbTransType()
    {
        return $this->_dbTransType;
    }
    public function setDbTransType($dbTransType)
    {
        $this->_dbTransType = (string) $dbTransType;
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
    public function getUpdatedOn()
    {
        return $this->_updatedOn;
    }
    public function setUpdatedOn($updatedOn)
    {
        $this->_updatedOn= (int) $updatedOn;
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
 		$model = new Application_Model_DatabaseConfig();
                $model->setDbcnfId($row->dbcnf_id)
                  ->setConfigId($row->config_id)
                  ->setDbServerName($row->db_server_name)
                  ->setDbServerPort($row->db_server_port)
                  ->setDbName($row->db_name)
                  ->setDbUser($row->db_user)
                  ->setDbPassword($row->db_password)
                  ->setDbTransType($row->db_trans_type)
                  ->setStatus($row->status)
                  ->setRowGuid($row->row_guid)
                  ->setCreatedBy($row->created_by)
                  ->setUpdatedBy($row->updated_by)
                  ;
    	     return $model;
    }
    
    public function save()
    {
        $usersNs = new Zend_Session_Namespace("members");  $usersNs-userId;
         $datetime = date("Y-m-d H:i:s"); 
    	$data = array(
                'dbcnf_id'   => $this->getDbcnfId(),
        	'config_id'   => $this->getConfigId(),
                'db_server_name'   => $this->getDbServerName(),
                'db_server_port'   => $this->getDbServerPort(),
                'db_name'   => $this->getDbName(),
                'db_user'   => $this->getDbUser(),
                'db_password'   => $this->getDbPassword(),
                'db_trans_type'   => $this->getDbTransType(),
                'status'   => $this->getStatus(),
             );

        if (null === ($id = $this->getDbcnfId())) {
            unset($data['dbcnf_id']);
            $data['created_on']=$datetime; 
            $data['created_by']=$usersNs-userId;
            $data['row_guid']=Base_Uuid::guid();
            
          return  $this->getMapper()->getDbTable()->insert($data);
            
        } else {
                   
        	$data['updated_by']=$usersNs-userId;
        	$data['updated_on']=$datetime;
        	return $this->getMapper()->getDbTable()->update($data, array('dbcnf_id = ?' => $id));
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
    /*------Data utility functions------*/
    
}

?>