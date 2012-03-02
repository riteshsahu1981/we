<?php
class Application_Model_LonelyPlanetCountry
{
    protected $_id;
	protected $_nodeId;	
    protected $_destinationName;
    protected $_fullDestinationName;
    protected $_introMini;
    protected $_introShort;
    protected $_warningTitle;
    protected $_warningText;
	protected $_warningPosition;
	protected $_warningSeverity;
	protected $_timezones;
	protected $_weightsMeasuresSystem;
	protected $_capitalCity;
	protected $_leaders;
	protected $_governmentType;
	protected $_areaSqkm;
	protected $_population;
	protected $_languageSpokens;
	protected $_religion;
	protected $_currencyCode;
	protected $_currencyName;
	protected $_currencySymbol;
	protected $_currencyUnit;
	protected $_relativeCostRooms;
	protected $_relativeCostMeals;
	protected $_whenToGo;
	protected $_visasOverview;
	protected $_electricalPlugs;
	protected $_electricityVoltage;
	protected $_electricityHz;
	protected $_dangersAndAnnoyances;
	protected $_healthConditions;
	protected $_weatherOverview;
	protected $_countryDiallingCode;
	protected $_transport;
	protected $_historyPre20c;
	protected $_historyModern;
	protected $_historyRecent;
	protected $_productInfo;
	protected $_images;
	protected $_map;
	protected $_pois;
	protected $_attractions;
	protected $_copyright;
	protected $_countryId;
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
            $this->setMapper(new Application_Model_LonelyPlanetCountryMapper());
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

    public function setNodeId($nodeId)
	{
		$this->_nodeId = (int) $nodeId;
		return $this;
	}
	public function getNodeId()
	{
		return $this->_nodeId;
	}

	public function setDestinationName($destinationName)
	{
		$this->_destinationName = (string) $destinationName;
		return $this;
	}
	public function getDestinationName()
	{
		return $this->_destinationName;
	}

	public function setFullDestinationName($fullDestinationName)
	{
		$this->_fullDestinationName = (string) $fullDestinationName;
		return $this;
	}
	public function getFullDestinationName()
	{
		return $this->_fullDestinationName;
	}
	
	public function setIntroMini($introMini)
	{
		$this->_introMini = (string) $introMini;
		return $this;
	}
	public function getIntroMini()
	{
		return $this->_introMini;
	}
	
	public function setIntroShort($introShort)
	{
		$this->_introShort = (string) $introShort;
		return $this;
	}
	public function getIntroShort()
	{
		return $this->_introShort;
	}

	public function setWarningTitle($warningTitle)
	{
		$this->_warningTitle = (string) $warningTitle;
		return $this;
	}
	public function getWarningTitle()
	{
		return $this->_warningTitle;
	}

	public function setWarningText($warningText)
	{
		$this->_warningText = (string) $warningText;
		return $this;
	}
	public function getWarningText()
	{
		return $this->_warningText;
	}

	public function setWarningPosition($warningPosition)
	{
		$this->_warningPosition = (string) $warningPosition;
		return $this;
	}
	public function getWarningPosition()
	{
		return $this->_warningPosition;
	}

	public function setWarningSeverity($warningSeverity)
	{
		$this->_warningSeverity = (string) $warningSeverity;
		return $this;
	}
	public function getWarningSeverity()
	{
		return $this->_warningSeverity;
	}

	public function setTimezones($timezones)
	{
		$this->_timezones = (string) $timezones;
		return $this;
	}
	public function getTimezones()
	{
		return $this->_timezones;
	}
	
	public function setWeightsMeasuresSystem($weightsMeasuresSystem)
	{
		$this->_weightsMeasuresSystem = (string) $weightsMeasuresSystem;
		return $this;
	}
	public function getWeightsMeasuresSystem()
	{
		return $this->_weightsMeasuresSystem;
	}

