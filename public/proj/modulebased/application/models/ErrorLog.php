<?php
class Application_Model_ErrorLog {
    protected $_logId;
    protected $_msgId;
    protected $_machineName;
    protected $_appName;
    protected $_processName;
    protected $_moduleName;
    protected $_methodName;
    protected $_logMessage;
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
            $this->setMapper(new Application_Model_ErrorLogMapper());
        }
        return $this->_mapper;
    }
    

    public function setLogId($logId)
    {
      $this->_logId = (int) $logId;
        return $this;
    }
    public function getLogId()
    {
        return $this->_logId;
    }

    public function getMsgId()
    {
        return $this->_msgId;
    }

   public function setMsgId($msgId)
    {
        $this->_msgId = (int) $msgId;
        return $this;
    }

    public function setMachineName($machineName)
    {
        $this->_machineName= (string) $machineName;
        return $this;
    }

    public function getMachineName()
    {
        return $this->_machineName;
    }
   public function setAppName($appName)
    {
        $this->_appName= (string) $appName;
        return $this;
    }

    public function getAppName()
    {
        return $this->_appName;
    }
    
    public function setProcessName($processName)
    {
        $this->_processName= (string) $processName;
        return $this;
    }

    public function getProcessName()
    {
        return $this->_processName;
    }
    
    public function setModuleName($moduleName)
    {
        $this->_moduleName= (string) $moduleName;
        return $this;
    }

    public function getModuleName()
    {
        return $this->_moduleName;
    }
    public function setMethodName($methodName)
    {
        $this->_methodName= (string) $methodName;
        return $this;
    }

    public function getMethodName()
    {
        return $this->_methodName;
    }
    public function setLogMessage($logMessage)
    {
        $this->_logMessage= (string) $logMessage;
        return $this;
    }

    public function getLogMessage()
    {
        return $this->_logMessage;
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
    	
    		
            $model = new Application_Model_ErrorLog();
            $model->setLogId($row->log_id)
                  	->setMsgId($row->msg_id)
                        ->setMachineName($row->machine_name)
                        ->setAppName($row->app_name)
                        ->setProcessName($row->process_name)
                        ->setModuleName($row->module_name )
                        ->setMethodName($row->method_name)
                        ->setLogMessage($row->log_message)
                        ->setCreatedOn($row->created_on)
                        ->setUpdatedon($row->updated_on)
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
                        'msg_id'   => $this->getMsgId(),
                        'machine_name'   => $this->getMachineName(),
                        'app_name'   => $this->getAppName(),
                        'process_name'   => $this->getProcessName(),
                        'module_name'   => $this->getModuleName(),
                        'method_name'   => $this->getMethodName(),
                        'log_message'   => $this->getLogMessage(),
              );

        if (null === ($id = $this->getLogId())) {
           unset($data['log_id']);
             $data['created_by']=$usersNs-userId;
            $data['row_guid']=Base_Uuid::guid();
            $data['created_on']=time();
            
           return $this->getMapper()->getDbTable()->insert($data);
        } else {
           $data['updated_by']=$usersNs-userId;
           $data['updated_on']=time();
            return $this->getMapper()->getDbTable()->update($data, array('log_id = ?' => $id));
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
 /*------Data utility functions start------*/
 /*------Data utility functions end------*/
    
    
    
}
?>
