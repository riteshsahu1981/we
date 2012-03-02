<?php

class Application_Model_Wall
{
    protected $_id;
    protected $_status;
    protected $_facebook;
	protected $_addedon;
    protected $_updatedon;
    protected $_userId;
	protected $_profileId;
	protected $_userObj;    
    protected $_mapper;
	protected $_activeStatus=1;
	
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid City property');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid City property');
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
            $this->setMapper(new Application_Model_WallMapper());
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
    
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
		//return htmlentities($this->_status);//modified by Mahipal Adhikari on 1-Apr-2011
    }
    
    public function setFacebook($facebook)
    {
        $this->_facebook = (int) $facebook;
        return $this;
    }
    public function getFacebook()
    {
        return $this->_facebook;
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
	
	public function setProfileId($profileId)
    {
        $this->_profileId = $profileId;
        return $this;
    }
    public function getProfileId()
    {
        return $this->_profileId;
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
    
    public function getUser()
    {
    	return $this->_userObj;	
    }
	public function setUser($userObj)
    {
    	$this->_userObj=$userObj;
    	return $this;	
    }
	
	public function setActiveStatus($activeStatus)
    {
        $this->_activeStatus = (int) $activeStatus;
        return $this;
    }
    public function getActiveStatus()
    {
        return $this->_activeStatus;
    }

    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$parent = $row->findParentRow('Application_Model_DbTable_User','User');
    	$model = new Application_Model_Wall();
        $model->setId($row->id)
                  ->setStatus($row->status)
                  ->setFacebook($row->facebook)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
				  ->setProfileId($row->profile_id)
                  ->setUser($parent)
				  ->setActiveStatus($row->active_status);
                  
             return $model;
    }
    
    public function save()
    {
  	  	$data = array(
            'status'   => $this->getStatus(),
        	'user_id' => $this->getUserId(),
			'profile_id' => $this->getProfileId(),
  	  		'facebook'=>$this->getFacebook(),
			'active_status'=>$this->getActiveStatus()
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
    }//end function


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
    /*----Data Manupulation functions ----*/

}

