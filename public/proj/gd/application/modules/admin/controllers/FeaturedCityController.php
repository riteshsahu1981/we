<?php
class Admin_FeaturedCityController extends Base_Controller_Action
{
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Dec-2010
	 * @Description	: Manage featured plasec/cities
	 */
	public function indexAction() 
	{
		$this->view->title="Manage Featured Places";
        $this->view->headTitle(" - ".$this->view->title);
		
		$this->view->msg=base64_decode($this->_getParam('msg',''));
		$form = new Admin_Form_Featuredcity();
		
		//clear form element decorators
		$elements=$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('class');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->form = $form;		
		
		//get featured Cities
		$cityM	=	new Application_Model_City();
		$cityArr=	$cityM->fetchAll("featured_top=1 OR featured_other=1");
		
		//get existing records to populate filled/selected in form
		$featuredOther = array();
		foreach($cityArr AS $row)
		{
			if($row->featuredTop==1)
			{
				//$options['featured_top']	=	$row->id;
			}
			else
			{
				$featuredOther[$row->id] = $row->id;
			}
		}
		//$form->getElement('featured_other')->setMultiOptions($featuredOther);
		$options['featured_other']	=	$featuredOther;	
		
		//get existing featured countries
		$countryM	=	new Application_Model_Country();
		$countryArr	=	$countryM->fetchAll("featured=1");
		$featuredCountry = array();
		foreach($countryArr AS $country)
		{
			$featuredCountry[$country->id] = $country->id;
		}
		$options['featured_country']	=	$featuredCountry;	
		
		$form->populate($options);
		
		
		if ($this->getRequest()->isPost()) 
        {
            $formData = $this->getRequest()->getPost();          
            if ($form->isValid($formData)) 
            {
            	//re-set all values of featured_top and featured_other fileds in city table
				$resetFeaturedCity		= $cityM->resetUpdateFeatured();
				$resetFeaturedCountry	= $countryM->resetUpdateFeatured();
				
				if($resetFeaturedCity && $resetFeaturedCountry)
				{
					//update top featued city
					//$cityM->setUpdateFeaturedTop($formData['featured_top']);
					
					//update other featured cities
					$cityM->setUpdateFeaturedOther($formData['featured_other']);
					
					//update featured countries
					$countryM->setUpdateFeatured($formData['featured_country']);
					
					//set update message and redirect user
					$this->_redirect("/admin/featured-city/index/msg/".base64_encode("Featured places information has been updated."));
				}
            }
			else
			{
                $form->populate($formData);
            }
        }
	}//end function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Edit Travel Guides Home page Content CMS
	 */
	public function travelguidesHomeAction()
	{
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Application_Model_TravelGuidesHome();
		$modelRes	=	$modelRes->find($id);

		$options = array(
						'title'				=> $modelRes->getTitle(),
						'subTitle'			=> $modelRes->getSubTitle(),
						'description'		=> $modelRes->getDescription(),
						'metaTitle'			=> $modelRes->getMetaTitle(),
						'metaKeyword'		=> $modelRes->getMetaKeyword(),
						'metaDescription'	=> $modelRes->getMetaDescription(),
						'status'			=> $modelRes->getStatus(),
						'userId'			=> $modelRes->getUserId()
						);

		$form    = new Admin_Form_TravelGuidesHome();
		$form->populate($options);
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				$modelRes->setOptions($options);
				$updateRes = $modelRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg']	=	"Content has been updated successfully.";
					$this->_helper->redirector('travelguides-home','featured-city','admin',array('id'=>$id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}
			}//end if
			else
			{
				$form->reset();
				$form->populate($options);
			} 		
		}//end if
		
		//set form
		$this->view->form=$form;
		
		//set message
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Manage Travel Guides Home page image slides
	 */
	public function travelguidesSlidesAction()
	{
		$settings	= new Admin_Model_GlobalSettings();
		$page_size	= $settings->settingValue('pagination_size');
		
		$model		=	new Application_Model_TravelGuidesSlides();
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model,$page,$page_size,NULL,"weight DESC");
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->paginator	=	$paginator;
		
