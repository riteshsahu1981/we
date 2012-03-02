<?php
class Admin_FeedsController extends Base_Controller_Action
{   	
	public function indexAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 13-Dec-2010
	 * @Description	: Used to check duplicate countries as per XML feeds
	 * @Input		: $country->string,
	 * @Return		: boolean
	 */
	private function duplicateCountries($country)
	{
		$countries = array("bahamas, the", "bahamas- the", "the bahamas", "the, bahamas", "the- bahamas"
							, "united arab emirates (uae)"
							, "gambia, the", "gambia- the", "the gambia", "the, gambia", "the- gambia"
							, "the netherlands", "the, netherlands", "the- netherlands","netherlands- the","netherlands, the"
							, "ivory coast"
							, "bosnia and herzegovina"
							, "vatican city"
							);
		$country = strtolower($country);
		if(in_array($country, $countries))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//Used to insert nationalities
	public function testAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//echo "ssss=&#231"; //CuraÃ§ao
		//$this->duplicateCountries("United Arab Emirates (uaE)");
		
		$directory="data/1615/xml/20100924/";
		$filename = "india-1807.xml";
		$file_path = $directory.$filename;
					
		//now load XML files and parse XMLs
		$data=array();
		
		
		$destination = simplexml_load_file($file_path);

		$pre = 'pre-departure';
		
		if($destination->$pre->electrical_plugs)
		{
			$ep = 0;
			$arrayElectricalPlugs = array();
			foreach($destination->$pre->electrical_plugs->children() as $electrical_plugs)
			{
				$arrayElectricalPlugs[$ep]['image_filename'] = (string)$electrical_plugs->image_filename;
				$arrayElectricalPlugs[$ep]['electrical_plug_description'] = (string)$this->replaceText($electrical_plugs->electrical_plug_description, true);
				$ep++;
			}
			echo "<pre>";
			print_r($arrayElectricalPlugs);
			echo "</pre>";
			//$data["electrical_plugs"] = serialize($arrayElectricalPlugs);
		}
					
		/*
		//get nationalities text from file and insert into database
		$file_path = "data/nationalities/nationalities.txt";
		$fileContent = file_get_contents($file_path);
		
		$nationalities = explode("\n",$fileContent);
		
		$db=Zend_Registry::get("db");
		foreach($nationalities as $key=>$value)
		{
			$sSQL = "";
			$sSQL = "INSERT INTO nationalities (nationality, country_id, created, status) values('".$value."', 0, '".date('Y-m-d H:i:s')."', 1)";
			$db->query($sSQL);
		}
		*/
	}
	
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 15-Dec-2010
	 * @Description	: Used to get city name from XML feeds and relate Place images with these cities
	 */
	public function placeImagesAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		//$strFile = "Place_Europe_Austria_Vienna";
		//echo strtolower($strFile);
		//exit;
		$sanitizeM = new Base_Sanitize();
		
		$cityImgDir = "media/picture/city/";
		$cityImgCount = 10;
		$directory = "data/zone/XML/";
		if(!($dp = opendir($directory))) die("Cannot open $directory.");
		
		//truncate tables
		$db = Zend_Registry::get("db");
		$db->query("TRUNCATE TABLE city_images");
		
