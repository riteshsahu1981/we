<?php
class Application_Model_Subscribe
{
    protected $_id;
    protected $_userId;
    protected $_item;
    protected $_firstName;
	protected $_lastName;
    protected $_sex;
    protected $_email;
    protected $_status;
    protected $_addedon;
    protected $_updatedon;
	protected $_mapper;
    
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
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid subscribe property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid subscribe property'.$method);
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
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_SubscribeMapper());
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
        $this->_userId= $userId;
        return $this;
    }
    public function getUserId()
    {
        return $this->_userId;
    }
	
    public function setItem($item)
    {
        $this->_item = (string) $item;
        return $this;
    }
	public function getItem()
    {
        return $this->_item;
    }
	
	public function setFirstName($firstName)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    }
    public function getFirstName()
    {
        return $this->_firstName;
    }
	
	public function setLastName($lastName)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }
    public function getLastName()
    {
        return $this->_lastName;
    }
    
    public function setSex($sex)
    {
        $this->_sex = (string) $sex;
        return $this;
    }
    public function getSex()
    {
        return $this->_sex;
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
    
    public function setStatus($status)
    {
        $this->_status= (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }
	    
	public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }
    
	public function setUpdatedon($updatedon)
    {
        $this->_updatedon = (int) $updatedon;
        return $this;
    }
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model=new Application_Model_Subscribe();
        $model->setId($row->id)
			  ->setUserId($row->user_id)
              ->setItem($row->item)
              ->setFirstName($row->first_name)
              ->setLastName($row->last_name)
              ->setSex($row->sex)
              ->setEmail($row->email)
              ->setStatus($row->status)
              ->setAddedon($row->addedon)
              ->setUpdatedon($row->updatedon)              
              ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
			'user_id'		=> $this->getUserId(),
            'item'			=> $this->getItem(),
	  	  	'first_name'	=> $this->getFirstName(),
		    'last_name'		=> $this->getLastName(),
  	  		'sex'			=> $this->getSex(),
  	  	    'email'			=> $this->getEmail(),
  	  		'status'		=> $this->getStatus()        	
        );

        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
        	$data['updatedon']=time();
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
}//end class