		$this->view->errorMsg	=	"";
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Travel Guides Home page: add image slides
	 */
	public function travelguidesAddslideAction()
	{
		$request = $this->getRequest();
		$form = new Admin_Form_TravelGuidesSlide();
		
		//set default options
		$form->getElement('slideType')->setValue("image");
		$form->getElement('slideLinkTarget')->setValue("_blank");
		$form->getElement('weight')->setValue("1");	
		$form->getElement('status')->setValue("1");
		
		//$form->getElement('weight')->addValidator('regex', true, array('/^[a-z]/i')); 
		//$form->getElement('weight')->getValidator('regex')->setMessage("Your weight must begin with a letter.");
		 
		//$form->getElement('slideImage')->setAttrib("required",true);
		
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
			
		//submit form
		if ($this->getRequest ()->isPost ()) 
		{
			$options = $request->getPost();                 
                       
			if ($form->isValid ($options ))
			{
				$target_file_name = "";
				//Upload image strat here
				$upload = new Zend_File_Transfer_Adapter_Http();
				
                if($upload->isValid())
				{
                    $upload->setDestination("media/picture/home/");
                    try
					{
                        $upload->receive();
                    }
                    catch (Zend_File_Transfer_Exception $e)
					{
                        $msg = $e->getMessage();
                    }

                    $upload->setOptions(array('useByteString' => false));
                    $file_name = $upload->getFileName('slideImage');
                    $cardImageTypeArr = explode(".", $file_name);

                    $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

                    $target_file_name = "travel_".time().".{$ext}";

                    $targetPath = "media/picture/home/".$target_file_name;
                    $targetPathThumb = "media/picture/home/thumb_".$target_file_name;

                    $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

                    $filterFileRename -> filter($file_name);

                    $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
                    $thumb->resize(623, 347);
                    $thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$params['userId'] = $usersNs->userId;
				
				//set image
				$params['slideImage']	=	$target_file_name;
				
				$model	= new Application_Model_TravelGuidesSlides($params);
				$id		= $model->save();                     
				if($id)
				{
					$_SESSION['errorMsg'] = "Slide has been added successfully.";
					$this->_helper->redirector('travelguides-addslide','featured-city','admin',array('id'=>$page_id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}				
			}//end if
		}//end if		
		$this->view->form = $form;		
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Travel Guides Home page: edit image slides
	 */
	public function travelguidesEditslideAction()
	{
		$id		=	$this->_getParam('id');
		$widgetRes	=	new Application_Model_TravelGuidesSlides();
		$widgetRes	=	$widgetRes->find($id);

		$options = array(
						'slideTitle'	=> $widgetRes->getSlideTitle(),
						'slideType'		=> $widgetRes->getSlideType(),
						'slideImage'	=> $widgetRes->getSlideImage(),
						'slideText'		=> $widgetRes->getSlideText(),
						'slideLinkLabel'=> $widgetRes->getSlideLinkLabel(),
						'slideLinkUrl'	=> $widgetRes->getSlideLinkUrl(),
						'slideLinkTarget'=> $widgetRes->getSlideLinkTarget(),
						'weight'		=> $widgetRes->getWeight(),
						'status'		=> $widgetRes->getStatus()
						);

		$form    = new Admin_Form_TravelGuidesSlide();
		$this->view->slideImage = $widgetRes->getSlideImage();
		$form->populate($options);
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set previous image name if not uploaded new one
				$target_file_name =	$widgetRes->getSlideImage();

				// Image Upload START
				$upload = new Zend_File_Transfer_Adapter_Http();

				if($upload->isValid())
				{
					$upload->setDestination("media/picture/home/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}
					//unlink previous uploaded image files
					unlink("media/picture/home/".$widgetRes->getSlideImage());
					unlink("media/picture/home/thumb_".$widgetRes->getSlideImage());

					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('slideImage');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "travel_".time().".{$ext}";

					$targetPath			= "media/picture/home/".$target_file_name;
					$targetPathThumb	= "media/picture/home/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(623, 347);
					$thumb->save($targetPathThumb);
				}
				//Image Upload END
				
				//set image
				$options['slideImage'] =	$target_file_name;
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				
				$widgetRes->setOptions($options);
				$updateRes = $widgetRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg'] = "Slide has been updated successfully.";
					$this->_helper->redirector('travelguides-slides','featured-city','admin',array('id'=>$id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}
			}//end if
			else
			{
				$form->reset();
				$form->populate($options);
			} 		
		}//end if
		$this->view->form=$form;
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Travel Guides Home page: update image slides status
	 */
	public function statusSlideAction()
	{	
		$id		= 	$this->_getParam('id');
		$model	=	new Application_Model_TravelGuidesSlides();
		
		$widgetRes	=	$model->find($id);
		
		if($widgetRes->getStatus()==1)
		{
			$widgetRes->setStatus(0);
			$statusMsg = "Unpublished";			
		}
		else
		{
			$widgetRes->setStatus(1);
			$statusMsg = "Published";
		}
		$saveRes = $widgetRes->save();
		if($saveRes)
		{
			$_SESSION['errorMsg'] = "Slide has been {$statusMsg} successfully.";
		}
		else
		{
			$_SESSION['errorMsg'] = "Error occured while updating status.";
		}
		return $this->_helper->redirector('travelguides-slides','featured-city',"admin");	
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Travel Guides Home page: delete image slide
	 */
	public function deleteSlideAction()
	{
		$id		=	$this->_getParam('id');		
		$model	=	new Application_Model_TravelGuidesSlides();
		$widgetRes	=	$model->find($id);
		if($widgetRes)
		{
			$model->delete("id={$id}");
			
			//unlink image if files exists
			if(file_exists("media/picture/home/".$widgetRes->getSlideImage()))
			{
				unlink("media/picture/home/".$widgetRes->getSlideImage());
				unlink("media/picture/home/thumb_".$widgetRes->getSlideImage());
			}	
			$_SESSION['errorMsg']	=	"Slide has been deleted!";
		}
		else
		{
			$_SESSION['errorMsg']	=	"Invalid request, no slide found.";
		}
		return $this->_helper->redirector('travelguides-slides','featured-city',"admin");
	}
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Feb-2011
	 * @Description	: Manage destination City/Places
	 */
	public function manageCityAction()
	{
		$where		=	"id IS NOT NULL";
		$order		=	"name ASC";
		
		//create search form
		$form    = new Admin_Form_SearchCity();
		$elements=$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->form = $form;
		$param = $this->_getParam('submit');
		
		if(isset($param) && $param=="Search")
		{
			$linkArray=array();
			if($this->getRequest()->isPost())
			{
				$params=$this->getRequest()->getPost();
			}
			else
			{
				$params=$this->getRequest()->getParams();	
			}
			
			foreach($params as $k => $v)
			{
				if($k<>"page" && $k<>"module" && $k<>"controller" && $k<>"action" && $v<>"")
				{
					$linkArray[$k]=$v;
				}
			}
			$this->view->linkArray=$linkArray;
                       
			$name 		= $this->_getParam('name');
			$country_id	= $this->_getParam('country_id');
						
			//search by name
			if($name!="")
			{
				$where	.=	" AND name LIKE '%{$name}%'";
			}
			//search by country
			if($country_id!="")
			{
				$where .= " AND country_id={$country_id}";
			}
			
			$options = array("name"=>$name,"country_id"=>$country_id);
			$form->populate($options);
		}
		$model		=	new Application_Model_City();
		$page_size	=	$this->_getParam('page_size',25);
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();		
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->paginator	=	$paginator;
		$this->view->msg		=	base64_decode($this->_getParam('msg',''));
		$this->view->page_size	=	$page_size;
	}//end functon
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 7-Mar-2011
	 * @Description	: Manage destination City/Places: Edit city content
	 */
	public function editCityAction()
	{
		//get request variables and set to view
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-1");
		$this->view->id = $id;
		$this->view->page = $page;
		$this->view->selTab	= $selTab;
		
		//set error message
		$this->view->errorMsg	=	"";			
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		
		//select Destinations details
		$destinationId = "";
		$destinationM	=	new Application_Model_Destination();
		$destinationM	=	$destinationM->fetchRow("location_id={$id} AND location_type='city'");
		if(false!==$destinationM)
		{
			$this->view->destination = $destinationM;
			
			$destinationId = $destinationM->getId();
			
			//select Experiences details
			$expriencesM	=	new Application_Model_Experiences();
			$expriencesM	=	$expriencesM->fetchAll("destination_id={$destinationId}", "id ASC");
			if(false!==$expriencesM)
			{
				$this->view->expriences = $expriencesM;
			}
			
			//select EAT, SLEEP, DRINK AND BE MERRY section details
			$eatsleepdrinkM	=	new Application_Model_EatSleepDrink();
			$eatsleepdrinkM	=	$eatsleepdrinkM->fetchAll("destination_id={$destinationId}");
			if(false!==$eatsleepdrinkM)
			{
				$this->view->eatsleepdrink = $eatsleepdrinkM;
			}
			
			//select Practicalities details
			$practicalitiesM	=	new Application_Model_Practicalities();
			$practicalitiesM	=	$practicalitiesM->fetchAll("destination_id={$destinationId}", "id ASC");
			if(false!==$practicalitiesM)
			{
				$this->view->practicalities = $practicalitiesM;
			}
			
			//select City/Places images
			$cityimagesM	=	new Application_Model_CityImages();
			$cityimagesM	=	$cityimagesM->fetchAll("city_id={$id}", "weight ASC");
			if(false!==$cityimagesM)
			{
				$this->view->cityimages = $cityimagesM;
			}
			//create image upload form
			$uploadForm	= new Admin_Form_CityImages();
			$elements	= $uploadForm->getElements();
			$uploadForm->clearDecorators();
			foreach($elements as $element)
			{
				$element->removeDecorator('label');
				$element->removeDecorator('td');
				$element->removeDecorator('tr');
				$element->removeDecorator('row');
				$element->removeDecorator('HtmlTag');
				$element->removeDecorator('placement');
				$element->removeDecorator('data');
			}
			$this->view->uploadForm = $uploadForm;
		}//end if
		else
		{
			//if not data found, then insert blank empty rows and redirect to this
			//echo "No data provided from XML Feeds.";exit;
			$destinationM	=	new Application_Model_Destination();
			$destination_id =	$destinationM->setDefaultRowData($id, "city");
			$destinationM->setDefaultCityData($destination_id);
			$this->_helper->redirector("edit-city","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-1"));
		}
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{
			$options = $request->getPost();
			
			if($options["update_action"]=="destination")
			{
				$response = "";
				$destinationM	=	new Application_Model_Destination();
				$destinationRes = $destinationM->find($options["destination_id"]);
				if(false!==$destinationRes)
				{
					$destinationRes->setTitle($options["title"]);
					$destinationRes->setIntroduction($options["introduction"]);
					$destinationRes->save();
					
					//update block XML Feeds table
					$destM	=	new Application_Model_Destination();
					$destM->updateXMLFeedsBlockStatus("city", $id, $options["block_ovewrite"]);
				
					//$arrayResult = Array("error"=>0, "response"=>"Introduction information has been updated successfully.");
					$response = "Introduction information has been updated successfully.";
				}
				else
				{
					//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
					$response = "Error occured, no data found.";
				}
				$_SESSION['errorMsg'] = $response;
				$this->_helper->redirector("edit-city","featured-city","admin",array("id"=>$id,"tab"=>"tabs-1"));	
			}
			else if($options["update_action"]=="eat")
			{
				for($eat=0; $eat<count($options["eatId"]); $eat++)
				{
					$eatsleepdrinkM	  = new Application_Model_EatSleepDrink();
					$eatsleepdrinkRes = $eatsleepdrinkM->find($options["eatId"][$eat]);
					if(false!==$eatsleepdrinkRes)
					{
						$eatsleepdrinkRes->setTitle($options["eatTitle"][$eat]);
						$eatsleepdrinkRes->setBackPackerCopy($options["backPackerCopy"][$eat]);
						$eatsleepdrinkRes->setLocalCopy($options["localCopy"][$eat]);
						$eatsleepdrinkRes->save();
					}
					else
					{
						$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
					}
				}
				$arrayResult = Array("error"=>0, "response"=>"Eat, Sleep, Drink and be Merry information has been updated successfully.");
			}
			else if($options["update_action"]=="exp")
			{
				//remove all existing records
				$expriencesM	=	new Application_Model_Experiences();
				$delRes			=	$expriencesM->delete("destination_id = {$options['destinationId']}");
				for($exp=0; $exp<count($options["expTitle"]); $exp++)
				{
					$dataParams["destinationId"] = $options["destinationId"];
					$dataParams["title"] = $options["expTitle"][$exp];
					$dataParams["copy"] = $options["expCopy"][$exp];
					$expriencesM	=	new Application_Model_Experiences($dataParams);
					$expriencesM->save();
					/*
					$expriencesM	=	new Application_Model_Experiences();
					$expriencesRes	= $expriencesM->find($options["expId"][$exp]);
					if(false!==$expriencesRes)
					{
						$expriencesRes->setTitle($options["expTitle"][$exp]);
						$expriencesRes->setCopy($options["expCopy"][$exp]);
						$expriencesRes->save();
					}
					else
					{
						$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
					}*/
				}
				$arrayResult = Array("error"=>0, "response"=>"Experiences information has been updated successfully.");
			}
			else if($options["update_action"]=="prac")
			{
				//remove all existing record
				$practicalitiesM	=	new Application_Model_Practicalities();
				$delres = $practicalitiesM->delete("destination_id = {$options['destinationId']}");
				for($prac=0; $prac<count($options["pracTitle"]); $prac++)
				{
					$dataParams["destinationId"] = $options["destinationId"];
					$dataParams["title"] = $options["pracTitle"][$prac];
					$dataParams["copy"] = $options["pracCopy"][$prac];
					$practicalitiesM	=	new Application_Model_Practicalities($dataParams);
					$practicalitiesM->save();
					
					/*$practicalitiesM	=	new Application_Model_Practicalities();
					$practicalitiesRes	=	$practicalitiesM->find($options["pracId"][$prac]);
					if(false!==$practicalitiesRes)
					{
						$practicalitiesRes->setTitle($options["pracTitle"][$prac]);
						$practicalitiesRes->setCopy($options["pracCopy"][$prac]);
						$practicalitiesRes->save();
					}
					else
					{
						$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
					}*/
				}
				$arrayResult = Array("error"=>0, "response"=>"Practicalities information has been updated successfully.");
			}
			else if($options["update_action"]=="img")
			{
				//print_r($options);exit;
				if ($uploadForm->isValid ($options ))
				{
					$city_id = $options["cityId"];
					
					$target_file_name = "";
					//Upload image strat here
					$upload = new Zend_File_Transfer_Adapter_Http();
					
					if($upload->isValid())
					{
						$upload->setDestination("media/picture/city/");
						try
						{
							$upload->receive();
						}
						catch (Zend_File_Transfer_Exception $e)
						{
							$msg = $e->getMessage();
						}

						$upload->setOptions(array('useByteString' => false));
						$file_name = $upload->getFileName('cityImage');
						$cardImageTypeArr = explode(".", $file_name);

						$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

						$target_file_name = "city{$city_id}_".time().".{$ext}";

						$targetPath = "media/picture/city/".$target_file_name;
						//$targetPathThumb = "media/picture/home/thumb_".$target_file_name;

						$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
						$filterFileRename -> filter($file_name);

						//$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
						//$thumb->resize(623, 347);
						//$thumb->save($targetPathThumb);
					 }
					//upload image Ends here
					
					//set image
					$options['cityImage']	=	$target_file_name;
					$options['status']		=	1;
					
					$model	= new Application_Model_CityImages($options);
					$id		= $model->save();                     
					if($id)
					{
						$_SESSION['errorMsg'] = "Images has been saved successfully.";
					}
					else
					{
						$_SESSION['errorMsg'] =	"Error occured, please try again later.";
					}
					$this->_helper->redirector("edit-city","featured-city","admin",array("id"=>$city_id,"tab"=>"tabs-5"));
				}//end if
				$this->view->selTab	= "tabs-5";
			}
			
			//disable layout and display JSON response if action is not uploading image
			if($options["update_action"]!="img")
			{
				$this->_helper->layout->disableLayout();	
				$this->_helper->viewRenderer->setNoRender(true);
				
				echo Zend_Json::encode($arrayResult);
				exit;
			}		
		}//end if
	}//end function
	
	//Delete city images and return JSON response
	public function deleteCityImageAction()
	{
		//disable layout and helper
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get request
		$id = "";
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$id	=	$options["image_id"];
		}	
		$model	=	new Application_Model_CityImages();
		$res	=	$model->find($id);
		if(false!==$res)
		{
			$model->delete("id={$id}");
			
			//unlink image if files exists
			if(file_exists("media/picture/city/".$res->getCityImage()))
			{
				unlink("media/picture/city/".$res->getCityImage());
			}	
			$arrayResult = Array("error"=>0, "response"=>"Image has been deleted.");
		}
		else
		{
			$arrayResult = Array("error"=>1, "response"=>"Invalid request, no image found.");
		}
		echo Zend_Json::encode($arrayResult);
		exit;
	}//end function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 10-Mar-2011
	 * @Description	: Display listing of countries with paging and searching functionality
	 */
	public function manageCountryAction()
	{
		$where		=	"id IS NOT NULL";
		$order		=	"name ASC";
		
		//create search form
		$form    = new Admin_Form_SearchCountry();
		$elements=$form->getElements();
		$form->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->form = $form;
		$param = $this->_getParam('submit');
		
		if(isset($param) && $param=="Search")
		{
			$linkArray=array();
			if($this->getRequest()->isPost())
			{
				$params=$this->getRequest()->getPost();
			}
			else
			{
				$params=$this->getRequest()->getParams();	
			}
			
			foreach($params as $k => $v)
			{
				if($k<>"page" && $k<>"module" && $k<>"controller" && $k<>"action" && $v<>"")
				{
					$linkArray[$k]=$v;
				}
			}
			$this->view->linkArray=$linkArray;
                       
			$name 			= $this->_getParam('name');
			$continent_id	= $this->_getParam('continent_id');
						
			//search by name
			if($name!="")
			{
				$country = ucfirst($name);
				$where	.=	" AND name LIKE '%{$country}%'";
			}
			//search by continent
			if($continent_id!="")
			{
				$where .= " AND continent_id={$continent_id}";
			}
			
			$options = array("name"=>$name,"continent_id"=>$continent_id);
			$form->populate($options);
		}
		$model		=	new Application_Model_Country();
		$page_size	=	$this->_getParam('page_size',25);
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();		
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
		$this->view->total		=	$pageObj->getTotalCount(); 
		$this->view->paginator	=	$paginator;
		$this->view->msg		=	base64_decode($this->_getParam('msg',''));
		$this->view->page_size	=	$page_size;
	}//end functon
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 10-Mar-2011
	 * @Description	: Edit country CMS content
	 */
	public function editCountryAction()
	{
		//get request variables and set to view
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-1");
		$this->view->id = $id;
		$this->view->page = $page;
		$this->view->selTab	= $selTab;
		
		//set error message
		$this->view->errorMsg	=	"";			
		if(isset($_SESSION['errorMsg']))
		{
			$this->view->errorMsg	=	$_SESSION['errorMsg'];
			unset($_SESSION['errorMsg']);
		}
		
		//select details from lonely_planet_country table
		$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
		$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->fetchRow("country_id={$id}");
			
		if(false!==$lonelyPlanetCountryM)
		{
			/*
			$this->view->lonelyPlanetCountry = $lonelyPlanetCountryM;
			//select Destinations details
			$destinationId = "";
			$destinationM	=	new Application_Model_Destination();
			$destinationM	=	$destinationM->fetchRow("location_id={$id} AND location_type='country'");
			if(false!==$destinationM)
			{		
				$this->view->destination = $destinationM;			
				$destinationId = $destinationM->getId();				
			
				//select Dont Leave Here Without details
				$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout();
				$dontLeaveWithoutM	=	$dontLeaveWithoutM->fetchAll("destination_id={$destinationId}");
				if(false!==$dontLeaveWithoutM)
				{
					$this->view->dontLeaveWithout = $dontLeaveWithoutM;
				}
			}*/
			
			//select Country images
			$countryimagesM	=	new Application_Model_CountryImages();
			$countryimagesM	=	$countryimagesM->fetchAll("country_id={$id}", "weight ASC");
			if(false!==$countryimagesM)
			{
				$this->view->countryimages = $countryimagesM;
			}
						
			//create image upload form
			$uploadForm	= new Admin_Form_CountryImages();
			$elements	= $uploadForm->getElements();
			$uploadForm->clearDecorators();
			foreach($elements as $element)
			{
				$element->removeDecorator('label');
				$element->removeDecorator('td');
				$element->removeDecorator('tr');
				$element->removeDecorator('row');
				$element->removeDecorator('HtmlTag');
				$element->removeDecorator('placement');
				$element->removeDecorator('data');
			}
			$this->view->uploadForm = $uploadForm;			
		}//end if
		else
		{
			//echo "No data found for this country.";exit;
			$this->_helper->redirector("add-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-1"));
		}
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();			
			//upload image
			if ($uploadForm->isValid ($options ))
			{
				$country_id = $options["lonelyPlanetCountryId"];
				$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
				$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($country_id);
				if(false!==$lonelyPlanetCountryM)
				{			
					$target_file_name = "";
					//Upload image strat here
					$upload = new Zend_File_Transfer_Adapter_Http();
				
					if($upload->isValid())
					{
						$upload->setDestination("media/picture/country/");
						try
						{
							$upload->receive();
						}
						catch (Zend_File_Transfer_Exception $e)
						{
							$msg = $e->getMessage();
						}

						$upload->setOptions(array('useByteString' => false));
						$file_name = $upload->getFileName('countryImage');
						$cardImageTypeArr = explode(".", $file_name);

						$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

						$target_file_name = "country{$country_id}_".time().".{$ext}";

						$targetPath = "media/picture/country/images/".$target_file_name;
						$targetPathThumb = "media/picture/country/images/thumbs/".$target_file_name;
						
						$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
						$filterFileRename -> filter($file_name);
						
						$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
						$thumb->resize(625, 330);
						$thumb->save($targetPathThumb);
					}//end if
					//upload image Ends here
				
					//set country Image array
					$addImageArr = array();
					$addImageArr["image_caption"] = $options["slideTitle"];
					$addImageArr["image_photographer"] = "Gap Daemon";
					$addImageArr["image_filename"] = "/images/".$target_file_name;
					$addImageArr["image_thumbnail_filename"] = "/images/thumbs/".$target_file_name;
					
					$oldImageArr = unserialize($lonelyPlanetCountryM->getImages());
					$oldImageArr[count($oldImageArr)] = $addImageArr;
					$newCountryImageArr = serialize($oldImageArr);
					$lonelyPlanetCountryM->setImages($newCountryImageArr);
					$resImg = $lonelyPlanetCountryM->save();
										
					if($resImg)
					{
						$_SESSION['errorMsg'] = "Images has been saved successfully.";
					}
					else
					{
						$_SESSION['errorMsg'] =	"Error occured, please try again later.";
					}
					$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id,"tab"=>"tabs-7"));
				}//end if
			}//end if
			$this->view->selTab	= "tabs-7";
		}//end if
	}//end function
	
	
	//update overview
	public function updateCountryTab1DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$request = $this->getRequest();
		
