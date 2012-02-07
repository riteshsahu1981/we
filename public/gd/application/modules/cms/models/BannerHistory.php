<?php


class Cms_Model_BannerHistory {
	
    protected $_id;
    protected $_bannerId;
    protected $_showUrl;
    protected $_ipAddress;
    protected $_displayed;
    protected $_type;
    protected $_click;
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


    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

  
    public function getId()
    {
        return $this->_id;
    }


    
         
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Cms_Model_BannerMapper());
        }
        return $this->_mapper;
    }

        
    private function setModel($row)
    {
    	$model=new Cms_Model_Banner();
    	$model->setId($row->Id)
             ->setTitle($row->Title)
             ->setPosition($row->Position)
             ->setImage($row->Image)
             ->setUrl($row->Url)
             ->setDescription($row->Description)
             ->setPublished($row->Published)
             ->setCreated($row->Created)
             ->setUserId($row->UserId);
             
             return $model;
    }
    
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
    
        $data = array(
            'Title'   => $this->getTitle(),
            'Position'   => $this->getPosition(),
            'Image'   => $this->getImage(),
            'Url'   => $this->getUrl(),
            'Description' => $this->getDescription(),
            'Published'   => $this->getPublished(),
        );
	$usersNs = new Zend_Session_Namespace("members");
        
        if (null === ($id = $this->getId())) {
            unset($data['Id']);
            $data['Created']=time();
            $data['UserId']=$usersNs->userId;
            return $this->getMapper()->getDbTable()->insert($data);
        } 
        else 
        {
        	$data['UserId']=$usersNs->userId;
            return $this->getMapper()->getDbTable()->update($data, array('Id = ?' => $id));
        }
        
    }

    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     * 
     * @param  int $id 
     * @return User_Model_User
     */
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
	
    
    /**
     * Fetch all entries
     * 
     * @return array
     */
    public function fetchAll($where="1")
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where);
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
    
    public function getUsers()
    {
    	 $entries=$this->fetchAll();    	 
         $array=array();
         $array['']='--- Select Author ---';
         foreach($entries as $entry)
         {        
         	$array[$entry->getId()]=$entry->getFirstName()." ".$entry->getLastName();	
         }
         return $array;
    }
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }    
}

?>