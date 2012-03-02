<?php

class Application_Model_State
{
    protected $_id;
    protected $_name;
    protected $_regionId;
    protected $_regionName;
    protected $_userId;
    
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
            throw new Exception('Invalid State property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid State property');
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
            $this->setMapper(new Application_Model_StateMapper());
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
    
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    
	public function setRegionId($regionId)
    {
        $this->_regionId = (int) $regionId;
        return $this;
    }

    public function getRegionId()
    {
        return $this->_regionId;
    }

	public function setRegionName($regionName)
    {
        $this->_regionName = (string) $regionName;
        return $this;
    }

    public function getRegionName()
    {
        return $this->_regionName;
    }
    
    
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$parent=$row->findParentRow('Application_Model_DbTable_Region','Region');
    	$model=new Application_Model_State();
        $model->setId($row->id)
                  ->setName($row->name)
                  ->setRegionId($row->region_id)
                  ->setRegionName($parent->name)
                  ;
             return $model;
    }
    
    public function save()
    {
  	  	$data = array(
            'name'   => $this->getName(),
        	'region_id' => $this->getRegionId()
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
             
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	
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
    
    public function getState($option=null, $stateId=null)
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang['']=$option;
    		
		$where="state_id='{$stateId}'";
    	if(is_null($stateId)){
    		$where="1=1";
    	}
    	
		$State=$this->fetchAll($where);
		foreach($State as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }
    
    /*----Data Manupulation functions ----*/

	public function getStateArray($stateId=null)
    {
    	$arrState=Array();
    	$where="state_id='{$stateId}'";
    	if(is_null($stateId)){
    		$where="1=1";
    	}
		$State=$this->fetchAll($where);
		foreach($State as $row)
		{
      		$arrState[$row->getId()]=$row->getName();
		}
		return $arrState;
    }
}