		if ($request->isPost())
		{
			$options = $request->getPost();
			//print_r($options);exit;
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($options["id"]);
			if(false!==$lonelyPlanetCountryM)
			{
				$response = "";
				//echo "short=>".$options["introShort"];
				$lonelyPlanetCountryM->setIntroShort($options["introShort"]);
				$res1= $lonelyPlanetCountryM->save();
				if($res1)
				{
					$response .= "In A Nutshell has been updated successfully.";
				}
				else
				{
					$response .= "Can not update In A Nutshell details. Error=>".$res1;
					//$arrayResult = Array("error"=>1, "response"=>"Error occured while updating introduction information.");
				}
				//update block XML Feeds table
				$destM	=	new Application_Model_Destination();
				$destM->updateXMLFeedsBlockStatus("country", $options["countryId"], $options["block_ovewrite"]);
				
				if(isset($options["destinationId"]) && $options["destinationId"]!="")
				{
					$destinationM	=	new Application_Model_Destination();
					$destinationM	=	$destinationM->find($options["destinationId"]);
					if(false!==$destinationM)
					{
						$bankBreakerAllArr = array();
						$bankBreakerArr1 = array();
						$bankBreakerArr2 = array();
						for($item=0; $item<count($options["bankBreakerItem"]); $item++)
						{
							$bankBreakerArr1[$options["bankBreakerItem"][$item]] = $options["bankBreakerRating"][$item];
						}
						$bankBreakerArr2["amount"] = $options["bankBreakerAmount"];
						$bankBreakerArr2["currency"] = $options["bankBreakerCurrency"];
						$bankBreakerArr2["rate"] = $options["bankBreakerRate"];
						
						$bankBreakerAllArr["bankBreaker"] = $bankBreakerArr1;
						$bankBreakerAllArr["dailyBudget"] = $bankBreakerArr2;
						
						$BankBreaker = serialize($bankBreakerAllArr);
						$destinationM->setBankBreaker($BankBreaker);
						$res2 = $destinationM->save();
						if($res2)
						{
							$response .= "<br />Bank Breaker Or Penny Pincher has been updated successfully.";
							//$arrayResult = Array("error"=>0, "response"=>"Bank Breaker Or Penny Pincher has been updated successfully.");
						}
						else
						{
							$response .= "<br />Can not update In A Nutshell details.";
							//$arrayResult = Array("error"=>1, "response"=>"Error occured while updating Bank Breaker Or Penny Pincher information.");
						}
					}
					else
					{
						$response .= "<br />Error occured, destination information is missing.";
						//$arrayResult = Array("error"=>1, "response"=>"Error occured, destination information is missing.");
					}
				}
				if(isset($options["pracTitle"]))
				{
					//first delete all records
					$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout();
					$dontLeaveWithoutM->delete("destination_id={$options['destinationId']}");
					
					//now save new records
					for($dont=0; $dont<count($options["pracTitle"]); $dont++)
					{
						if(trim($options["pracTitle"][$dont])!="")
						{
							$newItem["title"]			= $options["pracTitle"][$dont];
							$newItem["copy"]			= $options["pracCopy"][$dont];
							$newItem["destinationId"]	= $options["destinationId"];
							
							$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout($newItem);
							$dontLeaveWithoutM->save();
								
							/*$id = "";
							if(isset($options["dontLeaveWithoutId"][$dont]))
							{
								$id	= $options["dontLeaveWithoutId"][$dont];
							}
							$pracTitle	= $options["pracTitle"][$dont];
							$pracCopy	= $options["pracCopy"][$dont];
							
							$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout();
							$dontLeaveWithoutM	=	$dontLeaveWithoutM->find($id);
							if(false!==$dontLeaveWithoutM)
							{
								$dontLeaveWithoutM->setTitle($pracTitle);
								$dontLeaveWithoutM->setCopy($pracCopy);
								$dontLeaveWithoutM->save();
							}
							else
							{
								$newItem["title"] = $pracTitle;
								$newItem["copy"] = $pracCopy;
								$newItem["destinationId"] = $options["destinationId"];
								$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout($newItem);
								$dontLeaveWithoutM->save();
							}*/
						}//end if
					}//end for
					$response .= "<br />Don't Leave Here Without has been updated successfully.";
				}
				//$arrayResult = Array("error"=>0, "response"=>$response);				
			}
			else
			{
				//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
				$response .= "<br />Error occured, no data found.";
			}
			$_SESSION['errorMsg'] = $response;
			$id 	= $options["countryId"];
			$page	= $options["page"];
			$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-1"));
			//echo Zend_Json::encode($arrayResult);
			//exit;	
		}
	}//end function
	
	//update Practical information
	public function updateCountryTab2DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$response = "";
		
		$request = $this->getRequest();		
		if ($request->isPost())
		{
			$options = $request->getPost();
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($options["lonelyPlanetCountryId"]);
			if(false!==$lonelyPlanetCountryM)
			{
				$fullDestinationName = $options["fullDestinationName"];
				$timeZoneArr = array();
				for($time=0; $time<count($options["gmtUtc"]); $time++)
				{
					$timeZoneArr[] = array("gmt_utc"=>$options["gmtUtc"][$time]);
				}
				
				$timezones 				=	serialize($timeZoneArr);
				$capitalCity			=	$options["capitalCity"];
				$countryDiallingCode	=	$options["countryDiallingCode"];
				$currencyName			=	$options["currencyName"];
				$currencyCode			=	$options["currencyCode"];
				$currencyUnit			=	$options["currencyUnit"];
				
				$languageArr = array();
				for($lan=0; $lan<count($options["languageType"]); $lan++)
				{
					$languageArr[] = array("language_spoken_type"=>$options["languageType"][$lan], "language_spoken_name"=>$options["languageName"][$lan], "language_spoken_description"=>$options["languageDesc"][$lan]);
				}
				
				$languages				=	serialize($languageArr);
				$areaSqkm				=	$options["areaSqkm"];
				$population				=	$options["population"];
				
				$electricalPlugsArr = array();
				for($ele=0; $ele<count($options["elecPlugImage"]); $ele++)
				{
					$electricalPlugsArr[] = array("image_filename"=>$options["elecPlugImage"][$ele], "electrical_plug_description"=>$options["elecPlugDesc"][$ele]);
				}
				$electricalPlugs		=	serialize($electricalPlugsArr);
				$electricityVoltage		=	$options["electricityVoltage"];
				$religion				=	"<p>".$options["religion"]."</p>";
				$visasOverview			=	$options["visasOverview"];
				$dangersAndAnnoyances	=	$options["dangersAndAnnoyances"];
				$weatherOverview		=	$options["weatherOverview"];					
				
				$lonelyPlanetCountryM->setFullDestinationName($fullDestinationName);
				$lonelyPlanetCountryM->setTimezones($timezones);
				$lonelyPlanetCountryM->setCapitalCity($capitalCity);
				$lonelyPlanetCountryM->setCountryDiallingCode($countryDiallingCode);
				$lonelyPlanetCountryM->setCurrencyName($currencyName);
				$lonelyPlanetCountryM->setCurrencyCode($currencyCode);
				$lonelyPlanetCountryM->setCurrencyUnit($currencyUnit);
				$lonelyPlanetCountryM->setLanguageSpokens($languages);
				$lonelyPlanetCountryM->setAreaSqkm($areaSqkm);
				$lonelyPlanetCountryM->setPopulation($population);
				$lonelyPlanetCountryM->setElectricalPlugs($electricalPlugs);
				$lonelyPlanetCountryM->setElectricityVoltage($electricityVoltage);
				$lonelyPlanetCountryM->setReligion($religion);
				$lonelyPlanetCountryM->setVisasOverview($visasOverview);
				$lonelyPlanetCountryM->setDangersAndAnnoyances($dangersAndAnnoyances);
				$lonelyPlanetCountryM->setWeatherOverview($weatherOverview);
				$lonelyPlanetCountryM->save();
				//$arrayResult = Array("error"=>0, "response"=>"Practical info has been updated successfully.");
				$response = "Practical info has been updated successfully.";
			}
			else
			{
				$response = "Error occured, no data found.";
				//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
			}
			$_SESSION['errorMsg'] = $response;
			$id 	= $options["countryId"];
			$page	= $options["page"];
			$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-2"));
			
			//echo Zend_Json::encode($arrayResult);
			//exit;			
		}//end if
	}//end function
	
	//update Travel information
	public function updateCountryTab3DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$response = "";
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($options["lonelyPlanetCountryId"]);
			if(false!==$lonelyPlanetCountryM)
			{
				$travelArr = array();
				$travelArr['getting there and away'] = $options["gettingThereAndAway"];
				$travelArr['getting around']		 = $options["gettingAround"];
				$newTravelArr = serialize($travelArr);
				$lonelyPlanetCountryM->setTransport($newTravelArr);
				$lonelyPlanetCountryM->save();
				//$arrayResult = Array("error"=>0, "response"=>"Travel information has been updated successfully.");
				$response = "Travel information has been updated successfully.";
			}
			else
			{	
				//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
				$response = "Error occured, no data found.";
			}
			
			$_SESSION['errorMsg'] = $response;
			$id 	= $options["countryId"];
			$page	= $options["page"];
			$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-3"));
			//echo Zend_Json::encode($arrayResult);
			//exit;	
		}//end if
	}//end function
	
	
	//update Culture information
	public function updateCountryTab4DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$response = "";
		
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($options["lonelyPlanetCountryId"]);
			if(false!==$lonelyPlanetCountryM)
			{
				$lonelyPlanetCountryM->setHistoryRecent($options["historyRecent"]);
				$lonelyPlanetCountryM->setHistoryModern($options["historyModern"]);
				$lonelyPlanetCountryM->setHistoryPre20c($options["historyPre20c"]);
				$lonelyPlanetCountryM->save();
				//$arrayResult = Array("error"=>0, "response"=>"Culture information has been updated successfully.");
				$response = "Culture information has been updated successfully.";
			}
			else
			{	
				//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
				$response = "Error occured, no data found.";
			}
			$_SESSION['errorMsg'] = $response;
			$id 	= $options["countryId"];
			$page	= $options["page"];
			$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-4"));
			
			//echo Zend_Json::encode($arrayResult);
			//exit;	
		}//end if
	}//end function
	
	//update Points Of Interests information
	public function updateCountryTab5DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$response = "";
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($options["lonelyPlanetCountryId"]);
			if(false!==$lonelyPlanetCountryM)
			{
				$poiArr = array();
				$poiArr1 = array();
				
				//set default values saved, which are not editable
				$poiSavedArr = $lonelyPlanetCountryM->getPois();
				$poiSavedArr = unserialize($poiSavedArr);
				
				for($poi=0; $poi<count($options["poiName"]); $poi++)
				{
					$addressParts 		=	"";
					$addressPostcode	=	"";
					$poiWeb				=	"";
					$keywords			=	"";
					if(trim($options["poiName"][$poi])!="")
					{
						if(isset($poiSavedArr[$poi]["address_parts"]))
						$addressParts		= $poiSavedArr[$poi]["address_parts"];
						
						if(isset($poiSavedArr[$poi]["address_postcode"]))
						$addressPostcode	= $poiSavedArr[$poi]["address_postcode"];
						
						if(isset($poiSavedArr[$poi]["poi_web"]))
						$poiWeb				= $poiSavedArr[$poi]["poi_web"];
						
						if(isset($poiSavedArr[$poi]["keywords"]))
						$keywords			= $poiSavedArr[$poi]["keywords"];
				
						$poiName			= $options["poiName"][$poi];
						$reviewSummary		= $options["reviewSummary"][$poi];
						$reviewFull			= $options["reviewFull"][$poi];
					
						$poiArr1["poi_name"] 			= $poiName;
						$poiArr1["address_parts"]		= $addressParts;
						$poiArr1["address_postcode"] 	= $addressPostcode;
						$poiArr1["poi_web"] 			= $poiWeb;
						$poiArr1["review_summary"] 		= $reviewSummary;
						$poiArr1["review_full"] 		= $reviewFull;
						$poiArr1["keywords"] 			= $keywords;
						$poiArr[] = $poiArr1;
					}//end if	
				}//end for
				$poiNewArr = serialize($poiArr);
				$lonelyPlanetCountryM->setPois($poiNewArr);
				$lonelyPlanetCountryM->save();
				$arrayResult = Array("error"=>0, "response"=>"POI information has been updated successfully.");
				$response = "POI information has been updated successfully.";
			}
			else
			{	
				//$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
				$response = "Error occured, no data found.";
			}
			//echo Zend_Json::encode($arrayResult);
			//exit;
			
			$_SESSION['errorMsg'] = $response;
			$id 	= $options["countryId"];
			$page	= $options["page"];
			$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id, "page"=>$page, "tab"=>"tabs-5"));
		}//end if
	}//end function
	
	
	//update The Knowledge information
	public function updateCountryTab6DataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();			
			$id = $options["destination_id"];
			$destinationM	=	new Application_Model_Destination();
			$destinationM	=	$destinationM->find($id);
			if(false!==$destinationM)
			{
				$theKnowledgeArr = array();
				$qusAnsArr = array();
				for($qus=0; $qus<count($options["question"]); $qus++)
				{
					if(trim($options["question"][$qus])!="")
					{
						$qusAnsArr["title"] = $options["question"][$qus];
						$qusAnsArr["copy"] = $options["answer"][$qus];
						$theKnowledgeArr[] = $qusAnsArr;
					}	
				}
				$theKnowledgeArr = serialize($theKnowledgeArr);
				$destinationM->setKnowledge($theKnowledgeArr);
				$destinationM->save();
				$arrayResult = Array("error"=>0, "response"=>"The Knowledge information has been updated successfully.");					
			}
			else
			{	
				$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
			}
			echo Zend_Json::encode($arrayResult);
			exit;	
		}//end if
	}//end function
	
	//Delete country images and return JSON response
	public function deleteCountryImageAction()
	{
		//disable layout and helper
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get request
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$image_id	=	$options["image_id"];
			
			$model	=	new Application_Model_CountryImages();
			$res	=	$model->find($image_id);
			if(false!==$res)
			{
				$model->delete("id={$image_id}");
				
				//unlink image if files exists
				if(file_exists("media/picture/country/images/".$res->getCountryImage()))
				{
					@unlink("media/picture/country/images/".$res->getCountryImage());
					@unlink("media/picture/country/images/thumbs/".$res->getCountryImage());
				}	
				$arrayResult = Array("error"=>0, "response"=>"Image has been deleted.");
			}
			else
			{
				$arrayResult = Array("error"=>1, "response"=>"Invalid request, no image found.");
			}
			/*
			$country_id	=	$options["country_id"];
			
			$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
			$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($country_id);
			if(false!==$lonelyPlanetCountryM)
			{
				$countryImages = unserialize($lonelyPlanetCountryM->getImages());
				$bigImage = $countryImages[$image_id]["image_filename"];
				$thumbImage = $countryImages[$image_id]["image_thumbnail_filename"];
				unset($countryImages[$image_id]);
				$remainingImg = serialize($countryImages);
				$lonelyPlanetCountryM->setImages($remainingImg);
				$res = $lonelyPlanetCountryM->save();
				if($res)
				{
					//unlink images
					@unlink("media/picture/country/".$bigImage);
					@unlink("media/picture/country/".$thumbImage);
					
					$arrayResult = Array("error"=>0, "response"=>"Image has been deleted.");
				}
				else
				{
					$arrayResult = Array("error"=>1, "response"=>"Error occured, please try again later.");
				}	
			}
			else
			{
				$arrayResult = Array("error"=>1, "response"=>"Invalid request, no image found.");
			}*/
		}
		else
		{
			$arrayResult = Array("error"=>1, "response"=>"Invalid request, no image found.");
		}
		echo Zend_Json::encode($arrayResult);
		exit;		
	}//end function
	
	public function countryDontleavewithoutReloadAction()
	{
		$this->_helper->layout->disableLayout();
		$countryId		=	$this->_getParam("countryId");
		$this->view->countryId = $countryId;
	}
	
	
	public function addCountryAction()
	{
		//get request variables and set to view
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-1");
		$this->view->id = $id;
		$this->view->page = $page;
		$this->view->selTab	= $selTab;
		
		$errorMsg = "";
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();
			if($options["update_action"]=="overview")
			{
				$node_id				= 0;
				$destination_name		= "";
				$full_destination_name	= "";
				$intro_mini 			= "";
				$intro_short 			= $options["introShort"];
				$timezones				= array("0"=>array("gmt_utc"=>""));
				$leaders 				= array (0=>array("leader_name"=>"", "leader_type"=>"", "leader_title"=>""));
				$religion 				= "";
				$currency_code 			= "";
				$currency_name			= "";
				$currency_symbol		= "";
				$currency_unit 			= "";
				$electrical_plugs		= array(0=>array("image_filename"=>"/images/plug_types/elec_4.gif", "electrical_plug_description"=>""));
				$health_conditions		= array ("cholera"=>"", "dengue fever"=>"", "hepatitis"=>"", "malaria"=>"", "meningococcal meningitis"=>"", "typhoid"=>"");
				$transport				= array("getting there and away"=>"", "getting around"=>"");
				//$images				= array ("0"=> array("image_caption"=>"", "image_photographer"=>"Administrator", "image_filename"=>"", "image_thumbnail_filename"=>""));
				$images					= array();
				$map					= array("map_name" =>"N/A","map_filename"=> "/maps/","map_thumbnail_filename"=>"/maps/thumbs/");
				$pois					= array("0" => array("poi_name" =>"","address_parts" => array("0" => array("address_type" => "street","address_text" => "")),"address_postcode" => "","poi_web" => "","review_summary" => "","review_full" => "","keywords" => array("keyword" => array("0" =>"NA"))));
				$attractions			= array("0" => array("destination_name" => "","full_destination_name" => "","intro_short" => "","intro_medium" => ""));
				$country_id				= $options["countryId"];
				$area_sqkm				= 0;
				$population				= 0;
				$language_spokens		= array(0=>array("language_spoken_type"=>"official","language_spoken_name"=>"N/A","language_spoken_description"=>"N/A"));
				
				//get Country name
				$countryM = new Application_Model_Country();
				$countryM = $countryM->find($options["countryId"]);
				if($countryM!==false)
				{
					$destination_name = $countryM->getName();
					$full_destination_name = $countryM->getName();
				}				
				$params["nodeId"] 				= $node_id;
				$params["destinationName"]		= $destination_name;
				$params["fullDestinationName"]	= $full_destination_name;
				$params["introMini"]			= $intro_mini;
				$params["introShort"]			= $intro_short;
				$params["timezones"]			= serialize($timezones);
				$params["leaders"]				= serialize($leaders);
				$params["areaSqkm"]				= $area_sqkm;
				$params["population"]			= $population;
				$params["languageSpokens"]		= serialize($language_spokens);
				$params["religion"]				= $religion;
				$params["currencyCode"]			= $currency_code;
				$params["currencyName"]			= $currency_name;
				$params["currencySymbol"]		= $currency_symbol;
				$params["currencyUnit"]			= $currency_unit;
				$params["electricalPlugs"]		= serialize($electrical_plugs);
				$params["healthConditions"]		= serialize($health_conditions);
				$params["transport"]			= serialize($transport);
				$params["images"]				= serialize($images);
				$params["map"]					= serialize($map);
				$params["pois"]					= serialize($pois);
				$params["attractions"]			= serialize($attractions);
				$params["countryId"]			= $country_id;				
				
				$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry($params);
				$res = $lonelyPlanetCountryM->save();
				if($res)
				{
					//save destination information into DB
					$title			= "A guide to ".$destination_name;
					$introduction	= "";
					$location_id	= $country_id;
					$location_type	= "country";
					
					$bankBreakerAllArr = array();
					$bankBreakerArr1 = array();
					$bankBreakerArr2 = array();
					for($item=0; $item<count($options["bankBreakerItem"]); $item++)
					{
						$bankBreakerArr1[$options["bankBreakerItem"][$item]] = $options["bankBreakerRating"][$item];
					}
					$bankBreakerArr2["amount"] = $options["bankBreakerAmount"];
					$bankBreakerArr2["currency"] = $options["bankBreakerCurrency"];
					$bankBreakerArr2["rate"] = $options["bankBreakerRate"];
					
					$bankBreakerAllArr["bankBreaker"] = $bankBreakerArr1;
					$bankBreakerAllArr["dailyBudget"] = $bankBreakerArr2;
					
					$bank_breaker = serialize($bankBreakerAllArr);
					
					$knowledgeArr	= array(0=>array("title"=>"","copy"=>""));
					$knowledge		= serialize($knowledgeArr);
					
					$destination["title"]			= $title;
					$destination["introduction"]	= $introduction;
					$destination["locationId"]		= $location_id;
					$destination["locationType"]	= $location_type;
					$destination["bankBreaker"]		= $bank_breaker;
					$destination["knowledge"]		= $knowledge;
					
					//if Destination information is already exists then update table record else insert new record
					$destinationM = new Application_Model_Destination($destination);
					$destinationM	=	$destinationM->fetchRow("location_id={$location_id} AND location_type='country'");
					if(false!==$destinationM)
					{
						$destinationM->setTitle($title);
						$destinationM->setIntroduction($introduction);
						$destinationM->setLocationId($location_id);
						$destinationM->setLocationType($location_type);
						$destinationM->setBankBreaker($bank_breaker);
						$destinationM->setKnowledge($knowledge);
						$destinationM->save();
						$destination_id = $destinationM->getId();
					}
					else
					{
						$destinationM = new Application_Model_Destination($destination);
						$destination_id = $destinationM->save();
					}					
					
					if($destination_id)
					{
						//save Don't leave Without information
						for($dont=0; $dont<count($options["pracTitle"]); $dont++)
						{
							if(trim($options["pracTitle"][$dont])!="")
							{
								$pracTitle	= $options["pracTitle"][$dont];
								$pracCopy	= $options["pracCopy"][$dont];
								
								$newItem["title"]			= $pracTitle;
								$newItem["copy"]			= $pracCopy;
								$newItem["destinationId"] 	= $destination_id;
								$dontLeaveWithoutM	=	new Application_Model_DontLeaveWithout($newItem);
								$dontId = $dontLeaveWithoutM->save();
							}//end if	
						}//end for
						//$_SESSION['errorMsg'] = "Overview has been saved.";
						$this->_helper->redirector("edit-country","featured-city","admin",array("id"=>$id,"page"=>$page,"tab"=>"tabs-1"));
					}
					else
					{
						$errorMsg = "Error occured, unable to save data into destination.";
					}					
				}
				else
				{
					$errorMsg = "Error occured, unable to save data into Lonely Planet country.";
				}
			}//end if			
		}//end if
		$this->view->errorMsg = $errorMsg;
	}//end function
	
	//update Meta data information
	public function updateMetadataAction()
	{
		$this->_helper->layout->disableLayout();	
		$this->_helper->viewRenderer->setNoRender(true);
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			$metadataM	=	new Application_Model_TravelGuidesMetadata();
			//$metadataM	=	$metadataM->find($options["lonelyPlanetCountryId"]);
			$item_id = $options['itemId'];
			$item_type = $options['itemType'];
			$metadataM	=	$metadataM->fetchRow("item_id={$item_id} AND item_type='{$item_type}'");
			if(false!==$metadataM)
			{
				$metadataM->setMetaTitle($options["metaTitle"]);
				$metadataM->setMetaKeyword($options["metaKeyword"]);
				$metadataM->setMetaDesc($options["metaDesc"]);
				$metaRes = $metadataM->save();
			}
			else
			{
				$metadataM	=	new Application_Model_TravelGuidesMetadata($options);
				$metaRes = $metadataM->save();
			}
			
			if($metaRes)
			{
				$arrayResult = Array("error"=>0, "response"=>"Meta data information has been updated successfully.");
			}	
			else
			{	
				$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
			}
			echo Zend_Json::encode($arrayResult);
			exit;	
		}//end if
	}//end function
	
	//Add city image
	public function addCityImageAction()
	{
		$this->_helper->layout->disableLayout();	
		//$this->_helper->viewRenderer->setNoRender(true);
		
		//get request variables
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-5");
		$this->view->cityId = $id;
		
		//create image upload form
		$uploadForm	= new Admin_Form_CityImages();
		$elements	= $uploadForm->getElements();
		$uploadForm->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->uploadForm = $uploadForm;
			
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if ($uploadForm->isValid($options)) 
            { 
            	$target_file_name = "";
				//Upload image start here
				$upload = new Zend_File_Transfer_Adapter_Http();
				
                if($upload->isValid())
				{
                    $upload->setDestination("media/picture/city/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));
					$file_name = $upload->getFileName('cityImage');
					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "city{$id}_".time().".{$ext}";

					$targetPath = "media/picture/city/".$target_file_name;
					//$targetPathThumb = "media/picture/home/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);

					//$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					//$thumb->resize(623, 347);
					//$thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set image
				$params['cityImage']	=	$target_file_name;
				$params['status']		=	1;
				
				$model	= new Application_Model_CityImages($params);
				$res	= $model->save();
				if($res)
				{
					//return $this->_helper->redirector('index','content',"admin",Array('msg'=>base64_encode("Content has been saved successfully!")));
					$_SESSION['errorMsg'] = "Images has been saved successfully.";
					echo "<script>window.opener.location='/admin/featured-city/edit-city/id/{$id}/page/{$page}/tab/{$selTab}';</script>";
					echo "<script>window.close();</script>";
				}
				else
				{
					$this->view->errorMsg = "Error occured, please try again later.";
				}	
            }
            else
            {
            	$uploadForm->reset();
            	$uploadForm->populate($options);
            }	
		}//end if
	}//end function
	
	//Edit city image
	public function editCityImageAction()
	{
		$this->_helper->layout->disableLayout();	
		//$this->_helper->viewRenderer->setNoRender(true);
		
		//get request variables
		$id		=	$this->_getParam("id");
		$img_id	=	$this->_getParam("img_id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-5");
		$this->view->cityId = $id;
		
		//create image upload form
		$uploadForm	= new Admin_Form_CityImages();
		$elements	= $uploadForm->getElements();
		$uploadForm->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$uploadForm->getElement("cityImage")->setRequired(false);
		
		//get city image information to edit
		$model	=	new Application_Model_CityImages();
		$model	=	$model->find($img_id);
		
		$options['slideTitle']		=	$model->getSlideTitle();
      	$options['altText']			=	$model->getAltText();
      	$options['slideLinkUrl']	=	$model->getSlideLinkUrl();
		$options['slideLinkTarget']	=	$model->getSlideLinkTarget();
      	$options['weight']			=	$model->getWeight();
		
		$uploadForm->populate($options);
		$this->view->cityImage = $model->getCityImage();
		$this->view->uploadForm = $uploadForm;
			
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if ($uploadForm->isValid($options)) 
            { 
            	$target_file_name = $model->getCityImage();
				
				//Upload image start here
				$upload = new Zend_File_Transfer_Adapter_Http();				
                if($upload->isValid())
				{
                    $upload->setDestination("media/picture/city/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));
					$file_name = $upload->getFileName('cityImage');
					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
					
					//unlink existing image
					if($ext!="" && $target_file_name!="")
					{
						if(file_exists("media/picture/city/".$target_file_name))
						{
							unlink("media/picture/city/".$target_file_name);
						}
					}
					$target_file_name = "city{$id}_".time().".{$ext}";

					$targetPath = "media/picture/city/".$target_file_name;
					//$targetPathThumb = "media/picture/city/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);

					//$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					//$thumb->resize(623, 347);
					//$thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set image
				$params['cityImage']	=	$target_file_name;
				$params['status']		=	1;
				$params['id']			=	$img_id;
				
				$model	= new Application_Model_CityImages($params);
				$res	= $model->save();
				if($res)
				{
					$_SESSION['errorMsg'] = "Images has been saved successfully.";
					echo "<script>window.opener.location='/admin/featured-city/edit-city/id/{$id}/page/{$page}/tab/{$selTab}';</script>";
					echo "<script>window.close();</script>";
				}
				else
				{
					$this->view->errorMsg = "Error occured, please try again later.";
				}	
            }
            else
            {
            	$uploadForm->reset();
            	$uploadForm->populate($options);
            }	
		}//end if
		$this->render("add-city-image");
	}//end function
	
	//Add country image
	public function addCountryImageAction()
	{
		$this->_helper->layout->disableLayout();	
		
		//get request variables
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-7");
		$this->view->countryId = $id; //country ID
		
		//create image upload form
		$uploadForm	= new Admin_Form_CityImages();
		$elements	= $uploadForm->getElements();
		$uploadForm->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->uploadForm = $uploadForm;
			
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if ($uploadForm->isValid($options)) 
            { 
            	$target_file_name = "";
				//Upload image start here
				$upload = new Zend_File_Transfer_Adapter_Http();
				
                if($upload->isValid())
				{
                    $upload->setDestination("media/picture/country/images/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));
					$file_name = $upload->getFileName('cityImage');
					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "country{$id}_".time().".{$ext}";

					$targetPath 		= "media/picture/country/images/".$target_file_name;
					$targetPathThumb	= "media/picture/country/images/thumbs/".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(623, 347);
					$thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set image
				$params['countryImage']	=	$target_file_name;
				$params['status']		=	1;
				
				$model	= new Application_Model_CountryImages($params);
				$res	= $model->save();
				if($res)
				{
					$_SESSION['errorMsg'] = "Images has been saved successfully.";
					echo "<script>window.opener.location='/admin/featured-city/edit-country/id/{$id}/page/{$page}/tab/{$selTab}';</script>";
					echo "<script>window.close();</script>";
				}
				else
				{
					$this->view->errorMsg = "Error occured, please try again later.";
				}	
            }
            else
            {
            	$uploadForm->reset();
            	$uploadForm->populate($options);
            }	
		}//end if
	}//end function
	
	//Edit Country image
	public function editCountryImageAction()
	{
		$this->_helper->layout->disableLayout();	
		
		//get request variables
		$id		=	$this->_getParam("id");
		$img_id	=	$this->_getParam("img_id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-7");
		$this->view->countryId = $id;
		
		//create image upload form
		$uploadForm	= new Admin_Form_CityImages();
		$elements	= $uploadForm->getElements();
		$uploadForm->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$uploadForm->getElement("cityImage")->setRequired(false);
		
		//get city image information to edit
		$model	=	new Application_Model_CountryImages();
		$model	=	$model->find($img_id);
		
		$options['slideTitle']		=	$model->getSlideTitle();
      	$options['altText']			=	$model->getAltText();
      	$options['slideLinkUrl']	=	$model->getSlideLinkUrl();
		$options['slideLinkTarget']	=	$model->getSlideLinkTarget();
      	$options['weight']			=	$model->getWeight();
		
		$uploadForm->populate($options);
		$this->view->countryImage = $model->getCountryImage();
		$this->view->uploadForm = $uploadForm;
			
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if ($uploadForm->isValid($options)) 
            { 
            	$target_file_name = $model->getCountryImage();
				
				//Upload image start here
				$upload = new Zend_File_Transfer_Adapter_Http();				
                if($upload->isValid())
				{
                    $upload->setDestination("media/picture/country/images/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));
					$file_name = $upload->getFileName('cityImage');
					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
					
					//unlink existing image
					if($ext!="" && $target_file_name!="")
					{
						if(file_exists("media/picture/country/images/".$target_file_name))
						{
							unlink("media/picture/country/images/".$target_file_name);
							unlink("media/picture/country/images/thumbs/".$target_file_name);
						}
					}
					$target_file_name = "country{$id}_".time().".{$ext}";

					$targetPath 	 = "media/picture/country/images/".$target_file_name;
					$targetPathThumb = "media/picture/country/images/thumbs/".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(623, 347);
					$thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set image
				$params['countryImage']	=	$target_file_name;
				$params['status']		=	1;
				$params['id']			=	$img_id;
				
				$model	= new Application_Model_CountryImages($params);
				$res	= $model->save();
				if($res)
				{
					$_SESSION['errorMsg'] = "Images has been saved successfully.";
					echo "<script>window.opener.location='/admin/featured-city/edit-country/id/{$id}/page/{$page}/tab/{$selTab}';</script>";
					echo "<script>window.close();</script>";
				}
				else
				{
					$this->view->errorMsg = "Error occured, please try again later.";
				}	
            }
            else
            {
            	$uploadForm->reset();
            	$uploadForm->populate($options);
            }	
		}//end if
		$this->render("add-country-image");
	}//end function
	
	//Add Country image, not in use
	public function addCountryImageEXPAction()
	{
		$this->_helper->layout->disableLayout();
		//$this->_helper->viewRenderer->setNoRender(true);
		
		//get request variables
		$id		=	$this->_getParam("id");
		$page	=	$this->_getParam("page");
		$selTab =	$this->_getParam("tab","tabs-7");
		$this->view->cityId = $id;
		
		//create image upload form
		$uploadForm	= new Admin_Form_CityImages();
		$elements	= $uploadForm->getElements();
		$uploadForm->clearDecorators();
		foreach($elements as $element)
		{
			$element->removeDecorator('label');
			$element->removeDecorator('td');
			$element->removeDecorator('tr');
			$element->removeDecorator('row');
			$element->removeDecorator('HtmlTag');
			$element->removeDecorator('placement');
			$element->removeDecorator('data');
		}
		$this->view->uploadForm = $uploadForm;
		
		//selects country images to edit
		$oldImageArr = array();
		$oldImageSortingArr = array();
		$lonelyPlanetCountryM	=	new Application_Model_LonelyPlanetCountry();
		$lonelyPlanetCountryM	=	$lonelyPlanetCountryM->find($id);
		if(false!==$lonelyPlanetCountryM)
		{
			$oldImageArr = unserialize($lonelyPlanetCountryM->getImages());
			//echo "<pre>";
			//print_r($oldImageArr);
			
			for($oCnt=0; $oCnt<count($oldImageArr); $oCnt++)
			{
				$imgArr = $oldImageArr[$oCnt];
				$imgArr["alt_text"] = "";
				$imgArr["slide_link_url"] = "";
				$imgArr["slide_link_target"] = "";
				$imgArr["weight"] = $oCnt+1;
				$oldImageSortingArr[] = $imgArr;
			}
			//print_r($oldImageSortingArr);
			//echo "</pre>";
			//exit;
		}	
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if ($uploadForm->isValid($options)) 
            { 
            	$target_file_name = "";
				//Upload image strat here
				$upload = new Zend_File_Transfer_Adapter_Http();				
				if($upload->isValid())
				{
					$upload->setDestination("media/picture/country/");
					try
					{
						$upload->receive();
					}
					catch (Zend_File_Transfer_Exception $e)
					{
						$msg = $e->getMessage();
					}

					$upload->setOptions(array('useByteString' => false));
					$file_name = $upload->getFileName('countryImage');
					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "country{$country_id}_".time().".{$ext}";

					$targetPath = "media/picture/country/images/".$target_file_name;
					$targetPathThumb = "media/picture/country/images/thumbs/".$target_file_name;
					
					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					$filterFileRename -> filter($file_name);
					
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(625, 330);
					$thumb->save($targetPathThumb);
				}//end if
				//upload image Ends here
				
				//set country Image array
				$addImageArr = array();
				$addImageArr["image_caption"]			= $options["slideTitle"];
				$addImageArr["image_photographer"]		= "Gap Daemon";
				$addImageArr["image_filename"]			= "/images/".$target_file_name;
				$addImageArr["image_thumbnail_filename"]= "/images/thumbs/".$target_file_name;
				$addImageArr["alt_text"]				= $options["altText"];
				$addImageArr["slide_link_url"]			= $options["slideLinkUrl"];
				$addImageArr["slide_link_target"]		= $options["slideLinkTarget"];
				$addImageArr["weight"]					= $options["weight"];
				
				$oldImageSortingArr[count($oldImageSortingArr)] = $addImageArr;
				$newCountryImageArr = serialize($oldImageSortingArr);
				$lonelyPlanetCountryM->setImages($newCountryImageArr);
				$resImg = $lonelyPlanetCountryM->save();
					
				if($resImg)
				{
					$_SESSION['errorMsg'] = "Images has been saved successfully.";
					echo "<script>window.opener.location='/admin/featured-city/edit-country/id/{$id}/page/{$page}/tab/{$selTab}';</script>";
					echo "<script>window.close();</script>";
				}
				else
				{
					$this->view->errorMsg = "Error occured, please try again later.";
				}	
            }
            else
            {
            	$uploadForm->reset();
            	$uploadForm->populate($options);
            }	
		}//end if
		$this->render("add-city-image");
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 7-April-2011
	 * @Description: Update location(City, Country) GEO location from Google MAP
	 */
	public function locationGeoCodeAction()
	{
		$this->_helper->layout->disableLayout();
		
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$options = $request->getPost();
			if($options["type"]=="city")
			{
				$cityM	= new Application_Model_City();
				$cityM	= $cityM->find($options["id"]);
				if(false!==$cityM)
				{
					$cityM->setLatitude($options["latitude"]);
					$cityM->setLongitude($options["longitude"]);
					$cityM->setAddress($options["location_address"]);
					$res = $cityM->save();
				}
				else
				{
					$arrayResult = Array("error"=>1, "response"=>"Error occured, no city found.");
				}
			}
			else
			{
				$countryM	= new Application_Model_Country();
				$countryM	= $countryM->find($options["id"]);
				if(false!==$countryM)
				{
					$countryM->setLatitude($options["latitude"]);
					$countryM->setLongitude($options["longitude"]);
					$countryM->setAddress($options["location_address"]);
					$res = $countryM->save();
				}
				else
				{
					$arrayResult = Array("error"=>1, "response"=>"Error occured, no city found.");
				}
			}
			
			//set response
			if($res)
			{
				$arrayResult = Array("error"=>0, "response"=>"Location has been updated successfully.");
			}
			else
			{
				$arrayResult = Array("error"=>1, "response"=>"Error occured, no data found.");
			}
			
			$this->_helper->viewRenderer->setNoRender(true);
			echo Zend_Json::encode($arrayResult);
			exit;				
		}//end if
		//get request variables
		$id		=	$this->_getParam("id");
		$type	=	$this->_getParam("type");
		$this->view->id = $id;
		$this->view->type = $type;
	}//end function
}
