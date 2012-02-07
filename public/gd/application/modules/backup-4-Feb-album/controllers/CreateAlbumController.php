<?php


class Album_CreateAlbumController extends Base_Controller_Action {

	public function preDispatch()
	{
		parent::preDispatch();
		
		$this->_helper->layout->setLayout('2column');
	}
	
	public function indexAction() 
	{	
		if(isset($_SESSION['msg']))
		{
			$this->view->msg	=	$_SESSION['msg'];
			unset($_SESSION['msg']);	
		}
		$userNs	=	new Zend_Session_Namespace('members');
		$userId	=	$userNs->userId;
		$form	=	new Album_Form_Album();
		$objModelAlbum     =	new Album_Model_Album();
	
	    $elements	=	$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element){
    		$element->removeDecorator('label');
    	}
	/*---------------------- GET USED PHOTO SIZE OF USER --------------------------*/
		$arrAlbumCapacity = $objModelAlbum->albumCapacity($userId);
		$this->view->capacityImage	=	$arrAlbumCapacity[0];
		$this->view->capacityPercent=	$arrAlbumCapacity[1];
		
    	$request	=	$this->getRequest();	// Get posted value
    		
		if($request->isPost())					// Condition for check form is posted
		{
        	$params	=	$request->getParams();	// Get all posted value 
        	
            if ($form->isValid($params)) 
            {     
            	
				$option['userId']	=	$userId;	// LoggedIn UserId
				
				$arrLatLang		=	explode(",", $params['latlang']);
				$latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
				$longitude		=	substr($arrLatLang[1], 0, -1);						//	Latitude of location

				$option['name']		=	$params['name'];
				$option['description']	=	$params['description'];
				$option['location']	=	$params['address'];
				$option['permission']	=	$params['permissions'];
				$option['longitude']	=	$longitude;
				$option['latitude']	=	$latitude;
				$option['status']	=	1;
				
				$albumM		=	new Album_Model_Album($option);
				$album_id	=	$albumM->save();
				
				if($album_id > 0)
				{
					/*----- start tags--------*/
					if($params['tags']	!=	"" && $params['tags'] != 'Seperate Tags by a comma. For example:Holiday,London,Travel')
					{
						$arrTags	=	explode(",", $params['tags']);
						foreach($arrTags as $_tag)
						{
							$_tag	=	trim($_tag);
							$tagsM	=	new Application_Model_Tags();
							$tag	=	$tagsM->fetchRow("tag='{$_tag}'");
							if(false===$tag){
								$tagsM->setTag($_tag);
								$tag_id	=	$tagsM->save();
							}else{
								$tag_id	=	$tag->getId();
							}
							$albumTagM	=	new Album_Model_AlbumTag();
							$albumTagM->setAlbumId($album_id);
							$albumTagM->setTagId($tag_id);
							$albumTagM->save();
							
						}
					}

                                        $redirectUrl    =   "/album/my-photos/album-photos/id/".$album_id;
					/*---------- end tags-------*/
					//$this->_helper->redirector('index','create-album',"album");
					$_SESSION['msg']	=	"Album created successfully.";
					$this->_redirect($redirectUrl);
					$form->reset();	
				}else{
					$_SESSION['msg']	=	"Faild to create Album. Please try again.";
					$this->_redirect('/album/create-album');	
				}
            }
          
		}
		

		
		
		$this->view->form=$form;
	}

        public function albumSubmitAction()
        {
                $this->_helper->layout()->disableLayout();
                $params =   $this->getRequest()->getParams();

                $userNs	=   new Zend_Session_Namespace('members');
		$option['userId']	=	$userNs->userId;	// LoggedIn UserId

                $arrLatLang		=	explode(",", $params['latlang']);
                $latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
                $longitude		=	substr($arrLatLang[1], 0, -1);						//	Latitude of location

                $option['name']		=	$params['name'];
                $option['description']	=       addslashes(strip_tags($params['description']));
                $option['location']	=	$params['address'];
                $option['permission']	=	$params['permissions'];
                $option['longitude']	=	$longitude;
                $option['latitude']	=	$latitude;
                $option['status']	=	1;

                $albumM		=	new Album_Model_Album($option);
                $album_id	=	$albumM->save();

                /*----- start tags--------*/
                    if($params['album_tags']	!=	"" && $params['album_tags'] != 'Seperate Tags by a comma. For example:Holiday,London,Travel')
                    {
                            $arrTags	=	explode(",", $params['album_tags']);
                            foreach($arrTags as $_tag)
                            {
                                    $_tag	=	trim($_tag);
                                    $tagsM	=	new Application_Model_Tags();
                                    $tag	=	$tagsM->fetchRow("tag='{$_tag}'");
                                    if(false===$tag){
                                            $tagsM->setTag($_tag);
                                            $tag_id	=	$tagsM->save();
                                    }else{
                                            $tag_id	=	$tag->getId();
                                    }
                                    $albumTagM	=	new Album_Model_AlbumTag();
                                    $albumTagM->setAlbumId($album_id);
                                    $albumTagM->setTagId($tag_id);
                                    $albumTagM->save();

                            }
                    }

                    echo $album_id;

                exit;
        }

        public function addAlbumAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$albumName	=	$arrPostVal['album_name'];
		$album_new	=	$arrPostVal['album_new'];
		
		if($album_new != ""){
			$option['id']			=	$album_new;
		}
		
		$userNs	=	new Zend_Session_Namespace('members');
		$option['userId']	=	$userNs->userId;	// LoggedIn UserId
	
		$option['name']			=	$albumName;
		$option['permission']	=	1;
		$option['status']		=	1;
		
		$albumM		=	new Album_Model_Album($option);
		$album_id	=	$albumM->save();
		
		if($album_new == ""){
			print $album_id;
		}else{
			print $album_new;
		}
		
		exit;
	}
	
}









