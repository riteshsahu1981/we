<?php
class Application_Model_Destination{

    protected $_id;
    protected $_title;
    protected $_introduction;
    protected $_locationId;
    protected $_locationType; //enum(country,city,continent)
	protected $_bankBreaker;
	protected $_knowledge;
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
            $this->setMapper(new Application_Model_DestinationMapper());
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

    
	public function setIntroduction($introduction)
    {
        $this->_introduction= (string) $introduction;
        return $this;
    }

    public function getIntroduction()
    {
        return $this->_introduction;
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
	
	public function setBankBreaker($bankBreaker)
	{
		$this->_bankBreaker=(string)$bankBreaker;
		return $this;
	}
	public function getBankBreaker()
	{
		return $this->_bankBreaker;
	}
	
	public function setKnowledge($knowledge)
    {
        $this->_knowledge = (string) $knowledge;
        return $this;
    }
	public function getKnowledge()
    {
        return $this->_knowledge;
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
			$model = new Application_Model_Destination();
            $model->setId($row->id)
                  	->setTitle($row->title)
                	->setIntroduction($row->introduction)
                	->setLocationId($row->location_id)
                	->setLocationType($row->location_type)
					->setBankBreaker($row->bank_breaker)
					->setKnowledge($row->knowledge)
                	->setAddedon($row->addedon)
                	->setUpdatedon($row->updatedon)
                	;
    	
             return $model;
    }
    
    public function save()
    {
    $data = array(
            'title' => $this->getTitle(),
    		'introduction' => $this->getIntroduction(),
    		'location_id' =>$this->getLocationId(),
    		'location_type' =>$this->getLocationType(),
            'bank_breaker' =>$this->getBankBreaker(),
			'knowledge' =>$this->getKnowledge()
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

	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 6-Dec-2010
	 * @Description	: Get Eat Sleep & Drink information of City(Destinations)
	 * @Input		: $destination_id (int) 
	 * @Return		: array if found data otherwise false
	 */
    public function destinationEatSleepDrink($destination_id)
    {
		$destination_id = trim($destination_id);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT title,back_packer_copy,local_copy FROM eat_sleep_drink WHERE destination_id='".$destination_id."'";
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			return $DATACont;
		}
		else
		{
			return false;
		}
	}//end of function
    
    /**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 6-Dec-2010
	 * @Description	: Get Expriences information of City(Destinations)
	 * @Input		: $destination_id (int) 
	 * @Return		: array if found data otherwise false
	 */
    public function destinationExprience($destination_id)
    {
		$destination_id = trim($destination_id);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT title, copy FROM experiences WHERE destination_id='".$destination_id."' ORDER BY id ASC";
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			return $DATACont;
		}
		else
		{
			return false;
		}
	}//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 6-Dec-2010
	 * @Description	: Get Practicalities information of City(Destinations)
	 * @Input		: $destination_id (int) 
	 * @Return		: array if found data otherwise false
	 */
    public function destinationPractical($destination_id)
    {
		$destination_id = trim($destination_id);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT title, copy FROM practicalities WHERE destination_id='".$destination_id."' ORDER BY id ASC";
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			return $DATACont;
		}
		else
		{
			return false;
		}
	}//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 15-Dec-2010
	 * @Description	: Get City Images(Destinations/Places)
	 * @Input		: $city_id (int) 
	 * @Return		: array if found data otherwise false
	 */
    public function destinationImages($city_id, $type="city")
    {
		$city_id = trim($city_id);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT * FROM city_images WHERE status=1 AND city_id='".$city_id."' ORDER BY weight ASC";
		if($type=="country")
		{
			$SQLCont = "SELECT * FROM country_images WHERE status=1 AND country_id='".$city_id."' ORDER BY weight ASC";
		}	
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			return $DATACont;
		}
		else
		{
			return false;
		}
	}//end of function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 22-Dec-2010
	 * @Description	: Check country data in planet feeds table
	 * @Input		: $country_id (int) 
	 * @Return		: boolean(return TRUE if found data otherwise returns FALSE)
	 */
	public function checkCountryData($country_id)
    {
		$country_id = trim($country_id);
		$db = Zend_Registry::get("db");
		
		$SQLCont = "SELECT id FROM lonely_planet_country WHERE country_id='".$country_id."'";
		$RESCount = $db->query($SQLCont);
		$RESCount->setFetchMode(Zend_Db::FETCH_ASSOC);
		$DATACont = $RESCount->fetchAll();
		
		if(count($DATACont)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}//end of function
	
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 13-Jan-2011
	 * @Description	: Get featured places
	 * @Input		: none 
	 * @Return		: array
	 */
	public function selectFeaturedPlaces()
	{
		$cityM	=	new Application_Model_City();
		
		//get other featured cities
		$cityArr	=	array();
		$cityArr	=	$cityM->fetchAll("featured_top=1 OR featured_other=1", "name ASC");
		
		$featuredOther 		= array();
		$featuredOtherArr 	= array();
			
		if(count($cityArr)>0)
		{
			foreach($cityArr AS $row)
			{
				$featuredOther['city_id'] = $row->id;
				$featuredOther['name']	= $row->name;
				
				//get City/place image
				$featuredOther['city_image'] = "no-image.jpg";
				$cityImagesArr = $this->destinationImages($row->id);
				if(false!==$cityImagesArr)
				{
					if(count($cityImagesArr)>0)
					{
						$featuredOther['city_image'] = $cityImagesArr[0]['city_image'];
					}
				}
				
				//now get country in which this city exists
				$countryM	=	new Application_Model_Country();
				$country_id = 	$row->countryId;
				$countryM	=	$countryM->find($country_id);
				if(false!==$countryM)
				{
					$featuredOther['country'] = $countryM->getName();
				}	
				
				$destination	=	$this->fetchRow("location_id='{$row->id}' AND location_type='city'");
					
				if(false!==$destination)
				{
					$featuredOther['overview'] = $destination->getTitle();
					$featuredOther['nutshell'] = $destination->getIntroduction();
				}
				$featuredOtherArr[] = $featuredOther;
			}//end of foreach
			return $featuredOtherArr;
		}//end if
	}//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 16-March-2011
	 * @Description: Set default row data for Country/City if not provided by XML feeds
	 */
	public function setDefaultRowData($location_id, $location_type)
    {
		//set default values
		$title			= "";
		$introduction	= "";
		$location_id	= trim($location_id);
		$location_type	= trim($location_type);
		$bankbreakerArr	= array();
		$bank_breaker	= serialize($bankbreakerArr);
		$knowledgeArr	= array(0=>array("title"=>"","copy"=>""));
		$knowledge		= serialize($knowledgeArr);
		
		//set title
		if($location_type=="country")
		{
			$countryM = new Application_Model_Country();
			$countryM = $countryM->find($location_id);
			if($countryM!==false)
			{
				$title = "A guide to ".$countryM->getName();
			}
		}
		if($location_type=="city")
		{
			$cityM = new Application_Model_City();
			$cityM = $cityM->find($location_id);
			if($cityM!==false)
			{
				$title = "A guide to ".$cityM->getName();
			}
		}
		$model = new Application_Model_Destination();
		$model->setTitle($title);
		$model->setIntroduction($introduction);
		$model->setLocationId($location_id);
		$model->setLocationType($location_type);
		$model->setBankBreaker($bank_breaker);
		$model->setKnowledge($knowledge);
		$res = $model->save();
		if($res)
		{
			return $res;
		}
		else
		{
			return false;
		}	
	}//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 17-March-2011
	 * @Description: Save block status of City/Country
	 */
	public function updateXMLFeedsBlockStatus($item_type, $item_id, $block_feed)
    {
    	$db = Zend_Registry::get("db");
		
		//select existing record
		$selectSQL = "SELECT * FROM blocked_xml_feeds WHERE item_type='{$item_type}' AND item_id={$item_id}";
		$selectRes = $db->query($selectSQL);
		$selectRes->setFetchMode(Zend_Db::FETCH_ASSOC);
		$dataCount = $selectRes->fetchAll();
		
		if(count($dataCount)>0)
		{
			$updateSql = "UPDATE blocked_xml_feeds SET block_feed='{$block_feed}' WHERE item_type='{$item_type}' AND item_id={$item_id}";
		}
		else
		{
			$updateSql = "INSERT INTO blocked_xml_feeds SET item_type='{$item_type}', item_id={$item_id}, block_feed='{$block_feed}'";
		}	
		$updateRes = $db->query($updateSql);
    }
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 17-March-2011
	 * @Description: Select XML feeds block status of City/Country
	 */
	public function selectXMLFeedsBlockStatus($item_type, $item_id)
	{
		$blockFeed = "No";
		$db = Zend_Registry::get("db");
		$selectSQL = "SELECT * FROM blocked_xml_feeds WHERE item_type='{$item_type}' AND item_id={$item_id}";
		$selectRes = $db->query($selectSQL);
		$selectRes->setFetchMode(Zend_Db::FETCH_ASSOC);
		$dataCount = $selectRes->fetchAll();
		
		if(count($dataCount)>0)
		{
			//print_r($dataCount);
			$blockFeed = $dataCount[0]["block_feed"];
		}
		return 	$blockFeed;			
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 31-March-2011
	 * @Description: Set default for City if not provided by XML feeds
	 */
	public function setDefaultCityData($destination_id)
    {
		$db = Zend_Registry::get("db");
		$addedOn = time();
		
		//set default values for eat_sleep_drink Table
		$titleArr = array("Eat", "Sleep","Drink", "Be merry");
		for($esd=0; $esd<count($titleArr); $esd++)
		{
			$title = $titleArr[$esd];
			$sSQL1 = "INSERT INTO eat_sleep_drink(title, back_packer_copy, local_copy, addedon, destination_id) VALUES('{$title}','','',{$addedOn}, {$destination_id})";
			$rRes1 = $db->query($sSQL1);
		}
		
		//set default values for experiences Table
		for($j=0; $j<3; $j++)
		{
			$sSQL2 = "INSERT INTO experiences(title, copy, destination_id, addedon) VALUES('', '', {$destination_id}, {$addedOn})";
			$rRes2 = $db->query($sSQL2);
		}
		
		//set default values for practicalities Table
		for($k=0; $k<3; $k++)
		{
			$sSQL3 = "INSERT INTO practicalities(title, copy, addedon, destination_id) VALUES('', '', {$addedOn}, {$destination_id})";
			$rRes3 = $db->query($sSQL3);
		}
	}//end of function
}