	public function setCapitalCity($capitalCity)
	{
		$this->_capitalCity = (string) $capitalCity;
		return $this;
	}
	public function getCapitalCity()
	{
		return $this->_capitalCity;
	}

	public function setLeaders($leaders)
	{
		$this->_leaders = (string) $leaders;
		return $this;
	}
	public function getLeaders()
	{
		return $this->_leaders;
	}

	public function setGovernmentType($governmentType)
	{
		$this->_governmentType = (string) $governmentType;
		return $this;
	}
	public function getGovernmentType()
	{
		return $this->_governmentType;
	}

	public function setAreaSqkm($areaSqkm)
	{
		$this->_areaSqkm = (string) $areaSqkm;
		return $this;
	}
	public function getAreaSqkm()
	{
		return $this->_areaSqkm;
	}

	public function setPopulation($population)
	{
		$this->_population = (string) $population;
		return $this;
	}
	public function getPopulation()
	{
		return $this->_population;
	}
	
	public function setLanguageSpokens($languageSpokens)
	{
		$this->_languageSpokens = (string) $languageSpokens;
		return $this;
	}
	public function getLanguageSpokens()
	{
		return $this->_languageSpokens;
	}

	public function setReligion($religion)
	{
		$this->_religion = (string) $religion;
		return $this;
	}
	public function getReligion()
	{
		return $this->_religion;
	}

	public function setCurrencyCode($currencyCode)
	{
		$this->_currencyCode = (string) $currencyCode;
		return $this;
	}
	public function getCurrencyCode()
	{
		return $this->_currencyCode;
	}

	public function setCurrencyName($currencyName)
	{
		$this->_currencyName = (string) $currencyName;
		return $this;
	}
	public function getCurrencyName()
	{
		return $this->_currencyName;
	}

	public function setCurrencySymbol($currencySymbol)
	{
		$this->_currencySymbol = (string) $currencySymbol;
		return $this;
	}
	public function getCurrencySymbol()
	{
		return $this->_currencySymbol;
	}

	public function setCurrencyUnit($currencyUnit)
	{
		$this->_currencyUnit = (string) $currencyUnit;
		return $this;
	}
	public function getCurrencyUnit()
	{
		return $this->_currencyUnit;
	}
	
	public function setRelativeCostRooms($relativeCostRooms)
	{
		$this->_relativeCostRooms = (string) $relativeCostRooms;
		return $this;
	}
	public function getRelativeCostRooms()
	{
		return $this->_relativeCostRooms;
	}

	public function setRelativeCostMeals($relativeCostMeals)
	{
		$this->_relativeCostMeals = (string) $relativeCostMeals;
		return $this;
	}
	public function getRelativeCostMeals()
	{
		return $this->_relativeCostMeals;
	}

	public function setWhenToGo($whenToGo)
	{
		$this->_whenToGo = (string) $whenToGo;
		return $this;
	}
	public function getWhenToGo()
	{
		return $this->_whenToGo;
	}

	public function setVisasOverview($visasOverview)
	{
		$this->_visasOverview = (string) $visasOverview;
		return $this;
	}
	public function getVisasOverview()
	{
		return $this->_visasOverview;
	}

	public function setElectricalPlugs($electricalPlugs)
	{
		$this->_electricalPlugs = (string) $electricalPlugs;
		return $this;
	}
	public function getElectricalPlugs()
	{
		return $this->_electricalPlugs;
	}
	
	public function setElectricityVoltage($electricityVoltage)
	{
		$this->_electricityVoltage = (string) $electricityVoltage;
		return $this;
	}
	public function getElectricityVoltage()
	{
		return $this->_electricityVoltage;
	}

	public function setElectricityHz($electricityHz)
	{
		$this->_electricityHz = (string) $electricityHz;
		return $this;
	}
	public function getElectricityHz()
	{
		return $this->_electricityHz;
	}

