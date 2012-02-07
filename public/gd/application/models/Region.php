<?php
class Application_Model_Region {

    protected $_id;
    protected $_name;
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

 	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_RegionMapper());
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

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getCountryId()
    {
        return $this->_countryId;
    }

    public function setCountryId($countryId)
    {
        $this->_countryId = (int) $countryId;
        return $this;
    }
    
 	public function getContinentId()
    {
        return $this->_continentId;
    }

    public function setContinentId($continentId)
    {
        $this->_continentId = (int) $continentId;
        return $this;
    }
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    		$parent=$row->findParentRow('Application_Model_DbTable_Country','Country');
			$model = new Application_Model_Region();
            $model->setId($row->id)
                  	->setName($row->name)
                	->setCountryId($row->country_id)
                	->setContinentId($row->continent_id)
                	;
    	
             return $model;
    }
    
    public function save()
    {
    $data = array(
            'country_id'   => $this->getCountryId(),
    		'continent_id'   => $this->getContinentId(),
            'name' => $this->getName(),
            
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
            return;
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

    /*------Data utility functions------*/
    public function getRegion($option=null)
    {
    	 $obj=new Application_Model_Region();
         $entries=$obj->fetchAll();
         $arrRegion=array();
         if(!is_null($option))
         $arrRegion['']=$option;
         foreach($entries as $entry)
         {         
         	$arrRegion[$entry->getId()]=$entry->getName();	
         }
         return $arrRegion;
    }
    

    

    /*------Data utility functions------*/
    
    
    
}

?>
