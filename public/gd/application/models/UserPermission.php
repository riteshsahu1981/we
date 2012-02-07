<?php

class Application_Model_UserPermission
{
    protected $_id;
    protected $_permissionId;
    protected $_friendGroupId;
    protected $_userId;
    protected $_addedon;
    protected $_updatedon;
    protected $_permissionName;
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
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Permission property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Permission property');
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
            $this->setMapper(new Application_Model_UserPermissionMapper());
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
    
    public function setPermissionId($permissionId)
    {
    	$this->_permissionId = (int) $permissionId;
        return $this;
    }

    public function getPermissionId()
    {
        return $this->_permissionId;
    }

    public function setPermissionName($permissionName)
    {
    	$this->_permissionName = (string) $permissionName;
        return $this;
    }

    public function getPermissionName()
    {
        return $this->_permissionName;
    }
    
    public function setFriendGroupId($friendGroupId)
    {
    	$this->_friendGroupId= (int) $friendGroupId;
        return $this;
    }

    public function getFriendGroupId()
    {
        return $this->_friendGroupId;
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
    	$permission=$row->findParentRow('Application_Model_DbTable_Permission','Permission');
    	
    	$model=new Application_Model_UserPermission();
        $model->setId($row->id)
        		  ->setPermissionId($row->permission_id)
                  ->setFriendGroupId($row->friend_group_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ->setUserId($row->user_id)
                  ->setPermissionName($permission->name)
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
  	  		'permission_id' => $this->getPermissionId(),
            'friend_group_id'   => $this->getFriendGroupId(),
        	'user_id' => $this->getUserId(),
  	  		
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
    
    /*----Data Manupulation functions ----*/
}
