<?php

class Application_Model_WallHideUserAll {
    protected $_id;
    protected $_userId;
	protected $_posterId;
    protected $_addedon;
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
            throw new Exception('Invalid game property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property'.$method);
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
            $this->setMapper(new Application_Model_WallHideUserAllMapper());
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
	
	public function setPosterId($posterId)
    {
        $this->_posterId= $posterId;
        return $this;
    }

    public function getPosterId()
    {
        return $this->_posterId;
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
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model	  =	new Application_Model_WallHideUserAll();
        $model	  ->setId($row->id)
                  ->setUserId($row->user_id)
				  ->setPosterId($row->poster_id)
                  ->setAddedon($row->addedon)
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
			'user_id' => $this->getUserId(),
            'poster_id'   => $this->getPosterId(),        	
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
             $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['addedon']=time();
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
	
	public function getAllPosterId($user_id)
	{
		$arrPoster	=	array();
        $objModel	=	new Application_Model_WallHideUserAll();
        $poster		=	$objModel->fetchAll("user_id='{$user_id}'");
          
		  if(count($poster)>0)
          {
                foreach($poster as $pster)
                {                    
                        $arrPoster[]= $pster->getPosterId();                    
                }
          }
            return $arrPoster;
	}

}