	public function setDangersAndAnnoyances($dangersAndAnnoyances)
	{
		$this->_dangersAndAnnoyances = (string) $dangersAndAnnoyances;
		return $this;
	}
	public function getDangersAndAnnoyances()
	{
		return $this->_dangersAndAnnoyances;
	}

	public function setHealthConditions($healthConditions)
	{
		$this->_healthConditions = (string) $healthConditions;
		return $this;
	}
	public function getHealthConditions()
	{
		return $this->_healthConditions;
	}

	public function setWeatherOverview($weatherOverview)
	{
		$this->_weatherOverview = (string) $weatherOverview;
		return $this;
	}
	public function getWeatherOverview()
	{
		return $this->_weatherOverview;
	}

	public function setCountryDiallingCode($countryDiallingCode)
	{
		$this->_countryDiallingCode = (string) $countryDiallingCode;
		return $this;
	}
	public function getCountryDiallingCode()
	{
		return $this->_countryDiallingCode;
	}

	public function setTransport($transport)
	{
		$this->_transport = (string) $transport;
		return $this;
	}
	public function getTransport()
	{
		return $this->_transport;
	}

	public function setHistoryPre20c($historyPre20c)
	{
		$this->_historyPre20c = (string) $historyPre20c;
		return $this;
	}
	public function getHistoryPre20c()
	{
		return $this->_historyPre20c;
	}

	public function setHistoryModern($historyModern)
	{
		$this->_historyModern = (string) $historyModern;
		return $this;
	}
	public function getHistoryModern()
	{
		return $this->_historyModern;
	}

	public function setHistoryRecent($historyRecent)
	{
		$this->_historyRecent = (string) $historyRecent;
		return $this;
	}
	public function getHistoryRecent()
	{
		return $this->_historyRecent;
	}

	public function setProductInfo($productInfo)
	{
		$this->_productInfo = (string) $productInfo;
		return $this;
	}
	public function getProductInfo()
	{
		return $this->_productInfo;
	}

	public function setImages($images)
	{
		$this->_images = (string) $images;
		return $this;
	}
	public function getImages()
	{
		return $this->_images;
	}

	public function setMap($map)
	{
		$this->_map = (string) $map;
		return $this;
	}
	public function getMap()
	{
		return $this->_map;
	}

	public function setPois($pois)
	{
		$this->_pois = (string) $pois;
		return $this;
	}
	public function getPois()
	{
		return $this->_pois;
	}

	public function setAttractions($attractions)
	{
		$this->_attractions = (string) $attractions;
		return $this;
	}
	public function getAttractions()
	{
		return $this->_attractions;
	}

	public function setCopyright($copyright)
	{
		$this->_copyright = (string) $copyright;
		return $this;
	}
	public function getCopyright()
	{
		return $this->_copyright;
	}
    
	public function setCountryId($countryId)
    {
        $this->_countryId= (int) $countryId;
        return $this;
    }
    public function getCountryId()
    {
        return $this->_countryId;
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
	
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model = new Application_Model_LonelyPlanetCountry();
		$model->setId($row->id)
				->setNodeId($row->node_id)
				->setDestinationName($row->destination_name)
				->setFullDestinationName($row->full_destination_name)
				->setIntroMini($row->intro_mini)
				->setIntroShort($row->intro_short)
				->setWarningTitle($row->warning_title)
				->setWarningText($row->warning_text)
				->setWarningPosition($row->warning_position)
				->setWarningSeverity($row->warning_severity)
				->setTimezones($row->timezones)
				->setWeightsMeasuresSystem($row->weights_measures_system)
				->setCapitalCity($row->capital_city)
				->setLeaders($row->leaders)
				->setGovernmentType($row->government_type)
				->setAreaSqkm($row->area_sqkm)
				->setPopulation($row->population)
				->setLanguageSpokens($row->language_spokens)
				->setReligion($row->religion)
				->setCurrencyCode($row->currency_code)
				->setCurrencyName($row->currency_name)
				->setCurrencySymbol($row->currency_symbol)
				->setCurrencyUnit($row->currency_unit)
				->setRelativeCostRooms($row->relative_cost_rooms)
				->setRelativeCostMeals($row->relative_cost_meals)
				->setWhenToGo($row->when_to_go)
				->setVisasOverview($row->visas_overview)
				->setElectricalPlugs($row->electrical_plugs)
				->setElectricityVoltage($row->electricity_voltage)
				->setElectricityHz($row->electricity_hz)
				->setDangersAndAnnoyances($row->dangers_and_annoyances)
				->setHealthConditions($row->health_conditions)
				->setWeatherOverview($row->weather_overview)
				->setCountryDiallingCode($row->country_dialling_code)
				->setTransport($row->transport)
				->setHistoryPre20c($row->history_pre_20c)
				->setHistoryModern($row->history_modern)
				->setHistoryRecent($row->history_recent)
				->setProductInfo($row->product_info)
				->setImages($row->images)
				->setMap($row->map)
				->setPois($row->pois)
				->setAttractions($row->attractions)
				->setCopyright($row->copyright)
				->setCountryId($row->country_id)
				->setAddedon($row->addedon)
				;	
		 return $model;
    }
    
