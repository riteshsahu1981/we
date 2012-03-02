<?php
class Application_Model_Message {
    protected $_id;
    protected $_parentId;
	protected $_read;
    protected $_status;
    protected $_toId;
    protected $_fromId;
    protected $_subject;
    protected $_body;
    protected $_updateDate;
    protected $_addedDate;
    protected $_userTo;
    protected $_userFrom;
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
        	
        	   	$this->setMapper(new Application_Model_MessageMapper());
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
    
    public function setParentId($parentId)
    {
        $this->_parentId = (int) $parentId;
        return $this;
    }

    public function getParentId()
    {
        return $this->_parentId;
    }
	
	public function setRead($read)
    {
        $this->_read = (int) $read;
        return $this;
    }

    public function getRead()
    {
        return $this->_read;
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
   
	public function setToId($toId)
    {
        $this->_toId = (int) $toId;
        return $this;
    }
	
    public function getToId()
    {
        return $this->_toId;
    }
    
    public function getFromId()
    {
        return $this->_fromId;
    }
    
    public function setFromId($fromId)
    {
        $this->_fromId = (int) $fromId;
        return $this;
    }  
    
    public function setSubject($subject)
    {
        $this->_subject = (string) $subject;
        return $this;
    }

    public function getSubject()
    {
        return $this->_subject;
    }
    
    public function getBody()
    {
       
    	return $this->_body;
    }

    public function setBody($body)
    {
        
    	$this->_body = (string) $body;
        return $this;
    }
    
    public function getAddedDate()
    {
       
    	return $this->_addedDate;
    }

    public function setAddedDate($addedDate)
    {
        
    	$this->_addedDate = (int) $addedDate;
        return $this;
    }    
    
  
    
    public function setUserTo($userTo)
	{
		$this->_userTo=$userTo;
		return $this;
	}
	
	
	public function getUserTo()
	{
		return $this->_userTo;
	}
    
    public function setUserFrom($userFrom)
	{
		$this->_userTo=$userFrom;
		return $this;
	}
	
	
	public function getUserFrom()
	{
		return $this->_userFrom;
	}
    
    
    public function getUpdateDate()
    {
        return $this->_updateDate;
    }

    public function setUpdateDate($updateDate)
    {
        $this->_updateDate = (string) $updateDate;
        return $this;
    }
    
	    
    public function save()
    {
     	
     		$data = array(
         	'status'   					=> $this->getStatus(),
			'read'						=> $this->getRead(),
        	'to_id'  					=> $this->getToId(),
     		'parent_id'					=> $this->getParentId(),
     		'from_id'     				=> $this->getFromId(),
     		'subject'  					=> $this->getSubject(),
        	'body'						=> $this->getBody(),
         	);
     		
     		
    	if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon'] = time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updatedon'] = time();
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
        $res = $this->setModel($row);
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
    
    /*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
    	     $userTo=$row->findParentRow('Application_Model_DbTable_User','To');
    	    $userFrom=$row->findParentRow('Application_Model_DbTable_User','To');
           
    	    $model = new Application_Model_Message();
            $model->setId($row->id)
						->setStatus($row->status)
						->setRead($row->read)
						->setToId($row->to_id)
						->setFromId($row->from_id)
	                  	->setSubject($row->subject)
	                  	->setBody($row->body)
	                  	->setAddedDate($row->addedon)
	                  	->setUpdateDate($row->updatedon)
	                  	->setUserTo($userTo)
	                  	->setUserFrom($userFrom)
	                  	;
    	
             return $model;
    }
    
    public function fetchRow($where)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);
       	
 		return $row;       	
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    
   
}