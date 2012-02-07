<?php
class Application_Model_GapperLocation{
    protected $_id;
    protected $_userId;
    protected $_longitude;
    protected $_latitude;
    protected $_address;
    protected $_latest;
    protected $_city;
    protected $_state;
    protected $_country;
    protected $_region;
    protected $_continent;
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
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified 1'.$method);
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified 2'.$method);
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
            $this->setMapper(new Application_Model_GapperLocationMapper());
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
	public function setLongitude($longitude)
    {
        $this->_longitude = (string) $longitude;
        return $this;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }
    
	public function setLatitude($latitude)
    {
        $this->_latitude = (string) $latitude;
        return $this;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function setLatest($latest)
    {
        $this->_latest = (int) $latest;
        return $this;
    }
    public function getAddress()
    {
        return $this->_address;
    }

    public function setAddress($address)
    {
        $this->_address = (string) $address;
        return $this;
    }

    public function getLatest()
    {
        return $this->_latest;
    }

	public function setCity($city)
    {
        $this->_city = (string) $city;
        return $this;
    }

    public function getCity()
    {
        return $this->_city;
    }
    
	public function setState($state)
    {
        $this->_state = (string) $state;
        return $this;
    }

    public function getState()
    {
        return $this->_state;
    }
    
    
	public function setCountry($country)
    {
        $this->_country = (string) $country;
        return $this;
    }

    public function getCountry()
    {
        return $this->_country;
    }
    
	public function setContinent($continent)
    {
        $this->_continent = (string) $continent;
        return $this;
    }

    public function getContinent()
    {
        return $this->_continent;
    }
    
	public function setRegion($region)
    {
        $this->_region = (string) $region;
        return $this;
    }

    public function getRegion()
    {
        return $this->_region;
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

   
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
			$model = new Application_Model_GapperLocation();
            $model->setId($row->id)
					->setUserId($row->user_id)
					->setLongitude($row->longitude)
					->setLatitude($row->latitude)
                                        ->setAddress($row->address)
                                        ->setLatest($row->latest)
					->setCity($row->city)
					->setState($row->state)
					->setCountry($row->country)
					->setContinent($row->continent)
					->setRegion($row->region)
	                ->setAddedon($row->addedon)
;    	
             return $model;
    }
    
    public function save()
    {
     	$data = array(
            'user_id' =>$this->getUserId(),
     		'longitude'   =>$this->getLongitude(),
     		'latitude'	=>$this->getLatitude(),
                'address'	=>$this->getAddress(),
                'latest'    =>$this->getLatest(),
     		'city'	=>$this->getCity(),
     		'state'=>$this->getState(),
     		'country'=>$this->getCountry(),
     		'continent'=>$this->getContinent(),
     		'region'=>$this->getRegion()   	
        );


        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
            $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
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
    
    public function fetchRow($where = null, $order = null)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where, $order);

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