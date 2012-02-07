<?php

class Application_Model_Country {

    protected $_id;
    protected $_name;
    protected $_continentId;
    protected $_continentName;
    protected $_latitude;
	protected $_longitude;
	protected $_address;
	protected $_featured;
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
            $this->setMapper(new Application_Model_CountryMapper());
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

    
	public function setContinentId($contientId)
    {
        $this->_continentId= (int) $contientId;
        return $this;
    }

    public function getContinentId()
    {
        return $this->_continentId;
    }
    
	public function setContinentName($continentName)
	{
		
		$this->_continentName=(string)$continentName;
		return $this;
	}	
	public function getContinentName()
	{
		return $this->_continentName;
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
	
	public function setFeatured($featured)
    {
        $this->_featured = (int) $featured;
        return $this;
    }
    public function getFeatured()
    {
        return $this->_featured;
    }
	
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		$parent=$row->findParentRow('Application_Model_DbTable_Continent','Continent');
            $model = new Application_Model_Country();
            $model->setId($row->id)
                  	->setName($row->name)
                	->setContinentId($row->continent_id)
                	->setLatitude($row->latitude)
					->setLongitude($row->longitude)
					->setAddress($row->address)
					->setFeatured($row->featured)
                	;
            if($parent)
            $model->setContinentName($parent->name);
    	
             return $model;
    }
    
    public function save()
    {
		$data = array(
            'name' => $this->getName(),
    		'continent_id' => $this->getContinentId(),
            'latitude' => $this->getLatitude(),
			'longitude' => $this->getLongitude(),
			'address' => $this->getAddress(),
			'featured' => $this->getFeatured()
        );
        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
			return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result))
		{
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

    /*------Data utility functions------*/
    public function getCountry($option=null, $continent_id=null)
    {
        $where=null;
        if(!is_null($continent_id))
        {
            $where="continent_id='{$continent_id}'";
        }
    	 $obj=new Application_Model_Country();
         $entries=$obj->fetchAll($where,'name asc');
         
         $arrCountry=array();
         if(!is_null($option))
         $arrCountry['']=$option;
         foreach($entries as $entry)
         {         
         	//$arrCountry[$entry->getId()] = ucfirst( strtolower($entry->getName()));
			$arrCountry[$entry->getId()] = ucwords( strtolower($entry->getName()));
         }
         return $arrCountry;
    }
    
    public function getCountryCombo()
    {
    	
		$actor=$this->fetchAll();
		echo "<select class='selectbox' onchange='search_movie()'  name='country' id='country'>";
		echo "<option value=''>Country</option>";
		foreach($actor as $row)
		{
			$selected="";
        		if(isset($_REQUEST['country']) && $_REQUEST['country']==$row->getId())
        			$selected="selected='selected'";
      		echo "<option ".$selected." value='".$row->getId()."'>".$row->getName()."</option>";
		}
		echo "</select>";
    	
    }
    /*------Data utility functions------*/
	
	
    /**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 3-Dec-2010
	 * @Description	: This function is used to get country continent id
	 * @Input		: $country (string) 
	 * @Return		: int
	 */
    public function countryContinent($country)
    {
		$continent_id = "";
		$country = trim($country);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT continent FROM temp_country WHERE country='".$country."'";
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			$continent = $DATACont[0]['continent'];
			
			$continentM = new Application_Model_Continent();
			$continentM = $continentM->fetchRow("name='{$continent}'");
			
			//if no continents found then insert new it as new Continet
			if(false===$continentM)
			{
				$continentM->setName($continent);
				$continent_id = $continentM->save();
			}
			else
			{
				//else if available then get continent ID
				$continent_id = $continentM->getId();
			}	
		}
		return $continent_id;
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 14-Dec-2010
	 * @Description	: This function is used to get Nationalities
	 * @Input		: $option->string
	 * @Return		: array
	 */
    public function getNationalities($option=null)
    {
		$db = Zend_Registry::get("db");
		$nationalitiesArr = array();
		
		if(!is_null($option))
		{
			$nationalitiesArr[''] = $option;
		}
		
		$sSQL = "SELECT id, nationality FROM nationalities WHERE status=1 ORDER BY nationality";
		$sRes = $db->query($sSQL);
		$sRes->setFetchMode(Zend_Db::FETCH_ASSOC);
		$natArr = $sRes->fetchAll();
		
		if(count($natArr)>0)
		{
			foreach($natArr AS $key=>$value)
			{
				$nationalitiesArr[$value['id']] = ucwords($value['nationality']);
			}	
		}
		return $nationalitiesArr;
		
	}//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 14-Dec-2010
	 * @Description	: This function is used to get Nationality name by ID
	 * @Input		: $id->integer
	 * @Return		: string
	 */
	
	public function getNationalityName($id)
    {
		$nationality = "";
		$id = trim($id);
		$db = Zend_Registry::get("db");
		
		$sSQLCont = "SELECT nationality FROM nationalities WHERE id='".$id."'";
		$sRESCount = $db->query($sSQLCont);
		$sRESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $sRESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			$nationality = $DATACont[0]['nationality'];
		}
		return $nationality;
	}
    
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 25-April-2011
	 * @Description	: reset featured field value to 0
	 * @Input		: 
	 * @Return		: boolean
	 */
    public function resetUpdateFeatured()
    {
		$db = Zend_Registry::get("db");
		
		$sSql = "UPDATE country SET featured=0 WHERE featured=1";
		$sRes = $db->query($sSql);		
		if($sRes)
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
	 * @Created On	: 25-April-2011
	 * @Description	: set and update featured countries
	 * @Input		: array (countries ids as array) 
	 * @Return		: boolean
	 */
	public function setUpdateFeatured($countriesArr)
    {
		$db = Zend_Registry::get("db");
		$modified = date("Y-m-d H:i:s");
		$countries = implode(",", $countriesArr);
		$sSQL = "UPDATE country SET featured=1 WHERE id IN (".$countries.")";
		$sRES = $db->query($sSQL);
		if($sRES)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>
