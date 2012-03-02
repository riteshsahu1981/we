<?php

class Application_Model_Journal
{
    protected $_id;
    protected $_title;
    protected $_status;
    protected $_publish;
    protected $_userId;
    protected $_addedon;
    protected $_updatedon;
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
            throw new Exception('Invalid Blog property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Blog property');
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
            $this->setMapper(new Application_Model_JournalMapper());
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
    
	public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
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
  
	public function setPublish($publish)
    {
        $this->_publish = (string) $publish;
        return $this;
    }

    public function getPublish()
    {
        return $this->_publish;
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
    	$model=new Application_Model_Journal();
        $model->setId($row->id)
                  ->setTitle($row->title)
                  ->setStatus($row->status)
                  ->setPublish($row->publish)
                  ->setUserId($row->user_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'title'   => $this->getTitle(),
  	  		'status'	=> $this->getStatus(),
  	  		'publish'=>$this->getPublish(),
  	  		'user_id'=>$this->getUserId()
  	  		
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

