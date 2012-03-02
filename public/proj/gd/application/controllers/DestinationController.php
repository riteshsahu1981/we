<?php
class DestinationController extends Base_Controller_Action
{
    public function preDispatch()
	{
		parent::preDispatch();
		$this->_helper->layout->setLayout('journal-layout-2column');
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 7-Dec-2010
	 * @Description: Travel guides home page content
	 */
	public function indexAction()
	{
		//get destination home page CMS text
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Application_Model_TravelGuidesHome();
		$modelRes	=	$modelRes->find($id);
		if(false!==$modelRes)
		{
			$this->view->title		= $modelRes->getTitle();
			$this->view->subTitle	= $modelRes->getSubTitle();
			$this->view->desription	= $modelRes->getDescription();
		}
		
		//now retrieve travel guide slides
		$homeSlidesArr = array();
		$TravelGuidesSlidesM	=	new Application_Model_TravelGuidesSlides();
		$whereCond				=	"status=1";
		$orderBy				=	"weight DESC";
		$slideLimit				=	10;
		$TravelGuidesSlidesRes	=	$TravelGuidesSlidesM->fetchAll($whereCond, $orderBy);
		if(false!==$TravelGuidesSlidesRes)
		{
			foreach($TravelGuidesSlidesRes as $slides)
			{
				$homeSlidesArr[] = array("title"=>$slides->getSlideTitle(),"type"=>$slides->getSlideType(),"image"=>$slides->getSlideImage(),"text"=>$slides->getSlideText(), "label"=>$slides->getSlideLinkLabel(), "url"=>$slides->getSlideLinkUrl(),"target"=>$slides->getSlideLinkTarget());
			}
			$this->view->cityImagesArr = $homeSlidesArr;
		}
		
		//get top featured city to display in top
		$cityM	=	new Application_Model_City();
		$destinationM	=	new Application_Model_Destination();
		
		//get other featured cities
		$featuredOther 		= array();
		$featuredOtherArr 	= array();
			
		$cityArr	=	array();
		$cityArr	=	$cityM->fetchAll("featured_top!=1 AND featured_other=1", "name ASC");
		
		if(count($cityArr)>0)
		{
			foreach($cityArr AS $row)
			{
				$featuredOther['city_id'] = $row->id;
				$featuredOther['name']	= $row->name;
				
				//get City/place image
				$featuredOther['city_image'] = "no-image.jpg";
				$cityImagesArr = $destinationM->destinationImages($row->id);
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
				$featuredOther['country'] = "";
				if(false!==$countryM)
				{
					$featuredOther['country'] = $countryM->getName();
				}	
				
				$destinationM	=	new Application_Model_Destination();
				$destination	=	$destinationM->fetchRow("location_id='{$row->id}' AND location_type='city'");
					
				$featuredOther['overview'] = "";
				$featuredOther['nutshell'] = "";
				if(false!==$destination)
				{
					$featuredOther['overview'] = $destination->getTitle();
					$featuredOther['nutshell'] = $destination->getIntroduction();
					//$destination_id = $destination->getId();
				}
				$featuredOtherArr[] = $featuredOther;
			}//end of foreach
		}
		$this->view->featuredOtherArr = $featuredOtherArr;
		
		//get featured countries
		$featuredCountry	= array();
		$featuredCountryArr = array();
			
		$countryM	=	new Application_Model_Country();
		$countryArr	=	array();
		$countryArr	=	$countryM->fetchAll("featured=1", "name ASC");
		
		if(count($countryArr)>0)
		{
			foreach($countryArr AS $row)
			{
				$featuredCountry['country_id'] = $row->id;
				$featuredCountry['name']	= $row->name;
				
				//get country image
				$featuredCountry['country_image'] = "no-image.jpg";
				$countryImagesArr = $destinationM->destinationImages($row->id, "country");
				if(false!==$countryImagesArr)
				{
					if(count($countryImagesArr)>0)
					{
						$featuredCountry['country_image'] = $countryImagesArr[0]['country_image'];
					}
				}
				
				//get country information
				$lonelyM	=	new Application_Model_LonelyPlanetCountry();
				$lonelyM	=	$lonelyM->fetchRow("country_id='{$row->id}'");
					
				$featuredCountry['overview'] = "";
				$featuredCountry['nutshell'] = "";
				if(false!==$lonelyM)
				{
					$featuredCountry['overview'] = $lonelyM->getIntroMini();
					$featuredCountry['nutshell'] = $lonelyM->getIntroShort();
				}
				$featuredCountryArr[] = $featuredCountry;
			}//end of foreach
		}
		$this->view->featuredCountryArr = $featuredCountryArr;
	}//end of funcion
	
	public function continentAction()
	{

	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 7-Dec-2010
	 * @Description: Display Country information under Travel guides section
	 */
	public function countryAction()
	{
		$id			=	$this->_getParam('id');
		$countryM	=	new Application_Model_Country();
		$country	=	$countryM->find($id);
		$this->view->country_id = $id; //get in block
		$this->view->invalidCountry="0";
                
		if(false===$country)
		{
			$this->view->invalidCountry="1";
		}
		else
		{
			$this->view->countyName = $countryName = $country->getName();
			
			//set City Google map address
			$searchAddress	= $countryName;
			$latitude	= "-34.397";
			$longitude	= "150.644";
			//if Lat/Lon coordinates available
			if($country->getLatitude()!="" && $country->getLongitude()!="")
			{
				$latitude	= $country->getLatitude();
				$longitude	= $country->getLongitude();
				$searchAddress = "(".$latitude.", ".$longitude.")";
			}
			$this->view->latitude	= $latitude;
			$this->view->longitude	= $longitude;
			$this->view->searchAddress	= $searchAddress;
			
			$db		= Zend_Registry::get("db");
			$sSQL = "SELECT * FROM lonely_planet_country WHERE country_id='{$id}'";
			
			$row	= $db->fetchRow($sSQL);
			if(!empty($row))
			{
				$this->view->countryInfo = $row;

				//get information from destination table
				$destinationM	=	new Application_Model_Destination();
				$destination	=	$destinationM->fetchRow("location_id='{$id}' AND location_type='country'");
				if(false!==$destination)
				{
                    $bank_breaker = unserialize($destination->getBankBreaker());
                    $this->view->bank_breaker = $bank_breaker;
					$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout();
					$this->view->dontLeaveWithout = $dontLeaveWithoutM->fetchAll("destination_id='{$destination->getId()}'", "id ASC");
				}
				
				//get country images
				$countryImagesArr = $destinationM->destinationImages($id, "country");
				if(false!==$countryImagesArr)
				{
					if(count($countryImagesArr)>0)
					{
						$this->view->countryImagesArr = $countryImagesArr;
					}
				}
			}
			else
			{
				$this->view->invalidCountry="2";
			}
		}
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 6-Dec-2010
	 * @Description: Get City/Place information and display city content
	 */
	public function cityAction()
	{
		$id		=	$this->_getParam('id');
		$cityM	=	new Application_Model_City();
		$city	=	$cityM->find($id);
		
		$this->view->invalidCity="0";
		if(false===$city)
		{
			$this->view->invalidCity="1";
		}
		else
		{
			//set City and Country name to view
			$this->view->cityName = $cityName = $city->getName();
			$this->view->country_id = $city->getCountryId();			
		
			//now get country in which this city exists
			$countryM	=	new Application_Model_Country();
			$country_id = 	$city->getCountryId();
			$countryM	=	$countryM->find($country_id);
			$this->view->countyName = $countryName = $countryM->getName();			
			
			//set City Google map address
			$searchAddress	= $cityName." ,".$countryName;
			$latitude	= "-34.397";
			$longitude	= "150.644";
			//if Lat/Lon coordinates available
			if($city->getLatitude()!="" && $city->getLongitude()!="")
			{
				$latitude	= $city->getLatitude();
				$longitude	= $city->getLongitude();
				$searchAddress = "(".$latitude.", ".$longitude.")";
			}
			$this->view->searchAddress	= $searchAddress;
			$this->view->latitude	= $latitude;
			$this->view->longitude	= $longitude;
			
			$destinationM	=	new Application_Model_Destination();
			$destination	=	$destinationM->fetchRow("location_id='{$id}' AND location_type='city'");
				
			if(false!==$destination)
			{
				$this->view->overview = $destination->getTitle();
				$this->view->nutshell = $destination->getIntroduction();
				
				$destination_id = $destination->getId();
				
				//Get Eat sleep Drink information of city
				$eatSleepDrink = $destinationM->destinationEatSleepDrink($destination_id);
				if(false!==$eatSleepDrink)
				{
					if(count($eatSleepDrink)>0)
					{
						$this->view->eatSleepDrink = $eatSleepDrink;
					}
				}
				
				//Get Expriences of city
				$exprienceArr = $destinationM->destinationExprience($destination_id);
				if(false!==$exprienceArr)
				{
					if(count($exprienceArr)>0)
					{
						$this->view->exprience = $exprienceArr;
					}
				}
				
				//Get Practicalities of city
				$practicalArr = $destinationM->destinationPractical($destination_id);
				if(false!==$practicalArr)
				{
					if(count($practicalArr)>0)
					{
						$this->view->practical = $practicalArr;
					}
				}
				
				//get city/place images
				$cityImagesArr = $destinationM->destinationImages($id, "city");
				if(false!==$cityImagesArr)
				{
					if(count($cityImagesArr)>0)
					{
						$this->view->cityImagesArr = $cityImagesArr;
					}
				}
			}
			
			//select country information to display in other tabs
			if(false===$countryM)
			{
				$this->view->countryInfo="no_data";
			}
			else
			{
				$db		= Zend_Registry::get("db");
				$sSQL = "SELECT * FROM lonely_planet_country WHERE country_id='{$country_id}'";
				
				$row	= $db->fetchRow($sSQL);
				if(!empty($row))
				{
					$this->view->countryInfo = $row;

					//$destinationM	=	new Application_Model_Destination();
					$destination	=	$destinationM->fetchRow("location_id='{$country_id}' AND location_type='country'");
					
					if(false!==$destination)
					{
						$bank_breaker = unserialize($destination->getBankBreaker());
						$this->view->bank_breaker = $bank_breaker;
						
						$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout();
						$this->view->dontLeaveWithout = $dontLeaveWithoutM->fetchAll("destination_id='{$destination->getId()}' ");
					}
				}
				else
				{
					$this->view->countryInfo="no_data";
				}
			}	
		}//end of else
	}//end of function
	
	public function placeAction()
	{

	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 1-Dec-2010
	 * @Description: Send recommendation email to admin and save data into database table
	 */
	public function sendpoiAction()
	{
		die("This functionality is not available for the moment");
		exit;
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$userNs = new Zend_Session_Namespace('members');
		$user_id = $userNs->userId;
		
		if(strtolower($this->_getParam('poi_captcha'))!= $_SESSION['securimage_code_value'])
		{
			$response = "<span style='color:#ff0000;'>Entered spam protection code is not valid.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}		
		
		//save poi recommendation
		$poiR = new Application_Model_PoiRecommendation();
		$poiR->setName($this->_getParam('poi_name'));
		$poiR->setEmail($this->_getParam('poi_email'));
		$poiR->setRecommendation($this->_getParam('poi_comments'));
		$poiR->setCountryId($this->_getParam('country_id'));
		$poiR->setUserId($user_id);
		$poiR->setStatus(1);
		
		$id = $poiR->save();
		
		//send email and display response
		if($id>0)
		{
			//send email to admin
			$settings	= new Admin_Model_GlobalSettings();
			$admin_email= $settings->settingValue('admin_email');
			//$admin_email = "mahipal@profitbyoutsourcing.com";
			
			//set sender information
			$mailOptions['sender_name']	= ucwords($this->_getParam('poi_name'));
			$mailOptions['sender_email']= $this->_getParam('poi_email');
			$mailOptions['sender_comments']= $this->_getParam('poi_comments');
			
			//set receiver information
			$mailOptions['receiver_email']	= $admin_email;
			//$mailOptions['receiver_name']	= "Administrator";
			
			//create mail class object and send the email
			$Mail	=	new Base_Mail();
			$Mail->sendPoiRecommendation($mailOptions);
				
			//set confirmation message to display
			$response = "<span style='color:#ff0000;'>Your recommendation has been sent to the Gap Daemon Team for review.</span>";
			$JsonResultArray = Array('error'=>0, 'response'=>$response);
		}
		else
		{
			$response = "<span style='color:#ff0000;'>Error occured, Please try again later.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
		}
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end of function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 2-Dec-2010
	 * @Description: Search destinations
	 */
	public function searchAction()
    {
		$params['search'] = $this->_getParam('search');
            
		if (isset($params['search']) && $params['search']<>"" && $params['search']<>"Search by Keyword")
		{
			$this->view->search	=	$search = $params['search'];
			$settings           =	new Admin_Model_GlobalSettings();
			$page_size          =	$settings->settingValue('pagination_size');
			//$page_size		= 	1;
			
			$modelList          =   new Application_Model_SearchView();
			
			$searchData         =   $modelList->searchDestination($search);
			$page               =   $this->_getParam('page',1);
			$pageObj            =   new Base_Paginator();
			$paginator          =   $pageObj->fetchPageDataResult($searchData,$page,$page_size);
			if($pageObj->getTotalCount()>0)
			{
				$this->view->total         =   $pageObj->getTotalCount();
				$this->view->paginator     =   $paginator;
			}
			else
			{
				$this->view->message = "No result found for this keyword.";
			}
		}
		else
		{
			$this->view->message = "Missing search parameters.";
		}
    }//end function	
}
