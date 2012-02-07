<?php
class Application_Model_Contact
{
    protected $_id;
    protected $_contactName;
    protected $_contactEmail;
    protected $_contactReason;
    protected $_userId;
    protected $_created;
	protected $_modified;
    protected $_mapper;
	protected $_status;

    public function __construct(array $options = null)
    {
        if (is_array($options))
		{
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Invalid Contact property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Invalid Contact property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value)
		{
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods))
			{
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
        if (null === $this->_mapper)
		{
            $this->setMapper(new Application_Model_ContactMapper());
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
    
    public function setContactName($contactName)
    {
        $this->_contactName = (string) $contactName;
        return $this;
    }
    public function getContactName()
    {
        return $this->_contactName;
    }    
 
	public function setContactEmail($contactEmail)
    {
        $this->_contactEmail = (string) $contactEmail;
        return $this;
    }
    public function getContactEmail()
    {
        return $this->_contactEmail;
    }
	
	public function setContactReason($contactReason)
    {
        $this->_contactReason = (string) $contactReason;
        return $this;
    }
    public function getContactReason()
    {
        return $this->_contactReason;
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


	public function setCreated($created)
    {
        $this->_created = (string) $created;
        return $this;
    }
    public function getCreated()
    {
        return $this->_created;
    }
	
	public function setModified($modified)
    {
        $this->_modified = (string) $modified;
        return $this;
    }
    public function getModified()
    {
        return $this->_modified;
    }
	
	public function setStatus($status)
    {
        $this->_status = (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }
	
	
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model=new Application_Model_Contact();
        $model->setId($row->id)
                  ->setContactName($row->contact_name)
                  ->setContactEmail($row->contact_email)
                  ->setContactReason($row->contact_reason)
                  ->setUserId($row->user_id)
				  ->setCreated($row->created)
				  ->setModified($row->modified)
				  ->setStatus($row->status)
                  ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
                'contact_name'  => $this->getContactName(),
        		'contact_email' => $this->getContactEmail(),
                'contact_reason' => $this->getContactReason(),
  	  			'user_id' => $this->getUserId(),
				'created' => $this->getCreated(),
				'modified' => $this->getModified(),
				'status' => $this->getStatus()
        );
        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
			$data['created'] = date("Y-m-d H:i:s");
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
            $data['modified'] = date("Y-m-d H:i:s");
			return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }        
    }

    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result))
		{
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

