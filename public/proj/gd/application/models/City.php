<?php

class Application_Model_City
{
    protected $_id;
    protected $_name;
    protected $_cityId;
    protected $_regionId;
    protected $_countryId;
    protected $_continentId;
	protected $_featuredTop;
	protected $_featuredOther;
	protected $_latitude;
	protected $_longitude;
	protected $_address;
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
            throw new Exception('Invalid City property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid City property');
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
            $this->setMapper(new Application_Model_CityMapper());
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
    
 
	public function setContinentId($continentId)
    {
        $this->_continentId = (int) $continentId;
        return $this;
    }

    public function getContinentId()
    {
        return $this->_continentId;
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
	public function setRegionId($regionId)
    {
        $this->_regionId = (int) $regionId;
        return $this;
    }

    public function getRegionId()
    {
        return $this->_regionId;
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
	
	public function setStateName($stateName)
    {
        $this->_stateName = (string) $stateName;
        return $this;
    }

    public function getStateName()
    {
        return $this->_stateName;
    }	
	
	public function setFeaturedTop($featuredTop)
    {
        $this->_featuredTop = (int) $featuredTop;
        return $this;
    }
    public function getFeaturedTop()
    {
        return $this->_featuredTop;
    }
	
	public function setFeaturedOther($featuredOther)
    {
        $this->_featuredOther = (int) $featuredOther;
        return $this;
    }
    public function getFeaturedOther()
    {
        return $this->_featuredOther;
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
	
	public function setLongitude($longitude)
    {
        $this->_longitude = (string) $longitude;
        return $this;
    }
    public function getLongitude()
    {
        return $this->_longitude;
    }
	
	public function setAddress($address)
    {
        $this->_address = (string) $address;
        return $this;
    }
    public function getAddress()
    {
        return $this->_address;
    }
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model=new Application_Model_City();
        $model->setId($row->id)
                  ->setName($row->name)
                  ->setRegionId($row->region_id)
                  ->setCountryId($row->country_id)
                  ->setContinentId($row->continent_id)
				  ->setFeaturedTop($row->featured_top)
				  ->setFeaturedOther($row->featured_other)
				  ->setLatitude($row->latitude)
				  ->setLongitude($row->longitude)
				  ->setAddress($row->address)
                  ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
                'name'   => $this->getName(),
        		'region_id' => $this->getRegionId(),
                'country_id'=> $this->getCountryId(),
  	  			'continent_id'=> $this->getContinentId(),
				'featured_top'=> $this->getFeaturedTop(),
				'featured_other'=> $this->getFeaturedOther(),
				'latitude'=> $this->getLatitude(),
				'longitude'=> $this->getLongitude(),
				'address'=> $this->getAddress()
        );
        if (null === ($id = $this->getId()))
		{
            unset($data['id']);             
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
			$data['modified'] = date("Y-m-d H:i:s");
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
    
    public function getCity($option=null, $countryId=null)
    {
    	$arrLang=array();
    	if(!is_null($option))
    		$arrLang['']=$option;
    		
        $where=null;
        if(!is_null($countryId))
            $where="country_id='{$countryId}'";
           
    	
		$City=$this->fetchAll($where);
		foreach($City as $row)
		{
			$arrLang[$row->getId()]=$row->getName();
		}   
		return $arrLang;  	
    }
    
    /*----Data Manupulation functions ----*/

	public function getCityArray($stateId=null)
    {
    	$arrCity=Array();
    	$where="state_id='{$stateId}'";
    	if(is_null($stateId)){
    		$where="1=1";
    	}
		$City=$this->fetchAll($where, 'name ASC');
		foreach($City as $row)
		{
      		$arrCity[$row->getId()]=$row->getName();
		}
		return $arrCity;
    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Dec-2010
	 * @Description	: This function is used to pupulate city drrop down options
	 * @Input		: array
	 * @Return		: array
	 */
	public function getCities($option=array(""=>"--Please Select--"))
    {
    	//$cities = array_merge($option, $this->getCityArray());
		$cities = $this->getCityArray();
		return $cities;
    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Dec-2010
	 * @Description	: reset featured_top and featured_other field value to 0
	 * @Input		:  
	 * @Return		: boolean
	 */
    public function resetUpdateFeatured()
    {
		$db = Zend_Registry::get("db");
		//set featured_top=0
		$sSqlTop = "UPDATE city SET featured_top=0 WHERE featured_top=1";
		$sResTop = $db->query($sSqlTop);
		
		//set featured_top=0
		$sSqlOther = "UPDATE city SET featured_other=0 WHERE featured_other=1";
		$sResOther = $db->query($sSqlOther);
		if($sResTop && $sResOther)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Dec-2010
	 * @Description	: update top featured city
	 * @Input		: int(city id) 
	 * @Return		: boolean
	 */
	public function setUpdateFeaturedTop($id)
	{
		if(is_numeric($id) && $id!="")
		{
			$db = Zend_Registry::get("db");
			$modified = date("Y-m-d H:i:s");
			$SQLCont = "UPDATE city SET featured_top=1, modified='".$modified."' WHERE id ='".$id."'";
			$RESCount = $db->query($SQLCont);
			if($RESCount)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Dec-2010
	 * @Description	: set and update featured other cities
	 * @Input		: array (city ids as array) 
	 * @Return		: boolean
	 */
	public function setUpdateFeaturedOther($citiesArr)
    {
		$db = Zend_Registry::get("db");
		$modified = date("Y-m-d H:i:s");
		$cities = implode(",", $citiesArr);
		$SQLCont = "UPDATE city SET featured_other=1, modified='".$modified."' WHERE id IN (".$cities.")";
		$RESCount = $db->query($SQLCont);
		if($RESCount)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

