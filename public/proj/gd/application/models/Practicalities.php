<?php
class Application_Model_Practicalities{

    protected $_id;
    protected $_title;
    protected $_copy;
    protected $_destinationId;
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
            $this->setMapper(new Application_Model_PracticalitiesMapper());
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

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    
	public function setCopy($copy)
    {
        $this->_copy= (string) $copy;
        return $this;
    }

    public function getCopy()
    {
        return $this->_copy;
    }
    
	public function setDestinationId($destinationId)
    {
        $this->_destinationId= (int) $destinationId;
        return $this;
    }

    public function getDestinationId()
    {
        return $this->_destinationId;
    }
	
	
	public function setAddedon($addedon)
	{
		$this->_addedon=(int)$addedon;
		return $this;
	}
	
	public function getAddedon()
	{
		return $this->_addedon;
	}
	
	public function setUpdatedon($updatedon)
	{
		$this->_updatedon=(int)$updatedon;
		return $this;
	}
	public function getUpdatedon()
	{
		return $this->_updatedon;
	}

	
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		//$parent=$row->findParentRow('Application_Model_DbTable_Destination','Continent');
			$model = new Application_Model_Practicalities();
            $model->setId($row->id)
                  	->setTitle($row->title)
                	->setCopy($row->copy)
                	->setDestinationId($row->destination_id)
                	->setAddedon($row->addedon)
                	->setUpdatedon($row->updatedon)
                	;
    	
             return $model;
    }
    
    public function save()
    {
    $data = array(
            'title' => $this->getTitle(),
    		'copy' => $this->getCopy(),
    		'destination_id'=>$this->getDestinationId()
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
    
    public function delete($where=null)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    /*----Data Manupulation functions ----*/    


    
    
}