		//read XML feeds directory
		while($filename = readdir($dp))
		{
			if(is_dir($filename))
			{
				continue;
			}
			else if($filename != '.' && $filename != '..')
			{
				$file_path = $directory.$filename;
				
				$fileNameArr	= explode(".", $filename);
				$sfileName		= strtolower($fileNameArr[count($fileNameArr)-2]);
				
				
				$xml_parser = new Base_Xml_Parser(null, $file_path);
				$cityName	= "";
				if(isset($xml_parser->Data['identification']['geoTag3']))
				{
					$cityName = $sanitizeM->clearInputs($xml_parser->Data['identification']['geoTag3']);
				
				    if($cityName<>"")
					{
						$cityM = new Application_Model_City();
						$city  = $cityM->fetchRow("name='{$cityName}'");
						if($city)
						{
							$city_id = $city->getId();
						}
						echo "<br><br>---------------------------------------------------------------------------------<br>";
						echo "File=>".$sfileName." City=>".$cityName." City Id=>".$city_id;
						
						for($img=1; $img<=$cityImgCount; $img++)
						{
							$cityImageName = $sfileName."_".$img.".jpg";
							if(file_exists($cityImgDir.$cityImageName))
							{
								echo "<br>City Image is ".$cityImageName." for file=> ".$sfileName;
								
								//now insert images in city_image table
								$sSQL = "";
								$sSQL = "INSERT INTO city_images (city_id, city_image, status) values('".$city_id."', '".$cityImageName."', 1)";
								$db->query($sSQL);
							}
						}
						echo "<br>---------------------------------------------------------------------------------";
					}//end of if
					
				}//end of if			
			}//end of else if
		}//end of main while loop
		/*
		//set SEOl URLs for static pages		
		$staticPageSeoUrls = array("/index/about"=>"/about","/index/contact"=>"/contact","/index/competition"=>"/competition","/index/work-for-us"=>"/work-for-us","/index/safety-policy"=>"/safety-policy","/index/terms-conditions"=>"/terms-conditions","/index/privacy-policy"=>"/privacy-policy","/index/press-media"=>"/press-media","/index/advertising-and-partnerships"=>"/advertising-and-partnerships","/index/video"=>"/video","/index/photos"=>"/photos");
		foreach($staticPageSeoUrls as $key=>$value)
		{
			$sSQL = "";
			$sSQL = "INSERT INTO seo_url (actual_url, seo_url) values('".$key."','".$value."')";
			$db->query($sSQL);
		}*/

	}//end of function
	
	//zone feeds
	public function xmlAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$db=Zend_Registry::get("db");
		
		$sanitizeM = new Base_Sanitize();
        
		$directory="data/zone/XML/";
		if(!($dp = opendir($directory))) die("Cannot open $directory.");
		$ctr=0;
		
		//truncate tables
		$db->query("TRUNCATE TABLE destination");
		$db->query("TRUNCATE TABLE experiences");
		$db->query("TRUNCATE TABLE practicalities");
		$db->query("TRUNCATE TABLE dont_leave_without");
		$db->query("TRUNCATE TABLE lonely_planet_country");
		$db->query("TRUNCATE TABLE eat_sleep_drink");
		$db->query("TRUNCATE TABLE log");
		$db->query("TRUNCATE TABLE error_log");
		$db->query("TRUNCATE TABLE area");
		$db->query("TRUNCATE TABLE region");
		$db->query("TRUNCATE TABLE continent");
		$db->query("TRUNCATE TABLE country");
		$db->query("TRUNCATE TABLE city");
		$db->query("TRUNCATE TABLE seo_url");

		//------------------------------
		while($filename = readdir($dp))
		{
			$res=$db->fetchAll("select * from log where message='{$filename}'");

			if(is_dir($filename))
			{
				continue;
			}
			else if($filename != '.' && $filename != '..' && empty($res))
			{
			   
				$file_path = $directory.$filename;
			  
				$data['message'] = $filename;
				$data['log_start'] = date("Y-m-d H:i:s");
				$log_id=$db->insert( "log", $data);


				$xml_parser = new Base_Xml_Parser(null, $file_path);

				$continentName="";
				if(isset($xml_parser->Data['identification']['geoTag1']))
					$continentName = $sanitizeM->clearInputs($xml_parser->Data['identification']['geoTag1']);

				$countryName="";
				if(isset($xml_parser->Data['identification']['geoTag2']))
					$countryName = $sanitizeM->clearInputs($xml_parser->Data['identification']['geoTag2']);
				$cityName="";
				if(isset($xml_parser->Data['identification']['geoTag3']))
					$cityName = $sanitizeM->clearInputs($xml_parser->Data['identification']['geoTag3']);
				
				$regionName=$cityName;
				$areaName=$cityName;
				//----insert into continent
					$continent_id=0;
					if($continentName<>""){
						$continentM=new Application_Model_Continent();
						$continent=$continentM->fetchRow("name='{$continentName}'");
						if(false===$continent)
						{
								$continentM->setName($continentName);
								$continent_id=$continentM->save();
						}
						else
						{
								$continent_id=$continent->getId();
						}
					}
				//--------------------------

				//----insert into country
					$country_id=0;
					if($countryName<>"")
					{
						//if not exists
						if(!$this->duplicateCountries($countryName))
						{
							$countryM	= new Application_Model_Country();
							$country	= $countryM->fetchRow("name='{$countryName}' and continent_id='{$continent_id}'");
							if(false===$country)
							{
								$countryM->setName($countryName);
								$countryM->setContinentId($continent_id);
								$country_id=$countryM->save();
							}
							else
							{
								$country_id=$country->getId();
							}
						}	
					}
				//-------------------------------


				//------insert into region
				$region_id=0;
				$regionM=new Application_Model_Region();
				$region=$regionM->fetchRow("name='{$regionName}' and country_id='{$country_id}' AND continent_id='{$continent_id}'");
				if(false===$region)
				{
						$regionM->setName($regionName);
						$regionM->setCountryId($country_id);
						$regionM->setContinentId($continent_id);
						$region_id=$regionM->save();
				}
				else
				{
						$region_id=$region->getId();
				}				
				
				//------insert into city
					$city_id=0;
					if($cityName<>"")
					{
						$cityM=new Application_Model_City();
						$city=$cityM->fetchRow("name='{$cityName}' and region_id='{$region_id}' AND country_id='{$country_id}' AND continent_id='{$continent_id}'");
						if(false===$city)
						{
							if($country_id!=0)
							{
								//echo "<br />File name=".$file_path;
								$cityM->setName($cityName);
								$cityM->setRegionId($region_id);
								$cityM->setCountryId($country_id);
								$cityM->setContinentId($continent_id);
								$cityM->setFeaturedTop(0);
								$cityM->setFeaturedOther(0);
								$city_id=$cityM->save();
							}	
						}
						else
						{
							$city_id=$city->getId();
						}
					}
				//------------------------

			   //------insert into area
					$area_id=0;
					$areaM=new Application_Model_Area();
					$area=$areaM->fetchRow("name='{$areaName}' and city_id='{$city_id}' and region_id='{$region_id}' AND country_id='{$country_id}' AND continent_id='{$continent_id}' ");
					if(false===$area){
							$areaM->setName($areaName);
							$areaM->setRegionId($region_id);
							$areaM->setCountryId($country_id);
							$areaM->setContinentId($continent_id);
							$areaM->setCityId($city_id);
							$area_id=$areaM->save();
					}else{
							$area_id=$area->getId();
					}
				//------------------------

				if($continent_id>0 && $country_id>0 && $city_id>0 ){
						//it is city
						$locationType="city";
						$locationId=$city_id;
				}else if($continent_id>0 && $country_id>0){
						//it is country
						$locationType="country";
						$locationId=$country_id;
				}else if($continent_id>0){
						//it is continent
						$locationType="continent";
						$locationId=$continent_id;
				}

				if(isset($xml_parser->Data['content'])){
				$title = $sanitizeM->clearInputs($xml_parser->Data['content']['title']);
				$introduction="";
				if(isset($xml_parser->Data['content']['introduction']))
					$introduction=$xml_parser->Data['content']['introduction'];
				
				$destinationM	=	new Application_Model_Destination();
				
				$bankBreakerPincher = "";
				$knowledgeArr = "";
				//set bank breaker array to save
				if(isset($xml_parser->Data['content']['costs']))
				{
					$bank_breaker 	= array();
					$bankBreaker	= array();
					foreach ($xml_parser->Data['content']['costs'] as $breaker)
					{
						$bank_breaker[] = $breaker;
					}
					//break into two array
					$costItem = $bank_breaker[0];
					$dailyBudget = $bank_breaker[1];
					
					for($cntBr=0; $cntBr<count($costItem); $cntBr++)
					{
						$bankBreaker[$costItem[$cntBr]['name']] = substr($costItem[$cntBr]['rating'],0,strlen($costItem[$cntBr]['rating'])-1);
					}
					//keep in one array
					$bankBreakerPincher = array("bankBreaker"=>$bankBreaker,"dailyBudget"=>$dailyBudget);
				}
				if(isset($xml_parser->Data['content']['knowledge']))
				{
					$knowledgeArr	= array();
					$knowledge = $xml_parser->Data['content']['knowledge'];
					$knowledgeArr = $knowledge['item'];
				}	
				
				$destinationM->setTitle($title);
				$destinationM->setIntroduction($introduction);
				$destinationM->setLocationId($locationId);
				$destinationM->setLocationType($locationType);
				$destinationM->setBankBreaker(serialize($bankBreakerPincher));
				$destinationM->setKnowledge(serialize($knowledgeArr));
				
				$destination_id=$destinationM->save();

				if(isset($xml_parser->Data['content']['experiences'])){
					foreach ($xml_parser->Data['content']['experiences'] as $experiences)
					{

						foreach($experiences as $_item){
							$experiencesM=new Application_Model_Experiences();
							$experiencesM->setTitle($_item['title']);
							$experiencesM->setDestinationId($destination_id);
							$experiencesM->setCopy($_item['copy']);
							$experiencesM->save();
						}
					}
				}

				if(isset($xml_parser->Data['content']['dontLeaveWithout'])){
					foreach ($xml_parser->Data['content']['dontLeaveWithout'] as $dontLeaveWithout)
					{

						foreach($dontLeaveWithout as $_item){
							$dontLeaveWithoutM=new Application_Model_DontLeaveWithout();
							$dontLeaveWithoutM->setTitle($_item['title']);
							$dontLeaveWithoutM->setDestinationId($destination_id);
							$dontLeaveWithoutM->setCopy($_item['copy']);
							$dontLeaveWithoutM->save();
						}
					}
				}

				if(isset($xml_parser->Data['content']['practicalities'])){
					foreach ($xml_parser->Data['content']['practicalities'] as $practicalities)
					{

						foreach($practicalities as $_item){
							$practicalitiesM=new Application_Model_Practicalities();
							$practicalitiesM->setTitle($_item['title']);
							$practicalitiesM->setDestinationId($destination_id);
							$practicalitiesM->setCopy($_item['copy']);
							$practicalitiesM->save();
						}
					}
				}
				
				if(isset($xml_parser->Data['content']['eatSleepDrink'])){
					foreach ($xml_parser->Data['content']['eatSleepDrink'] as $eatsleepdrink)
					{
						foreach($eatsleepdrink as $_item){
							$EatSleepDrinkM=new Application_Model_EatSleepDrink();
							$EatSleepDrinkM->setTitle($_item['title']);
							$EatSleepDrinkM->setDestinationId($destination_id);
							$EatSleepDrinkM->setBackPackerCopy($_item['backpackerCopy']);
							$EatSleepDrinkM->setLocalCopy($_item['localCopy']);
							$EatSleepDrinkM->save();
						}
					}
				}

				$data['log_end']=date("Y-m-d H:i:s");
				$res=$db->update( "log", $data, "id='$log_id'");
				}			
			}
		}//end of main while loop

	}//end of function


	//Lonely planet xml feeds
	public function lonelyCountryAction()
	{
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $db=Zend_Registry::get("db");
             $db->query("TRUNCATE TABLE lonely_planet_country");
            $directory="data/1615/xml/20100924/";
            //$directory="data/1615/xml/test/";
            if(!($dp = opendir($directory))) die("Cannot open $directory.");
            while($filename = readdir($dp))
            {
                if(is_dir($filename))
                {
                    continue;
                }
                else if($filename != '.' && $filename != '..')
                {
                    
                   $file_path=$directory.$filename;
                    
                    /*
					$destination = simplexml_load_file($file_path);
                    $data["node_id"]=(string)$destination["node_id"];
                    $data["destination_name"]=(string)$destination->destination_name;
                    $data["full_destination_name"]=(string)$destination->general->full_destination_name;
                    $data["intro_mini"]=(string)$destination->general->intro_mini->p;
                    $data["intro_short"]=(string)$destination->general->intro_short->p;
                    $data["warning_title"]=(string)$destination->general->warning_title;
                    $data["warning_text"]=(string)$destination->general->warning_text->p;
                    $data["warning_position"]=(string)$destination->general->warning_position;
                    $data["warning_severity"]=(string)$destination->general->warning_severity;
                    //$data["timezones"]=serialize($destination->general->timezones);
					if($destination->general->timezones)
					{
					   $tz = 0;
					   foreach($destination->general->timezones->children() as $timezone)
					   {
						   $arrayTimezone[$tz]['gmt_utc']=(string)$timezone->gmt_utc;
						   $tz++;
					   }
                    }
                    $data["timezones"]=serialize($arrayTimezone);
					
                    $data["weights_measures_system"]=(string)$destination->general->weights_measures_system;
                    $data["capital_city"]=(string)$destination->general->capital_city;
                    $data["leaders"]=serialize($destination->government->leaders);
                    $data["government_type"]=(string)$destination->government->government_type;
                    $data["area_sqkm"]=(string)$destination->environment->area_sqkm;
                    $data["population"]=(string)$destination->environment->population;

                    
                    echo "<pre>";
                    //print_r($destination->society->language_spokens);
                    $i=0;
                     echo $file_path;
                     if($destination->society->language_spokens){
                   foreach($destination->society->language_spokens->children() as $language_spoken)
                   {
                       $arrayLanguage[$i]['language_spoken_type']=(string)$language_spoken->language_spoken_type;
                       $arrayLanguage[$i]['language_spoken_name']=(string)$language_spoken->language_spoken_name;
                       if($language_spoken->language_spoken_description)
                       $arrayLanguage[$i]['language_spoken_description']=(array)$language_spoken->language_spoken_description->children();
                       $i++;
                   }
                     }
                    $data["language_spokens"]=serialize($arrayLanguage);
                   
                    $data["religion"]=(string)$destination->society->religion->p;
                    $data["currency_code"]=(string)$destination->economy->currency_code;
                    $data["currency_name"]=(string)$destination->economy->currency_name;
                    $data["currency_symbol"]=(string)$destination->economy->currency_symbol;
                    $data["currency_unit"]=(string)$destination->economy->currency_unit;
                    $data["relative_cost_rooms"]=serialize($destination->money->relative_cost_rooms);
                    $data["relative_cost_meals"]=serialize($destination->money->relative_cost_meals);

                    $pre='pre-departure';
                    $when_to_go=$destination->$pre->when_to_go;
                    $data["when_to_go"]=serialize($when_to_go);

                    $arr=(array)$destination->$pre->visas_overview;

                   

                    if(is_array($arr['p']))
                        $data["visas_overview"]=implode("<br>",$arr['p']);
                     else
                         $data["visas_overview"]=$arr['p'];
                    //print_r($destination->$pre->visas_overview);


                    $data["electrical_plugs"]=serialize($destination->$pre->electrical_plugs);

                    $data["electricity_voltage"]=(string)$destination->$pre->electricity_voltage;
                    $data["electricity_hz"]=(string)$destination->$pre->electricity_hz;


                    $arr=(array)$destination->health->dangers_and_annoyances;

                    if(is_array($arr['p']))
                        $data["dangers_and_annoyances"]=implode("<br>",$arr['p']);
                     else
                         $data["dangers_and_annoyances"]=$arr['p'];

                    $data["health_conditions"]=serialize($destination->health->health_conditions);
                    $data["weather_overview"]=(string)$destination->weather->weather_overview->p;
                    $data["country_dialling_code"]=(string)$destination->communication->country_dialling_code;
                    $data["transport"]=(string)$destination->transport;

                    $arr=(array)$destination->culture->history_pre_20c;
                     if(is_array($arr['p']))
                        $data["history_pre_20c"]=implode("<br>",$arr['p']);
                     else
                         $data["history_pre_20c"]=$arr['p'];

                   

                    $arr=(array)$destination->culture->history_modern;
                    
                     if(is_array($arr['p']))
                        $data["history_modern"]=implode("<br>",$arr['p']);
                     else
                         $data["history_modern"]=$arr['p'];

                    $arr=(array)$destination->culture->history_recent;
                  
                    if(is_array($arr['p']))
                        $data["history_recent"]=implode("<br>",$arr['p']);
                    else
                        $data["history_recent"] =$arr['p'];

                    $data["product_info"]=serialize($destination->product_info);
                    $data["images"]=serialize($destination->images);
                    $data["map"]=serialize($destination->map);
                    
                 
                 //print_r((array)$destination->pois);
                    $i=0;
                    foreach($destination->pois->children() as $poi)
                    {

                        $arrayPoi[$i]['poi_name']=(string)$poi->poi_name;
                     
                         $arrayPoi[$i]['poi_name']=(string)$poi->poi_name;

                         $address_parts=(array)$poi->address_parts;

                            //print_r($address_parts['address_part']);
                         $addressPart=array();
                            foreach($address_parts['address_part'] as $address_part)
                            {
                               $addressPart[]=(array)$address_part;
                            }
                         $arrayPoi[$i]['address_parts']   =$addressPart;

                         $arrayPoi[$i]['address_postcode']=(string)$poi->address_postcode;
                         $arrayPoi[$i]['poi_web']=(string)$poi->poi_web;
                         $arrayPoi[$i]['review_summary']=(array)$poi->review_summary;
                         $arrayPoi[$i]['review_full']=(array)$poi->review_full;
                         $arrayPoi[$i]['keywords']=(array)$poi->keywords;

                         $i++;
                        //echo "hell";
                           
                    }
                    //$data["pois"]=serialize($destination->pois);
                    $data["pois"]=serialize($arrayPoi);
                    
                    $data["attractions"]=serialize($destination->attractions);
                    $data["copyright"]=(string)$destination->copyright;
                    $data["addedon"]=time();
					*/
					$destination = simplexml_load_file($file_path);
					$data["node_id"]=(string)$destination["node_id"];
					$data["destination_name"]=(string)$destination->destination_name;
					$data["full_destination_name"]=(string)$destination->general->full_destination_name;
					$data["intro_mini"]=(string)$destination->general->intro_mini->p;
					$data["intro_short"]=(string)$destination->general->intro_short->p;
					$data["warning_title"]=(string)$destination->general->warning_title;
					$data["warning_text"]=(string)$destination->general->warning_text->p;
					$data["warning_position"]=(string)$destination->general->warning_position;
					$data["warning_severity"]=(string)$destination->general->warning_severity;
					//$data["timezones"]=serialize($destination->general->timezones);
					if($destination->general->timezones)
					{
					   $tz = 0;
					   $arrayTimezone = array();
					   foreach($destination->general->timezones->children() as $timezone)
					   {
						   $arrayTimezone[$tz]['gmt_utc']=(string)$timezone->gmt_utc;
						   $tz++;
					   }
					   $data["timezones"]=serialize($arrayTimezone);
					}
							
					$data["weights_measures_system"]=(string)$destination->general->weights_measures_system;
					$data["capital_city"]=(string)$destination->general->capital_city;
					//$data["leaders"]=serialize($destination->government->leaders);
					if($destination->government->leaders)
					{
					   $ld = 0;
					   $arrayLeaders = array();
					   foreach($destination->government->leaders->children() as $leader)
					   {
						   $arrayLeaders[$ld]['leader_name']=(string)$leader->leader_name;
						   $arrayLeaders[$ld]['leader_type']=(string)$leader->leader_type;
						   $arrayLeaders[$ld]['leader_title']=(string)$leader->leader_title;
						   $ld++;
					   }
					   $data["leaders"] = serialize($arrayLeaders);
					}
							
					$data["government_type"]=(string)$destination->government->government_type;
					$data["area_sqkm"]=(string)$destination->environment->area_sqkm;
					$data["population"]=(string)$destination->environment->population;

					$i=0;		
					if($destination->society->language_spokens)
					{
					   $arrayLanguage = array();
					   foreach($destination->society->language_spokens->children() as $language_spoken)
					   {
						   $arrayLanguage[$i]['language_spoken_type']=(string)$language_spoken->language_spoken_type;
						   $arrayLanguage[$i]['language_spoken_name']=(string)$language_spoken->language_spoken_name;
						   if($language_spoken->language_spoken_description)
						   $arrayLanguage[$i]['language_spoken_description']=(array)$language_spoken->language_spoken_description->children();
						   $i++;
					   }
					   $data["language_spokens"]=serialize($arrayLanguage);
					}
						   
					$data["religion"]=(string)$destination->society->religion->p;
					$data["currency_code"]=(string)$destination->economy->currency_code;
					$data["currency_name"]=(string)$destination->economy->currency_name;
					$data["currency_symbol"]=(string)$destination->economy->currency_symbol;
					$data["currency_unit"]=(string)$destination->economy->currency_unit;
					$data["relative_cost_rooms"]=serialize($destination->money->relative_cost_rooms);
					$data["relative_cost_meals"]=serialize($destination->money->relative_cost_meals);

					$pre='pre-departure';
					$when_to_go = $destination->$pre->when_to_go;
					//$data["when_to_go"] = serialize($when_to_go);
					
					$arrayWhenToGo = (array)$when_to_go;
					if(is_array($arrayWhenToGo['p']))
					{
						$data["when_to_go"] = implode("<br>",$arrayWhenToGo['p']);
					}
					else
					{
						$data["when_to_go"]= $arrayWhenToGo['p'];
					}
						 
					$arr=(array)$destination->$pre->visas_overview;
					if(is_array($arr['p']))
						$data["visas_overview"]=implode("<br>",$arr['p']);
					 else
						 $data["visas_overview"]=$arr['p'];
					
					//$data["electrical_plugs"]=serialize($destination->$pre->electrical_plugs);
					if($destination->$pre->electrical_plugs)
					{
					   $ep = 0;
					   $arrayElectricalPlugs = array();
					   foreach($destination->$pre->electrical_plugs->children() as $electrical_plugs)
					   {
						   $arrayElectricalPlugs[$ep]['image_filename'] = $electrical_plugs->image_filename;
						   $arrayElectricalPlugs[$ep]['electrical_plug_description'] = $electrical_plugs->electrical_plug_description;
						   $ep++;
					   }
					   $data["electrical_plugs"] = serialize($arrayElectricalPlugs);
					}
					
					$data["electricity_voltage"]=(string)$destination->$pre->electricity_voltage;
					$data["electricity_hz"]=(string)$destination->$pre->electricity_hz;


					$arr=(array)$destination->health->dangers_and_annoyances;

					if(is_array($arr['p']))
						$data["dangers_and_annoyances"]=implode("<br>",$arr['p']);
					 else
						 $data["dangers_and_annoyances"]=$arr['p'];

					$data["health_conditions"]=serialize($destination->health->health_conditions);
					$data["weather_overview"]=(string)$destination->weather->weather_overview->p;
					$data["country_dialling_code"]=(string)$destination->communication->country_dialling_code;
					
					//$data["transport"]=(string)$destination->transport;
					if($destination->transport)
					{
					   $tp = 0;
					   foreach($destination->transport->destination_transport_topics->children() as $transport)
					   {
						   $arrTrans = (array)$transport->transport_description;
							if(is_array($arrTrans['p']))
								$data_transport = implode("<br>",$arrTrans['p']);
							 else
								 $data_transport = $arrTrans['p'];
								 
						   $arrayTransport[$tp] = $data_transport;
						   $tp++;
					   }
					   $data["transport"] = serialize($arrayTransport);
					}	

					$arr=(array)$destination->culture->history_pre_20c;
					 if(is_array($arr['p']))
						$data["history_pre_20c"]=implode("<br>",$arr['p']);
					 else
						 $data["history_pre_20c"]=$arr['p'];

					$arr=(array)$destination->culture->history_modern;
					
					 if(is_array($arr['p']))
						$data["history_modern"]=implode("<br>",$arr['p']);
					 else
						 $data["history_modern"]=$arr['p'];

					$arr=(array)$destination->culture->history_recent;
				  
					if(is_array($arr['p']))
						$data["history_recent"]=implode("<br>",$arr['p']);
					else
						$data["history_recent"] =$arr['p'];

					$data["product_info"]=serialize($destination->product_info);
					//$data["images"]=serialize($destination->images);
					if($destination->images)
					{
					   $img = 0;
						$arrayImages = array();
						foreach($destination->images->children() as $image)
						{
							$arrayImages[$img]['image_caption']=(string)$image->image_caption;
							$arrayImages[$img]['image_photographer']=(string)$image->image_photographer;
							$arrayImages[$img]['image_filename'] = (string)$image->image_filename;
							$arrayImages[$img]['image_thumbnail_filename'] = (string)$image->image_thumbnail_filename;
							$img++;
						}
						$data["images"] = serialize($arrayImages);
					}
					
					//$data["map"] = serialize($destination->map);
					if($destination->map)
					{
						$arrayMaps = array();
						$arrayMaps['map_name']=(string)$destination->map->map_name;
						$arrayMaps['map_filename']=(string)$destination->map->map_filename;
						$arrayMaps['map_thumbnail_filename'] = (string)$destination->map->map_thumbnail_filename;
						$data["map"] = serialize($arrayMaps);
					}		
				 
					$i=0;
					foreach($destination->pois->children() as $poi)
					{

						$arrayPoi[$i]['poi_name']=(string)$poi->poi_name;

						$address_parts=(array)$poi->address_parts;

						//print_r($address_parts['address_part']);
						$addressPart=array();
						if(isset($address_parts['address_part']) && count($address_parts['address_part'])>0)
						{
							foreach($address_parts['address_part'] as $address_part)
							{
							   $addressPart[]=(array)$address_part;
							}
							$arrayPoi[$i]['address_parts']   =$addressPart;
						}	 

						 $arrayPoi[$i]['address_postcode']=(string)$poi->address_postcode;
						 $arrayPoi[$i]['poi_web']=(string)$poi->poi_web;
						 $arrayPoi[$i]['review_summary']=(array)$poi->review_summary;
						 $arrayPoi[$i]['review_full']=(array)$poi->review_full;
						 $arrayPoi[$i]['keywords']=(array)$poi->keywords;

						 $i++;
					}
					$data["pois"]=serialize($arrayPoi);
					
					//$data["attractions"]=serialize($destination->attractions);
					if($destination->attractions)
					{
						$attr = 0;
						$arrayAttr = array();
						foreach($destination->attractions->children() as $attraction)
						{
							$arrayAttr[$attr]['destination_name']=(string)$attraction->destination_name;
							$arrayAttr[$attr]['full_destination_name']=(string)$attraction->general->full_destination_name;
							$arrayAttr[$attr]['intro_short']=(string)$attraction->general->intro_short->p;
							$arrayAttr[$attr]['intro_medium']=(string)$attraction->general->intro_medium->p;
							$attr++;
						}
						$data["attractions"] = serialize($arrayAttr);
					}
					$data["copyright"]=(string)$destination->copyright;
					$data["addedon"]=time();
                     /*----Country Info----*/
                    $countryM=new Application_Model_Country();
                    $countryName=$data["destination_name"];
                    
                    if(!get_magic_quotes_gpc ())
                    $countryName=  addslashes($countryName);

                  //  $countryName=@mb_convert_encoding($countryName, 'UTssssF8', 'auto');
                    $country=$countryM->fetchRow("name like '{$countryName}'");
                    if(false===$country)
                    {
                        $countryM->setName($data["destination_name"]);
                        $country_id=$countryM->save();
                    }
                    else
                    {
                        $country_id=$country->getId();
                    }
                    $data['country_id']=$country_id;
                    /*---------------*/
                    
                    $res=$db->insert( "lonely_planet_country", $data);
                 
                }
            }
            closedir($dp);
           
		
	}
    
    
    
    
	public function poiAction()
	{
		
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	echo "<pre>";
	$filename = "data/lonelyplanet-london-gapdaemon.xml";
	$xml_parser = new Base_Xml_Parser(null, $filename); 
	
	 $destinationName=$xml_parser->Data['destination_name'];
	
	
	//----insert into continent
		$continent_id=0;
		$continentM=new Application_Model_Continent();
	
		$continent=$continentM->fetchRow("name='{$destinationName}'");
		if(false!==$continent)
		{
			$continent_id=$continent->getId();
		}
	//--------------------------
	
	//----insert into country
		$country_id=0;
		$countryM=new Application_Model_Country();
		$country=$countryM->fetchRow("name='{$destinationName}'");
		if(false!==$country){
			$country_id=$country->getId();
		}
	//-------------------------------

		
 
	///------insert into city
		$city_id=0;
		$cityM=new Application_Model_City();
		$city=$cityM->fetchRow("name='{$destinationName}'");
		if(false!==$city){
			$city_id=$city->getId();	
		}
	//------------------------

	if($city_id>0 ){
		//it is city
		$locationType="city";
		$locationId=$city_id;
	}else if($country_id>0){
		//it is country
		$locationType="country";
		$locationId=$country_id;
	}else if($continent_id>0){
		//it is continent
		$locationType="continent";
		$locationId=$continent_id;
	}else{
		//create a place/city and get the reference id/location id
		
		///------insert into city
		$city_id=0;
		$cityM=new Application_Model_City();
		$cityM->setName($destinationName);
		$cityM->setCountryId(0);
		$city_id=$cityM->save();
		//------------------------
	
		$locationType="other";
		$locationId=$city_id;
	}
	error_reporting(E_ALL&~(E_NOTICE));

	foreach($xml_parser->Data['pois']['poi'] as $poi){

			$poiM = new Application_Model_Poi();
            $poiM  	->setLocationId($locationId)
                	->setLocationType($locationType)
                	->setName($poi['poi_name'])
                	->setAddress(serialize($poi['address_parts']['address_part']))
                	->setPostcode($poi['address_postcode'])
                	->setTelfaxs(serialize($poi['telfaxs']['telfax']))
                	->setEmail($poi['poi_email'])
                	->setWeb($poi['poi_web'])
                	->setTransportModes(serialize($poi['transport_modes']['transport_mode']))
                	->setPriceRange($poi['price_range'])
                	->setReviewFull($poi['review_full']['p'])
                	->setReviewSummary($poi['review_summary']['p'])
                	->setBookable($poi['bookable']['value'])
                	->setXCoordinate($poi['feature_x_coord'])
                	->setYCoordinate($poi['feature_y_coord'])
                	->setFeatureId($poi['feature_id'])
                	->setKeywords(serialize($poi['keywords']['keyword']))              	
                	;
                	$poiM->save();
		
		
	}
	

    }
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 2-Dec-2010
	 * @Description	: Used to replace HTML tags from given string and also reverse back rpelaced tags with html tags
	 * @Input		: $fileContent->string, $reverse->boolean
	 * @Return		: string
	 */
	public function replaceText($fileContent, $reverse=false)
	{
		$search = array('<p>','</p>','<ul>','</ul>','<li>','</li>','<b>','</b>','<i>','</i>','<strong>','</strong>','<a href','</a>');
		$replace = array('ONSPTAGSTART','ONSPTAGEND','ONSULTAGSTART','ONSULTAGEND','ONSLITAGSTART','ONSLITAGEND','ONSBTAGSTART','ONSBTAGEND','ONSITAGSTART','ONSITAGEND','ONSSTRONGTAGSTART','ONSSTRONGTAGEND','ONSAHREFTAGSTART','ONSAHREFTAGEND');

		if($reverse)
		{
			for($cnt=0; $cnt<count($search); $cnt++)
			{
				$fileContent = str_replace($replace[$cnt], $search[$cnt], $fileContent);
			}
		}
		else
		{
			for($cnt=0; $cnt<count($search); $cnt++)
			{
				$fileContent = str_replace($search[$cnt], $replace[$cnt], $fileContent);
			}
		}
		return $fileContent;
		
		/*
		// Read file line by line and write
		$file = fopen($file_path, 'r');
		$temp = tempnam($directory, 'tmp');
		
		if (is_resource($file) === true)
		{
			$lineStr = "";
			while (feof($file) === false)
			{
				$lineStr = fgets($file);
				
				$lineStr = str_replace("<p>", "ONSPTAGSTART", $lineStr);
				$lineStr = str_replace("</p>", "ONSPTAGEND", $lineStr);
				$lineStr = str_replace("<ul>", "ONSULTAGSTART", $lineStr);
				$lineStr = str_replace("</ul>", "ONSULTAGEND", $lineStr);
				$lineStr = str_replace("<li>", "ONSLITAGSTART", $lineStr);
				$lineStr = str_replace("</li>", "ONSLITAGEND", $lineStr);
				$lineStr = str_replace("<b>", "ONSBTAGSTART", $lineStr);
				$lineStr = str_replace("</b>", "ONSBTAGEND", $lineStr);
				$lineStr = str_replace("<i>", "ONSITAGSTART", $lineStr);
				$lineStr = str_replace("</i>", "ONSITAGEND", $lineStr);
				$lineStr = str_replace("<strong>", "ONSSTRONGTAGSTART", $lineStr);
				$lineStr = str_replace("</strong>", "ONSSTRONGTAGEND", $lineStr);
				file_put_contents($temp, $lineStr, FILE_APPEND);				
			}
			fclose($file);
		}
		//unlink($path);
		//rename($temp, $file_path);
		rename($temp, $directory."india_new.xml");
		exit;
		*/
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 2-Dec-2010
	 * @Description	: Used to parse Lonely Planet Country XML and save data to database table
	 */
	public function lonelyXmlAction()
	{
		//disable layout and view
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//create Db and Sanitize class objects
		$db = Zend_Registry::get("db");
		$sanitizeM = new Base_Sanitize();
		
		//Truncate or Empty table first
		$db->query("TRUNCATE TABLE lonely_planet_country");
		
		//$directory="data/1615/xml/20110119/";
		$directory="data/1615/xml/20110304/";
		//$directory="data/1615/xml/test/";
		if(!($dp = opendir($directory))) die("Cannot open $directory.");
		
		$countFiles = 1;
		while($filename = readdir($dp))
		{
			$file_path = "";
			if(is_dir($filename))
			{
				continue;
			}
			else if($filename != '.' && $filename != '..')
			{
				$fileExtension	= explode(".", $filename);
				$fileExtension	= strtolower($fileExtension[count($fileExtension)-1]);
				if($fileExtension=="xml")
				{
					$file_path = $directory.$filename;
					
					//open and replace HTMl tags from XML file and rewrite
					$fileContent	= "";
					$fh				= "";
					$fileContent = file_get_contents($file_path);		
					$fileContent = $this->replaceText($fileContent);
					$fh = fopen($file_path, 'w+') or die("can't open file");				
					fwrite($fh, $fileContent);
					fclose($fh);
					
					//now load XML files and parse XMLs
					$data = array();
					
					echo "<br><br>Strart processing file==><b>".$file_path."</b> counter=>".$countFiles;
					$destination = simplexml_load_file($file_path);
					$data["node_id"]=(string)$destination["node_id"];
					$data["destination_name"]=(string)$sanitizeM->clearInputs($destination->destination_name);
					$data["full_destination_name"]=(string)$destination->general->full_destination_name;
					$data["intro_mini"]=(string)$this->replaceText($destination->general->intro_mini, true);
					$data["intro_short"]=(string)$this->replaceText($destination->general->intro_short, true);
					$data["warning_title"]=(string)$destination->general->warning_title;
					$data["warning_text"]=(string)$this->replaceText($destination->general->warning_text, true);
					$data["warning_position"]=(string)$destination->general->warning_position;
					$data["warning_severity"]=(string)$destination->general->warning_severity;
					
					//timezones
					if($destination->general->timezones)
					{
					   $tz = 0;
					   $arrayTimezone = array();
					   foreach($destination->general->timezones->children() as $timezone)
					   {
						   $arrayTimezone[$tz]['gmt_utc']=(string)$timezone->gmt_utc;
						   $tz++;
					   }
					   $data["timezones"]=serialize($arrayTimezone);
					}
							
					$data["weights_measures_system"]=(string)$destination->general->weights_measures_system;
					$data["capital_city"]=(string)$destination->general->capital_city;
					
					//government leaders
					if($destination->government->leaders)
					{
					   $ld = 0;
					   $arrayLeaders = array();
					   foreach($destination->government->leaders->children() as $leader)
					   {
						   $arrayLeaders[$ld]['leader_name']=(string)$leader->leader_name;
						   $arrayLeaders[$ld]['leader_type']=(string)$leader->leader_type;
						   $arrayLeaders[$ld]['leader_title']=(string)$leader->leader_title;
						   $ld++;
					   }
					   $data["leaders"] = serialize($arrayLeaders);
					}
							
					$data["government_type"]=(string)$destination->government->government_type;
					$data["area_sqkm"]=(string)$destination->environment->area_sqkm;
					$data["population"]=(string)$destination->environment->population;
					
					//languages
					$i=0;		
					if($destination->society->language_spokens)
					{
					   $arrayLanguage = array();
					   foreach($destination->society->language_spokens->children() as $language_spoken)
					   {
						   $arrayLanguage[$i]['language_spoken_type']=(string)$language_spoken->language_spoken_type;
						   $arrayLanguage[$i]['language_spoken_name']=(string)$language_spoken->language_spoken_name;
						   if($language_spoken->language_spoken_description)
						   $arrayLanguage[$i]['language_spoken_description']=(string)$this->replaceText($language_spoken->language_spoken_description, true);
						   $i++;
					   }
					   $data["language_spokens"]=serialize($arrayLanguage);
					}
						   
					$data["religion"]=(string)$this->replaceText($destination->society->religion, true);
					$data["currency_code"]=(string)$destination->economy->currency_code;
					$data["currency_name"]=(string)$destination->economy->currency_name;
					$data["currency_symbol"]=(string)$destination->economy->currency_symbol;
					$data["currency_unit"]=(string)$destination->economy->currency_unit;
					//$data["relative_cost_rooms"]=serialize($destination->money->relative_cost_rooms);
                    //$data["relative_cost_meals"]=serialize($destination->money->relative_cost_meals);

					$pre='pre-departure';
					$when_to_go = $destination->$pre->when_to_go;
					$data["when_to_go"]=(string)$this->replaceText($destination->$pre->when_to_go, true);
					$data["visas_overview"]=(string)$this->replaceText($destination->$pre->visas_overview, true);
					
					//electrical plugs
					if($destination->$pre->electrical_plugs)
					{
						$ep = 0;
						$arrayElectricalPlugs = array();
						foreach($destination->$pre->electrical_plugs->children() as $electrical_plugs)
						{
							$arrayElectricalPlugs[$ep]['image_filename'] = (string)$electrical_plugs->image_filename;
							$arrayElectricalPlugs[$ep]['electrical_plug_description'] = (string)$this->replaceText($electrical_plugs->electrical_plug_description, true);
							$ep++;
						}
						$data["electrical_plugs"] = serialize($arrayElectricalPlugs);
					}
					$data["electricity_voltage"]=(string)$destination->$pre->electricity_voltage;
					$data["electricity_hz"]=(string)$destination->$pre->electricity_hz;
					$data["dangers_and_annoyances"]=(string)$this->replaceText($destination->health->dangers_and_annoyances, true);
					
					//health conditions
					if($destination->health->health_conditions)
					{
						$arrHealthCondition = array();
						foreach($destination->health->health_conditions->children() as $healthCondition)
						{
						   $type = "";
						   $type = (string)$healthCondition->health_condition_type;
						   $arrHealthCondition[$type] = (string)$this->replaceText($healthCondition->health_condition_description, true);
						}
						$data["health_conditions"] = serialize($arrHealthCondition);
					}	
					
					$data["weather_overview"]=(string)$this->replaceText($destination->weather->weather_overview, true);
					$data["country_dialling_code"]=(string)$destination->communication->country_dialling_code;
					
					//transports
					if($destination->transport)
					{
					    $arrTransport = array();
						foreach($destination->transport->destination_transport_topics->children() as $transport)
						{
						   $transport_type = "";
						   $transport_type = (string)$transport->transport_type;
						   $arrTransport[$transport_type] = (string)$this->replaceText($transport->transport_description, true);
						}
						$data["transport"] = serialize($arrTransport);
					}				

					$data["history_pre_20c"]=(string)$this->replaceText($destination->culture->history_pre_20c, true);
					$data["history_modern"]=(string)$this->replaceText($destination->culture->history_modern, true);
					$data["history_recent"]=(string)$this->replaceText($destination->culture->history_recent, true);
					//$data["product_info"]=serialize($destination->product_info);
					
					//get images
					if($destination->images)
					{
					    $img = 0;
						$arrayImages = array();
						foreach($destination->images->children() as $image)
						{
							$arrayImages[$img]['image_caption']=(string)$image->image_caption;
							$arrayImages[$img]['image_photographer']=(string)$image->image_photographer;
							$arrayImages[$img]['image_filename'] = (string)$image->image_filename;
							$arrayImages[$img]['image_thumbnail_filename'] = (string)$image->image_thumbnail_filename;
							$img++;
						}
						$data["images"] = serialize($arrayImages);
					}
					
					//get maps
					if($destination->map)
					{
						$arrayMaps = array();
						$arrayMaps['map_name']=(string)$destination->map->map_name;
						$arrayMaps['map_filename']=(string)$destination->map->map_filename;
						$arrayMaps['map_thumbnail_filename'] = (string)$destination->map->map_thumbnail_filename;
						$data["map"] = serialize($arrayMaps);
					}		
				 
					$i=0;
					foreach($destination->pois->children() as $poi)
					{
						$arrayPoi[$i]['poi_name']=(string)$poi->poi_name;
						$address_parts=(array)$poi->address_parts;

						$addressPart=array();
						if(isset($address_parts['address_part']) && count($address_parts['address_part'])>0)
						{
							foreach($address_parts['address_part'] as $address_part)
							{
							   $addressPart[]=(array)$address_part;
							}
							$arrayPoi[$i]['address_parts']   =$addressPart;
						}
						$arrayPoi[$i]['address_postcode']=(string)$poi->address_postcode;
						$arrayPoi[$i]['poi_web']=(string)$poi->poi_web;
						$arrayPoi[$i]['review_summary']=(string)$this->replaceText($poi->review_summary, true);
						$arrayPoi[$i]['review_full']=(string)$this->replaceText($poi->review_full, true);
						$arrayPoi[$i]['keywords']=(array)$poi->keywords;

						$i++;
					}
					$data["pois"]=serialize($arrayPoi);
					
					//attrations
					if($destination->attractions)
					{
						$attr = 0;
						$arrayAttr = array();
						foreach($destination->attractions->children() as $attraction)
						{
							$arrayAttr[$attr]['destination_name']=(string)$attraction->destination_name;
							$arrayAttr[$attr]['full_destination_name']=(string)$attraction->general->full_destination_name;
							$arrayAttr[$attr]['intro_short']=(string)$this->replaceText($attraction->general->intro_short, true);
							$arrayAttr[$attr]['intro_medium']=(string)$this->replaceText($attraction->general->intro_medium, true);
							$attr++;
						}
						$data["attractions"] = serialize($arrayAttr);
					}
					$data["copyright"]=(string)$destination->copyright;
					$data["addedon"]=time();
					
					/*----Country Info----*/
					$countryM		= new Application_Model_Country();
					$countryName	= $sanitizeM->clearInputs($data["destination_name"]);
					
					if(!get_magic_quotes_gpc ())
					$countryName=  addslashes($countryName);

					//$countryName=@mb_convert_encoding($countryName, 'UTssssF8', 'auto');
                    $country=$countryM->fetchRow("name like '{$countryName}'");
					if(false===$country)
					{
						//get country continent
						$continent_id = "";
						$continent_id = $countryM->countryContinent($countryName);
						$countryName = $sanitizeM->clearInputs($data["destination_name"]);
						
						//if doesn't exists
						if(!$this->duplicateCountries($countryName))
						{
							$countryM->setName($countryName);
							$countryM->setContinentId($continent_id);
							$country_id=$countryM->save();
						}	
					}
					else
					{
						$country_id=$country->getId();
					}
					$data['country_id']=$country_id;
					/*---------------*/
					
					//check existing country record in lonely_planet_country table
					$lonelyM		= new Application_Model_LonelyPlanetCountry();
					$lonelyM		= $lonelyM->fetchRow("country_id={$country_id}");
					if(false!==$lonelyM)
					{
						$res = $db->update( "lonely_planet_country", $data, "country_id={$country_id}");
					}
					else
					{
						$res = $db->insert( "lonely_planet_country", $data);
					}
                    echo "<br>END File==><b>".$file_path."</b> has been processed, counter=>".$countFiles;
                    $countFiles++;
				}//end of if
			
			}//end of else if
		}//end of while
		
		closedir($dp);
		
		//rename countries name
		$db->query("UPDATE country SET name='Bosnia and Herzogovina' WHERE name='Bosnia-Hercegovina'");
		$db->query("UPDATE country SET name='Vatican City' WHERE name='Holy See'");
		$db->query("UPDATE country SET name='Ivory Coast' WHERE name='Cote dIvoire'");
		
		//delete countries for which no planet feeds data available
		//$sSQlQuery = "DELETE FROM country WHERE id IN(select t.id FROM (SELECT id FROM `country` WHERE id NOT IN (SELECT country_id FROM lonely_planet_country WHERE country_id IS NOT NULL)) AS t)";
		//$db->query($sSQlQuery);
	}//end of function
	
	//get Country images from lonely_planet_country table and inset in new table
	function countryImagesAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//Truncate or Empty image table first
		$db = Zend_Registry::get("db");		
		$db->query("TRUNCATE TABLE country_images");
		
		//now fetch all images from lonely_planet_country and insert
		$lonelyM = new Application_Model_LonelyPlanetCountry();
		$lonelyM = $lonelyM->fetchAll(NULL, "country_id ASC");
		if(false!==$lonelyM)
		{
			foreach($lonelyM AS $country)
			{
				$countryId = $country->getCountryId();
				$oldImageArr = unserialize($country->getImages());
				for($oCnt=0; $oCnt<count($oldImageArr); $oCnt++)
				{
					$options = array();
					$imgArr = $oldImageArr[$oCnt];
					$options["countryId"] = $countryId;
					$options["countryImage"] = substr($imgArr["image_filename"],8, strlen($imgArr["image_filename"]));
					$options["slideTitle"] = $imgArr["image_caption"];
					$options["altText"] = $imgArr["image_caption"];
					$options["slideLinkUrl"] = "";
					$options["slideLinkTarget"] = "";
					$options["weight"] = $oCnt+1;
					$options["status"] = 1;
					
					//create Country image class object and insert
					$CountryImagesM = new Application_Model_CountryImages($options);
					$res = $CountryImagesM->save();
				}//end for
			}//end foreach
		}//end if
	}//end function
}