    public function save()
    {
		$data = array(
			'node_id' => $this->getNodeId(),
			'destination_name' => $this->getDestinationName(),
			'full_destination_name' => $this->getFullDestinationName(),
			'intro_mini' => $this->getIntroMini(),
			'intro_short' => $this->getIntroShort(),
			'warning_title' => $this->getWarningTitle(),
			'warning_text' => $this->getWarningText(),
			'warning_position' => $this->getWarningPosition(),
			'warning_severity' => $this->getWarningSeverity(),
			'timezones' => $this->getTimezones(),
			'weights_measures_system' => $this->getWeightsMeasuresSystem(),
			'capital_city' => $this->getCapitalCity(),
			'leaders' => $this->getLeaders(),
			'government_type' => $this->getGovernmentType(),
			'area_sqkm' => $this->getAreaSqkm(),
			'population' => $this->getPopulation(),
			'language_spokens' => $this->getLanguageSpokens(),
			'religion' => $this->getReligion(),
			'currency_code' => $this->getCurrencyCode(),
			'currency_name' => $this->getCurrencyName(),
			'currency_symbol' => $this->getCurrencySymbol(),
			'currency_unit' => $this->getCurrencyUnit(),
			'relative_cost_rooms' => $this->getRelativeCostRooms(),
			'relative_cost_meals' => $this->getRelativeCostMeals(),
			'when_to_go' => $this->getWhenToGo(),
			'visas_overview' => $this->getVisasOverview(),
			'electrical_plugs' => $this->getElectricalPlugs(),
			'electricity_voltage' => $this->getElectricityVoltage(),
			'electricity_hz' => $this->getElectricityHz(),
			'dangers_and_annoyances' => $this->getDangersAndAnnoyances(),
			'health_conditions' => $this->getHealthConditions(),
			'weather_overview'=>$this->getWeatherOverview(),
			'country_dialling_code'=>$this->getCountryDiallingCode(),
			'transport'=>$this->getTransport(),
			'history_pre_20c'=>$this->getHistoryPre20c(),
			'history_modern'=>$this->getHistoryModern(),
			'history_recent'=>$this->getHistoryRecent(),
			'product_info'=>$this->getProductInfo(),
			'images'=>$this->getImages(),
			'map'=>$this->getMap(),
			'pois'=>$this->getPois(),
			'attractions'=>$this->getAttractions(),
			'copyright'=>$this->getCopyright(),
			'country_id'=>$this->getCountryId()
		);

		if (null === ($id = $this->getId()))
		{
			unset($data['id']);
			$data['addedon']=time();
		    return $this->getMapper()->getDbTable()->insert($data);
		}
		else
		{
			$data['addedon']=time();
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
    
    public function delete($where=null)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }
    /*----Data Manupulation functions ----*/
}
