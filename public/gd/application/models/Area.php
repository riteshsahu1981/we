<?php

class Application_Model_Area
{
    protected $_id;
    protected $_name;
    protected $_cityId;
    protected $_regionId;
    protected $_countryId;
    protected $_continentId;
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
            throw new Exception('Invalid Area property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Area property');
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
            $this->setMapper(new Application_Model_AreaMapper());
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
    
	public function setCityId($cityId)
    {
        $this->_cityId = (int) $cityId;
        return $this;
    }

    public function getCityId()
    {
        return $this->_cityId;
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
    
	public function setCountryId($countryId)
    {
        $this->_countryId = (int) $countryId;
        return $this;
    }

    public function getCountryId()
    {
        return $this->_countryId;
    }
    
	public function setContinentId($continentId)
    {
        $this->_continentId = (int) $continentId;
        return $this;
    }

    public function getContinentId()
    {
        return $this->_continentId;
    }
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	//$parent=$row->findParentRow('Application_Model_DbTable_City','City');
    	$model=new Application_Model_Area();
        $model->setId($row->id)
                  ->setName($row->name)
                  ->setCityId($row->city_id)
                  ->setRegionId($row->region_id)
                  ->setCountryId($row->country_id)
                  ->setContinentId($row->continent_id)
                  ;
             return $model;
    }
    
    public function save()
    {
  	  	$data = array(
            'name'   => $this->getName(),
        	'city_id' => $this->getCityId(),
  	  		'region_id' => $this->getRegionId(),
  	  		'country_id' =>$this->getCountryId(),
  	  		'continent_id' =>$this->getContinentId()
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
    
    public function getArea($option=null, $cityId=null)
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang['']=$option;
    		
		$where="city_id='{$cityId}'";
    	if(is_null($cityId)){
    		$where="1=1";
    	}
    	
		$Area=$this->fetchAll($where);
		foreach($Area as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }
    
    /*----Data Manupulation functions ----*/

	public function getAreaArray($cityId=null)
    {
    	$arrArea=Array();
    	$where="city_id='{$cityId}'";
    	if(is_null($cityId)){
    		$where="1=1";
    	}
		$Area=$this->fetchAll($where);
		foreach($Area as $row)
		{
      		$arrArea[$row->getId()]=$row->getName();
		}
		return $arrArea;
    }
}

