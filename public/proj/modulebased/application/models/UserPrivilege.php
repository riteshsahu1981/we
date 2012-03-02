<?php
class Application_Model_UserPrivilege {

    protected $_id;
    protected $_userId;
    protected $_menuId;
    protected $_screenId;
    protected $_actionId;
    protected $_addedon;
    protected $_updatedon;
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
            $this->setMapper(new Application_Model_UserPrivilegeMapper());
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
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setScreenId($screenId)
    {
        $this->_screenId = (int) $screenId;
        return $this;
    }

    public function getScreenId()
    {
        return $this->_screenId;
    }
    
     public function setMenuId($menuId)
    {
        $this->_menuId = (int) $menuId;
        return $this;
    }

    public function getMenuId()
    {
        return $this->_menuId;
    }
    
    public function setActionId($actionId)
    {
        $this->_actionId = (int) $actionId;
        return $this;
    }

    public function getActionId()
    {
        return $this->_actionId;
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
    	
    		
            $model = new Application_Model_UserPrivilege();
            $model->setId($row->id)
                    ->setTitle($row->user_id)
                    ->setMenuId($row->menu_id)
                    ->setScreenId($row->screen_id)
                    ->setActionId($row->action_id)
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
            'user_id'   => $this->getUserId(),
            'menu_id'   => $this->getMenuId(),
            'screen_id'   => $this->getScreenId(),
            'action_id'   => $this->getActionId()
            );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
             $data['created_by']=$usersNs-userId;
            $guidCreate= new Base_Uuid();
            $data['row_guid']=$guidCreate->guid();
            $data['addedon']=time();
           return $this->getMapper()->getDbTable()->insert($data);
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
    
 /*------Data utility functions------*/
    
    
    
}