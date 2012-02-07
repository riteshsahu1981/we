<?php
class Application_Model_Poi{

    protected $_id;
    protected $_locationId;
    protected $_locationType; 
    protected $_name;
    protected $_address;
    protected $_postcode;
    protected $_telfaxs;
    protected $_email;
    protected $_web;
    protected $_transportModes;
    protected $_priceRange;
    protected $_reviewSummary;
    protected $_reviewFull;
    protected $_bookable;
    protected $_xCoordinate;
    protected $_yCoordinate;
    protected $_featureId;
    protected $_keywords;
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
            $this->setMapper(new Application_Model_PoiMapper());
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
    
    public function setLocationId($locationId)
	{
		
		$this->_locationId=(int)$locationId;
		return $this;
	}
	
	public function getLocationId()
	{
		return $this->_locationId;
	}
	
	public function setLocationType($locationType)
	{
		$this->_locationType=(string)$locationType;
		return $this;
	}
	
	public function getLocationType()
	{
		return $this->_locationType;
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

   
	public function setAddress($address)
    {
        $this->_address= (string) $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->_address;
    }
	public function setPostcode($postcode)
    {
        $this->_postcode= (string) $postcode;
        return $this;
    }

    public function getPostcode()
    {
        return $this->_postcode;
    }
    
	public function setTelfaxs($telfaxs)
    {
        $this->_telfaxs= (string) $telfaxs;
        return $this;
    }

    public function getTelfaxs()
    {
        return $this->_telfaxs;
    }
	
	public function setEmail($email)
    {
        $this->_email= (string) $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }
    
	public function setWeb($web)
    {
        $this->_web= (string) $web;
        return $this;
    }

    public function getWeb()
    {
        return $this->_web;
    }
    
	public function setTransportModes($transportModes)
    {
        $this->_transportModes= (string) $transportModes;
        return $this;
    }

    public function getTransportModes()
    {
        return $this->_transportModes;
    }
    
	public function setPriceRange($priceRange)
    {
        $this->_priceRange= (string) $priceRange;
        return $this;
    }

    public function getPriceRange()
    {
        return $this->_priceRange;
    }
    
	public function setReviewSummary($reviewSummary)
    {
        $this->_reviewSummary= (string) $reviewSummary;
        return $this;
    }

    public function getReviewSummary()
    {
        return $this->_reviewSummary;
    }
    
	public function setReviewFull($reviewFull)
    {
        $this->_reviewFull= (string) $reviewFull;
        return $this;
    }

    public function getReviewFull()
    {
        return $this->_reviewFull;
    }
    
	public function setBookable($bookable)
    {
        $this->_bookable= (string) $bookable;
        return $this;
    }

    public function getBookable()
    {
        return $this->_bookable;
    }
	    
	public function setXCoordinate($xCoordinate)
    {
        $this->_xCoordinate= (string) $xCoordinate;
        return $this;
    }

    public function getXCoordinate()
    {
        return $this->_xCoordinate;
    }
    
    
	public function setYCoordinate($YCoordinate)
    {
        $this->_yCoordinate= (string) $YCoordinate;
        return $this;
    }

    public function getYCoordinate()
    {
        return $this->_yCoordinate;
    }
    
	public function setFeatureId($featureId)
    {
        $this->_featureId= (string) $featureId;
        return $this;
    }
	public function getFeatureId()
    {
        return $this->_featureId;
    }

	public function setKeywords($keywords)
    {
        $this->_keywords= (string) $keywords;
        return $this;
    }
    public function getKeywords()
    {
        return $this->_keywords;
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
			$model = new Application_Model_Poi();
            $model->setId($row->id)
                	->setLocationId($row->location_id)
                	->setLocationType($row->location_type)
                	->setName($row->name)
                	->setAddress($row->address)
                	->setPostcode($row->postcode)
                	->setTelfaxs($row->telfaxs)
                	->setEmail($row->email)
                	->setWeb($row->web)
                	->setTransportModes($row->transport_modes)
                	->setPriceRange($row->price_range)
                	->setReviewFull($row->review_full)
                	->setReviewSummary($row->review_summary)
                	->setBookable($row->bookable)
                	->setXCoordinate($row->x_coordinate)
                	->setYCoordinate($row->y_coordinate)
                	->setFeatureId($row->feature_id)
                	->setKeywords($row->keywords)
                	->setAddedon($row->addedon)
                	->setUpdatedon($row->updatedon)
                	;
    	
             return $model;
    }
    
    public function save()
    {
    $data = array(

    		'location_id' =>$this->getLocationId(),
    		'location_type' =>$this->getLocationType(),
        	'name' =>$this->getName(),
    		'address'=>$this->getAddress(),
    		'postcode'=>$this->getPostcode(),
    		'telfaxs'=>$this->getTelfaxs(),
    		'email'=>$this->getEmail(),
    		'web'=>$this->getWeb(),
    		'transport_modes'=>$this->getTransportModes(),
    		'price_range'=>$this->getPriceRange(),
    		'review_summary'=>$this->getReviewSummary(),
    		'review_full'=>$this->getReviewFull(),
    		'bookable'=>$this->getBookable(),
    		'x_coordinate'=>$this->getXCoordinate(),
    		'y_coordinate'=>$this->getYCoordinate(),
    		'feature_id'=>$this->getFeatureId(),
    		'keywords'=>$this->getKeywords()
            
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

