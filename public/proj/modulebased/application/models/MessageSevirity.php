<?php
class Application_Model_MessageSevirity {

    protected $_messageSevirityId;
    protected $_messageSevirityName;
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
            $this->setMapper(new Application_Model_MessageSevirityMapper());
        }
        return $this->_mapper;
    }
    

    public function setMessageSevirityId($messageSevirityId)
    {
      $this->_messageSevirityId = (int) $messageSevirityId;
        return $this;
    }

    public function getMessageSevirityId()
    {
        
        return $this->_messageSevirityId;
    }

   public function setMessageSevirityName($messageSevirityName)
    {
        $this->_messageSevirityName = (string) $messageSevirityName;
        return $this;
    }

    public function getMessageSevirityName()
    {
        return $this->_messageSevirityName;
    }

    public function getCreatedOn()
    {
        return $this->_createdOn;
    }

    public function setCreatedOn($reatedOn)
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
    	
    		
            $model = new Application_Model_MessageSevirity();
            $model->setMessageSevirityId($row->message_sevirity_id)
                  	->setMessageSevirityName($row->message_sevirity_name)
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
            'message_sevirity_name'   => $this->getMessageSevirityName()
            );

        if (null === ($id = $this->getMessageSevirityId())) {
           unset($data['message_sevirity_id']);
             $data['created_by']=$usersNs-userId;
            $data['row_guid']=Base_Uuid::guid();
            $data['created_on']=time();
            
           return $this->getMapper()->getDbTable()->insert($data);
        } else {
           $data['updated_by']=$usersNs-userId;
            $data['updated_on']=time();
            return $this->getMapper()->getDbTable()->update($data, array('message_sevirity_id = ?' => $id));
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
 /*------Data utility functions------*/
    public function getMessageSevirities()
    {
        $obj=new Application_Model_MessageSevirity();
        $entries=$obj->fetchAll();
        $arrMessageSevirity=array();
        foreach($entries as $entry)
        { 	
            $arrMessageSevirity[$entry->getMessageSevirityId()]=$entry->getMessageSevirityName();
        }
        return $arrMessageSevirity;	
    }
    /*------Data utility functions------*/
    
    
    
}
?>
