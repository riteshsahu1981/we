<?php


class Album_MyPhotosController extends Base_Controller_Action {

private $_session;
    
    public function init() {}
    
	public function preDispatch()
	{
		parent::preDispatch();		
		$this->_helper->layout->setLayout('2column');
		
		Base_Form_Element_Uploadify::bypassSession();
        $this->_session = new Zend_Session_Namespace('uplodify');		
	}
	
	public function indexAction() 
	{
		$objModelAlbum      =	new Album_Model_Album();
        $objModelPhotoTag   =   new Album_Model_PhotoTag();
		$objModelSetting    =	new Admin_Model_GlobalSettings();
		$objPage            =	new Base_Paginator();
		
		/*----------- GET LOGGEDIN USER INFORMATION ----------------------*/
		$usersNs      =	new Zend_Session_Namespace("members");
                $userFullName =	$usersNs->userFullName;
                $userId       =	$usersNs->userId;
    			//$usersNs->userEmail;
    				//$usersNs->userFullName;
    					//$usersNs->userFirstName;
    						//$usersNs->userUsername;
                $this->view->userFullName	=	$userFullName;
		/*----------- GET ALBUM WITH PAGINATION VALUE --------------------*/
		$pageSize	=	$objModelSetting->settingValue('album_page_size');
		
		$page		=	$this->_getParam('page',1);
		
		$whereAlbum	=	"status=1 AND user_id='{$userId}'";
		
		$orderAlbum	=	"addedon DESC";
		
		$arrAlbum	=	$objPage->fetchPageData($objModelAlbum, $page, $pageSize, $whereAlbum, $orderAlbum);
		
		$this->view->totalAlbum	=	$objPage->getTotalCount();
		
		$this->view->arrAlbum	=	$arrAlbum;
		/*---------------------- GET ALL TAGGED PHOTO WHERE I AM ----------------------*/
                
               $this->getTaggedImageOfUser($userId);
		/*---------------------- GET USED PHOTO SIZE OF USER --------------------------*/
		$arrAlbumCapacity = $objModelAlbum->albumCapacity($userId);
		$this->view->capacityImage	=	$arrAlbumCapacity[0];
		$this->view->capacityPercent=	$arrAlbumCapacity[1];
	}

	public function uploadPhotosAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelAlbum		=	new Album_Model_Album();
		
		$whereAlbum	=	"status=1";
		
		$orderAlbum	=	"addedon DESC";
		
		$arrAlbum	=	$objModelAlbum->fetchAll($whereAlbum, $orderAlbum);
		
		$this->view->arrAlbum	=	$arrAlbum;
		/*---------------------------------------------------------------------*/
		 // no output before this declaration
        $form = new Album_Form_Upload();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                if (method_exists($form->getElement('file'), 'isUploadify')) {
                    if (! $form->getElement('file')->isUploadify()) {
                        // Uploadify was not used even it was meant to be, f.e. javascript was disabled
                        $form->getElement('file')->addFilter('rename', $form->getElement('file')->getRandomFileName())->receive();
                    }
                    
                    /**
                     * Here you can rename/copy/process files
                     * ideal situation is, that you upload file to temporary directory,
                     * than processes it, copy it to directory, where you want to store it
                     * and maybe rename to original filename or something else
                     */
                    
                    // filename on HDD after upload was processed
                    //echo $form->getElement('file')->getFileName() . '<br/>';
                    // if was used rename filter in library/My/Form/Element/File.php, this will return original file name
                    //echo $form->getElement('file')->getOriginalFileName() . '<br/>';
                    
                } else {
                    /**
                     * Uplodify was not used, Zend_Form_Element_File was used instead.
                     * You dont need this code when you decide to use My_Form_Element_File.
                     * If you use this code, replace "random" with your custom random file name, to prevent file collision.
                     */
                    $form->getElement('file')->addFilter('rename', 'random')->receive();
                }
                $this->_redirect('/test-upload');
            }
        }
        $this->view->form = $form;
		
	}
	
	public function processImageAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
	

		$fileName	=	$arrPostVal['fileName'];
		$fileSize	=	$arrPostVal['fileSize'];
		$fileType	=	$arrPostVal['fileType'];
		$album		=	$arrPostVal['album'];
		$quality	=	$arrPostVal['quality'];

                $this->view->uploading_type=    $arrPostVal['uploadingType'];
                $this->view->review_edit=    $arrPostVal['review_edit'];

		$uploadedCount=	$arrPostVal['uploadedCount'];
		
		$newPhotoName	=	"album_".time()."_".rand(10,99).$fileType;
		
		$imagePath	=	PUBLIC_PATH."/images/album/default/".$fileName;
		$targetPath	=	PUBLIC_PATH."/images/album/default/".$newPhotoName;
		$targetPathR=	PUBLIC_PATH."/images/album/custom/".$newPhotoName;
		$targetPathT=	PUBLIC_PATH."/images/album/thumb/".$newPhotoName;
		
		copy($imagePath, $targetPathR);
		
		rename($imagePath, $targetPath);
		
		$mageSize	=	$this->getImageSize($quality);
		
		$thumb = Base_Image_PhpThumbFactory ::create($targetPath);		
				
		$thumb->resize($mageSize['width'], $mageSize['height']);
			
		$thumb->save($targetPathR);

		$thumb->resize(131, 98);	// Thumb Image
			
		$thumb->save($targetPathT); 

		/*----------- GET LOGGEDIN USER INFORMATION ----------------------*/
		$usersNs		=	new Zend_Session_Namespace("members");		
                $userId			=	$usersNs->userId;

        /*----------- CAPTURE TO DATABASE --------------------------------*/
       $option['albumId']		=	$album;
        $option['userId']		=	$userId;
        $option['image']		=	$newPhotoName;
        $option['name']			=	$newPhotoName;
        $option['type']			=	$fileType;
        $option['size']			=	filesize($targetPathR);
        $option['status']		=	1;
        $option['permission']	=	1;
        $option['addedon']	=	time();
        
        $objModelAlbumPhoto	=	new Album_Model_AlbumPhoto($option);
        $objModelAlbumPhoto->save();
        
        $objModelFriendGroup	=	new Application_Model_FriendGroup();
        $arrFriendGroup		=	$objModelFriendGroup->getPermissions();
        $this->view->arrFriendGroup=$arrFriendGroup; 
        $this->view->uploadedCount=$uploadedCount;
        $this->view->album	=	$album;
        
        
		
	}
	
	public function processImageCompleteAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
	    $permision		=	$arrPostVal['permision'];
	    $uploadedCount	=	$arrPostVal['uploadedCount'];
	    
	    $usersNs		=	new Zend_Session_Namespace("members");
            $userId		=	$usersNs->userId;
	    /*---------------------- GET ALL CURRENTLY ADDED RECORD -------------------*/
	    $where = "status=1 AND user_id=$userId";
	    $order = "addedon DESC";
	    $count = $uploadedCount;
	    $offset = 0;
	    
	    $arrAlbumPhoto	=	$objModelAlbumPhoto->fetchAll($where, $order, $count, $offset);
	    /*------------------------------------------------------------------------*/
	    foreach ($arrAlbumPhoto as $albumPhoto)
	    {
	    	$id	=	$albumPhoto->id;
	    	
	    	$valAlbumPhoto	=	$objModelAlbumPhoto->find($id);
	    	$valAlbumPhoto->setPermission($permision);
	    	$valAlbumPhoto->save();
	    }
		
		
		exit;
	}

        public function reviewEditImageAction()
        {
            $albumId	=	$this->_getParam('id');

            $objModelFriendGroup    =   new Application_Model_FriendGroup();
            $objModelSetting        =   new Admin_Model_GlobalSettings();
            $objModelAlbumPhotoTag  =	new Album_Model_AlbumPhotoTag();
            $objModelAlbumPhoto     =   new Album_Model_AlbumPhoto();
            $objModelTags           =	new Application_Model_Tags();
            $objModelAlbum          =   new Album_Model_Album();
            $objPage                =   new Base_Paginator();

            $usersNs		=	new Zend_Session_Namespace("members");
            $userId		=	$usersNs->userId;

            $pageSize	=   $objModelSetting->settingValue('album_photo_edit_size');

            $page	=   $this->_getParam('page',1);

            $whereAlbum	=   "status=1 AND album_id='{$albumId}'";

            $orderAlbum	=   "addedon DESC";

		$arrAlbum	=	$objPage->fetchPageData($objModelAlbumPhoto, $page, $pageSize, $whereAlbum, $orderAlbum);

		$this->view->numAlbumPhoto  =   $totalCount  =	$objPage->getTotalCount();

		$this->view->arrAlbumPhoto  =	$arrAlbum;

                $this->view->albumId    =   $albumId;

                $this->view->page       =   $page;
        /*-----------------------------------------------------------------------*/
            $arrFriendGroup		=   $objModelFriendGroup->getPermissions();
            $this->view->arrFriendGroup =   $arrFriendGroup;
       /*-----------------------------------------------------------------------*/
            $whereAlbum =   "user_id='{$userId}'";
            $this->view->arrAlbum   =   $objModelAlbum->fetchAll($whereAlbum);
       /*-----------------------------------------------------------------------*/
            $numberOfPage   = ceil($totalCount / $pageSize);

            if($page+1 <= $numberOfPage)
            {
                $this->view->nextPage   =   $nextPage   =   $page+1;
            }else{
                $this->view->nextPage   =   $nextPage   =   'done';
            }
       /*--------------- EDIT PHOTO ----------------------------------------*/
            $request	=	$this->getRequest();	// Get posted value
            if($request->isPost())					// Condition for check form is posted
            {
        	$params         =   $request->getParams();	// Get all posted value

                $numAlbumPhoto  =   $params['numAlbumPhoto'];
                $albumId        =   $params['albumId'];
                $nextPage           =   $params['nextPage'];
                $countVal       =   $params['numAlbumPhoto']-1;
                for($i=1; $i<=$countVal;$i++)
                {
                    $photoId   =    $params['photoId'.$i];
                    $name      =    $params['name'.$i];
                    $caption   =    addslashes($params['caption'.$i]);
                    $location  =    $params['location'.$i];
                    $latLong   =    $params['latLong'.$i];
                    $permission=    $params['permission'.$i];
                    $photoTag  =    $params['photoTag'.$i];
                    $album     =    $params['album'.$i];

                    $arrLatLang		=	explode(",", $latLong);
                    $latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
                    $longitude		=	substr($arrLatLang[1], 0, -1);				//	Latitude of location
                    
                    $valAlbumPhoto  =   $objModelAlbumPhoto->find($photoId);
                    $valAlbumPhoto->setName($name);
                    $valAlbumPhoto->setCaption($caption);
                    $valAlbumPhoto->setLocation($location);
                    $valAlbumPhoto->setPermission($permission);
                    $valAlbumPhoto->setLongitude($longitude);
                    $valAlbumPhoto->setLatitude($latitude);
                    $valAlbumPhoto->setAlbumId($album);

                    $valAlbumPhoto->save();

                    /*---------------------- UPDATE TAGS FOR PHOTO ------------------------------*/
                    $arrTag	=	explode(",", $photoTag);

                    if($photoTag != "Separate Tags by a comma. Example: Holiday, London, Travel")
                    {
                        $whereDeletePhotoTag    =   "photo_id='{$photoId}'";
                        $objModelAlbumPhotoTag->delete($whereDeletePhotoTag);

                              foreach ($arrTag as $tag)
                              {
                                $newTag		=	trim($tag);
                                $whereTag	=	"";
                                $whereTag	=	"tag='{$newTag}'";
                                $arrTags	=	$objModelTags->fetchAll($whereTag);
                                if(count($arrTags) > 0)
                                {
                                        $optionAlbumPhotoTag['photoId']	=	$photoId;
                                        $optionAlbumPhotoTag['tagId']	=	$arrTags[0]->id;
                                        $objModelAlbumPhotoTag->setOptions($optionAlbumPhotoTag);
                                        $objModelAlbumPhotoTag->save();
                                }else{
                                        $optionTag['tag']	=	$newTag;
                                        $objModelTags->setOptions($optionTag);
                                        $id	=	$objModelTags->save();
                                        /*-----------------------------------*/
                                        $optionAlbumPhotoTag['photoId']	=	$photoId;
                                        $optionAlbumPhotoTag['tagId']	=	$id;
                                        $objModelAlbumPhotoTag->setOptions($optionAlbumPhotoTag);
                                        $objModelAlbumPhotoTag->save();
                                }
                            }
                    }
                

                }

                if($nextPage == 'done')
                {
                    $redirectUrl    =   "/album/my-photos/album-photos/id/{$albumId}";
                }else{
                    $redirectUrl    =   "/album/my-photos/review-edit-image/id/{$albumId}/page/{$nextPage}";
                }
                $this->_redirect($redirectUrl);
            }
        }
	
	public function albumPhotosAction()
	{
		$albumId	=	$this->_getParam('id');
		
		$usersNs	=	new Zend_Session_Namespace("members");
		
                $userId		=	$usersNs->userId;
                $this->view->userId	=	$userId;

                $objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
                $objModelAlbum		=	new Album_Model_Album();
                $objModelSetting	=	new Admin_Model_GlobalSettings();
                $objModelVote           =	new Application_Model_Vote();
		$objPage		=	new Base_Paginator();
        /*----------- GET ALBUM WITH PAGINATION VALUE --------------------*/
		$pageSize	=	$objModelSetting->settingValue('album_photo_page_size');
		
		$page		=	$this->_getParam('page',1);
		
		$whereAlbumPhoto	=	"album_id='{$albumId}' AND user_id='{$userId}' AND status=1";
		
		$orderAlbumPhoto	=	"addedon DESC";
		
		$arrAlbumPhoto	=	$objPage->fetchPageData($objModelAlbumPhoto, $page, $pageSize, $whereAlbumPhoto, $orderAlbumPhoto);
		
		$this->view->totalAlbumPhoto	=	$objPage->getTotalCount();
		
		$this->view->arrAlbumPhoto	=	$arrAlbumPhoto;
		/*------------------- GET ALBUM DETAIL --------------------------*/
		$whereAlbum	=	"id='{$albumId}'";
		$arrAlbum	=	$objModelAlbum->fetchAll($whereAlbum);
		$this->view->arrAlbum	=	$arrAlbum;

                $this->view->myLatitude		=	$latitude	=	$arrAlbum[0]->latitude;
		$this->view->myLongitude	=	$longitude	=	$arrAlbum[0]->longitude;
                
		/*------------------- GET TAG OF ALBUM -------------------------*/
		
		$strTag		=	$this->getAlbumTags($albumId);
		
		$this->view->strTag	=	$strTag;
		
		/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/
		$whereVote	=	"item_type='album' AND item_id='{$albumId}' AND user_id='{$userId}' AND vote='1'";
                $arrVote	=	$objModelVote->fetchAll($whereVote);

                if(count($arrVote) > 0){
                        $this->view->numVote	=	1;
                }else{
                        $this->view->numVote	=	0;
                }		
	}
	
	public function albumEditAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelFriendGroup	=	new Application_Model_FriendGroup();
		$objModelAlbum			=	new Album_Model_Album();
		$objModelAlbumTag		=	new Album_Model_AlbumTag();
		$objModelTags			=	new Application_Model_Tags();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$albumId	=	$arrPostVal['albumId'];
		
		$valAlbum	=	$objModelAlbum->find($albumId);
		
		$this->view->name			=	$valAlbum->getName();
		$this->view->description	=	stripslashes($valAlbum->getDescription());
		$this->view->location		=	$valAlbum->getLocation();
		$this->view->permission		=	$valAlbum->getPermission();
		/*--------------------- ALL PERMISSION ----------------------------*/
        $arrFriendGroup				=	$objModelFriendGroup->getPermissions();
        $this->view->arrFriendGroup	=	$arrFriendGroup;
        /*-------------------- GETTING TAGS -------------------------------*/
       	$this->view->albumTag	=   $albumTag	=	$this->getAlbumTags($albumId);
        $this->view->albumId    =   $albumId;
	}
	
	public function likeAlbumAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$usersNs	=	new Zend_Session_Namespace("members");
		
		$item_id	=	$arrPostVal['album_id'];		
		$item_type	=	$arrPostVal['item_type'];

		$id =	$this->like($item_id, $item_type);
	}
	
	public function likeAlbumCommentAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$objModelVote	=	new Application_Model_Vote();
		
		$commentId	=	$arrPostVal['commentId'];
		$item_type	=	$arrPostVal['item_type'];				
       
                $id =	$this->like($commentId, $item_type);
	        
	        $this->view->commentId	=	$commentId;
	        /*-------- GET NUMBER OF VOTE -----------*/
	        $numVotes	=	$objModelVote->numVotes($item_type, $commentId);
	        $this->view->numVotes	=	$numVotes;
	        $this->view->item_type	=	$item_type;
	}
	
	public function likePhotoAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$item_id	=	$arrPostVal['photo_id'];		
		$item_type	=	$arrPostVal['item_type'];
        
                $id =	$this->like($item_id, $item_type);
	}
	
	public function unlikeAlbumAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$item_id	=	$arrPostVal['album_id'];
		$item_type	=	$arrPostVal['item_type'];			
        
                $this->unlike($item_id, $item_type);
        }
     
	public function unlikePhotoAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$item_id	=	$arrPostVal['photo_id'];
		$item_type	=	$arrPostVal['item_type'];
        
        $this->unlike($item_id, $item_type);
     }
     
	public function unlikeAlbumCommentAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelVote	=	new Application_Model_Vote();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$commentId	=	$arrPostVal['commentId'];
		$item_type	=	$arrPostVal['item_type'];
        
         $this->unlike($commentId, $item_type);
        
        $this->view->commentId	=	$commentId;
         /*-------- GET NUMBER OF VOTE -----------*/
	        $numVotes	=	$objModelVote->numVotes($item_type, $commentId);
	        $this->view->numVotes	=	$numVotes;
     }
     
     
	
	public function loadAlbumCommentAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$usersNs	=	new Zend_Session_Namespace("members");
		
		$item_id	=	$arrPostVal['album_id'];
		$item_type	=	$arrPostVal['item_type'];	
		$item_type1	=	$arrPostVal['item_type1'];
        $userId		=	$usersNs->userId;
        $this->view->userId	=	$userId;
        
        /*------------ FETCH ALL THE COMMENT --------------------*/
      	$arrComment	=	$this->getAllAlbumComment($item_id, $item_type1);
      	$this->view->arrComment	=	$arrComment;
        /*-------------------------------------------------------*/
      	$this->view->item_type	=	$item_type;
      	$this->view->item_type1	=	$item_type1;
        
	}
	
	public function albumPhotoCommentAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelComment	=	new Application_Model_Comment();
		$objModelUser		=	new Application_Model_User();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$usersNs	=	new Zend_Session_Namespace("members");
		$userFullName	=	$usersNs->userFullName;
		
		$item_id	=	$arrPostVal['item_id'];
		$comment	=	$arrPostVal['comment'];
		$item_type	=	$arrPostVal['item_type'];				
        $userId		=	$usersNs->userId;
        
        $option['comment']		=	addslashes(strip_tags($comment));
        $option['parentId']		=	0;
        $option['itemType']		=	$item_type;
        $option['itemId']		=	$item_id;
        $option['addedon']		=	time();
        $option['updatedon']	=	time();
        $option['userId']		=	$userId;
        $option['publish']		=	1;
      
        $objModelComment->setOptions($option);
        $commentId	=	$objModelComment->save();
        /*-------------------------------------------------*/
        $valUser	=	$objModelUser->find($userId);
        $this->view->userImage		=	$valUser->getImage();
        $this->view->userFullName	=	$userFullName;
        $this->view->comment		=	nl2br(strip_tags($comment));
        $this->view->commentId		=	$commentId;
	}
	
	public function removeCommentAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$objModelComment=	new Application_Model_Comment();
		$objModelVote	=	new Application_Model_Vote();
		
		$albumCommentId	=	$arrPostVal['albumCommentId'];
		
		$whereComment	=	"id='{$albumCommentId}'";
		$whereVote		=	"item_id='{$albumCommentId}' AND item_type='photo_comment'";
		
		$objModelComment->delete($whereComment);
		$objModelVote->delete($whereVote);
		exit;
	}
	
	public function photoAction()
	{
		$photoId	=	$this->_getParam('id');
		
		$this->getPhotoInfo($photoId);		
	}

        public function taggedPhotoAction()
        {
            $photoId	=	$this->_getParam('id');

            $this->getTaggesPhotoInfo($photoId);
        }
	
	public function photoSlideAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$photoId	=	$arrPostVal['photoId'];
		
		$this->getPhotoInfo($photoId);
		
	}

        public function photoSlideTaggedAction()
	{
		$this->_helper->layout()->disableLayout();

		$arrPostVal	=	$this->getRequest()->getParams();

		$photoId	=	$arrPostVal['photoId'];

		$this->getTaggesPhotoInfo($photoId);

	}
	
	public function photoDownloadAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$photoName	=	$this->_getParam('name');
		$photoPath	=	PUBLIC_PATH."/images/album/custom/".$photoName;
		
		Base_Uploadease::downloadFiles($photoPath);
		
		exit;
	}
	
	public function albumPhotoEditAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelFriendGroup	=   new Application_Model_FriendGroup();
		$objModelAlbum		=   new Album_Model_Album();
                $objModelAlbumPhoto     =   new Album_Model_AlbumPhoto();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$photoId	=	$arrPostVal['photoId'];
		
		$this->getPhotoInfo($photoId);
		
		/*----------- GET ALL PERMISSION --------------*/
        $arrFriendGroup			=	$objModelFriendGroup->getPermissions();
        $this->view->arrFriendGroup=$arrFriendGroup;
		/*----------- GET ALBUM TAG ------------------*/
        $this->view->albumPhotoTag	=	$albumPhotoTag	=	$objModelAlbumPhoto->getAlbumPhotoTags($photoId);
        
        $this->view->current_photo_id	=	$photoId;
        /*----------- GET ALL MY ALBUM ---------------*/
        $usersNs	=	new Zend_Session_Namespace("members");			
        $userId		=	$usersNs->userId;
        
        $whereAlbum		=	"user_id='{$userId}' AND status='1'";
        $arrAlbumInfo	=	$objModelAlbum->fetchAll($whereAlbum);
        $arrAlbum		=	array();
        
        foreach ($arrAlbumInfo as $album){
        	$arrAlbum[$album->id]	=	$album->name;	
        }
        
        $this->view->arrAlbum	=	$arrAlbum;
        
	}
	
	public function albumPhotoEditSubmitAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelAlbumPhotoTag	=	new Album_Model_AlbumPhotoTag();
		$objModelAlbumPhoto		=	new Album_Model_AlbumPhoto();
		$objModelTags			=	new Application_Model_Tags();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$photoId			=		$arrPostVal['photoId'];
		$albumId			=		$arrPostVal['albumId'];
		$name				=		$arrPostVal['name'];
		$caption			=		$arrPostVal['caption'];
		$location			=		$arrPostVal['location'];
		$permissions		=		$arrPostVal['permissions'];
		$tags				=		$arrPostVal['tags'];
		
		$valAlbumPhoto		=		$objModelAlbumPhoto->find($photoId);
		$valAlbumPhoto->setId($photoId);
		$valAlbumPhoto->setAlbumId($albumId);
		$valAlbumPhoto->setName($name);
		$valAlbumPhoto->setCaption($caption);
		$valAlbumPhoto->setLocation($location);
		$valAlbumPhoto->setPermission($permissions);
		$valAlbumPhoto->save();
		/*------------------- REMOVE OLD TAG ---------------------*/
			$whereAlbumPhotoTag		=	"photo_id='{$photoId}'";
			$objModelAlbumPhotoTag->delete($whereAlbumPhotoTag);
		/*--------------------- PHOTO TAG ---------------------*/
		$arrTag	=	explode(",", $tags);
		foreach ($arrTag as $tag){
			$newTag		=	trim($tag);
			$whereTag	=	"";
			$whereTag	=	"tag='{$newTag}'";
			$arrTags	=	$objModelTags->fetchAll($whereTag);
			if(count($arrTags) > 0)
			{
				$optionAlbumPhotoTag['photoId']	=	$photoId;
				$optionAlbumPhotoTag['tagId']	=	$arrTags[0]->id;
				$objModelAlbumPhotoTag->setOptions($optionAlbumPhotoTag);
				$objModelAlbumPhotoTag->save();
				
			}else{
				$optionTag['tag']	=	$newTag;
				$objModelTags->setOptions($optionTag);
				$id	=	$objModelTags->save();
				/*-----------------------------------*/
				$optionAlbumPhotoTag['photoId']	=	$photoId;
				$optionAlbumPhotoTag['tagId']	=	$id;
				$objModelAlbumPhotoTag->setOptions($optionAlbumPhotoTag);
				$objModelAlbumPhotoTag->save();
				
			}
		}
		
		exit;
	}
	
	public function albumPhotoDeleteAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelAlbumPhotoTag          =	new Album_Model_AlbumPhotoTag();
		$objModelAlbumPhoto		=	new Album_Model_AlbumPhoto();
		$objModelVote			=	new Application_Model_Vote();
		$objModelComment		=	new Application_Model_Comment();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
                $photoId	=	$arrPostVal['photoId'];

                $albumId    =   (!empty($arrPostVal['id']))?$arrPostVal['id']:"";
                $page       =   (!empty($arrPostVal['page']))?$arrPostVal['page']:"";

                /*----------------- GET PHOTO NAME --------------------------------*/
                $valPhoto   =   $objModelAlbumPhoto->find($photoId);
                $photoName  =   $valPhoto->getName();
                /*----------------- REMOVE PHOTO DETAIL ---------------------------*/
		
		$whereAlbumPhotoTag	=	"photo_id='{$photoId}'";
		$whereComment		=	"item_type='photo_comment' AND item_id='{$photoId}'";
		$whereVote		=	"item_type='album_photo' AND item_id='{$photoId}'";
		$whereAlbumPhoto	=	"id='{$photoId}'";
		
		$objModelAlbumPhotoTag->delete($whereAlbumPhotoTag);
		$objModelComment->delete($whereComment);
		$objModelVote->delete($whereVote);
		$objModelAlbumPhoto->delete($whereAlbumPhoto);

                /*---------------------- REMOVE PHOTO FROM FILE --------------------------------*/
                    unlink(PUBLIC_PATH."/images/album/thumb/$photoName");   // Remove thumb image
                    unlink(PUBLIC_PATH."/images/album/custom/$photoName");  // Remove resized image
                    unlink(PUBLIC_PATH."/images/album/default/$photoName"); // Remove default image
                /*------------------------------------------------------------------------------*/

                if($albumId != "" && $page != "")   //Condition for Detele photo on Review and Edit time after creating album
                {
                    header("location:/album/my-photos/review-edit-image/id/$albumId/page/$page");
                }
		
		exit;
	}
	
	public function albumPhotoDeleteConfirmAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$this->view->nextId	=	$this->_getParam('nextId');
		
	}
	
	public function albumPhotoLocationUpdateAction()
	{
		$this->_helper->layout()->disableLayout();
		
		$objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
		
		$arrPostVal	=	$this->getRequest()->getParams();
		
		$photoId	=	$arrPostVal['photoId'];
		$address	=	$arrPostVal['address'];
		$latlang	=	$arrPostVal['latlang'];
		
		$arrLatLang		=	explode(",", $latlang);
		$latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
		$longitude		=	substr($arrLatLang[1], 0, -1);				//	Latitude of location
		
		$valAlbumPhoto	=	$objModelAlbumPhoto->find($photoId);
		$valAlbumPhoto->setLatitude($latitude);
		$valAlbumPhoto->setLongitude($longitude);
		$valAlbumPhoto->setLocation($address);
		$valAlbumPhoto->save();
				
		exit;
		
	}

        public function albumAlbumLocationUpdateAction()
	{
		$this->_helper->layout()->disableLayout();

		$objModelAlbum	=	new Album_Model_Album();

		$arrPostVal	=	$this->getRequest()->getParams();

		$albumId	=	$arrPostVal['albumId'];
		$address	=	$arrPostVal['address'];
		$latlang	=	$arrPostVal['latlang'];

		$arrLatLang		=	explode(",", $latlang);
		$latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
		$longitude		=	substr($arrLatLang[1], 0, -1);						//	Latitude of location

		$valAlbum	=	$objModelAlbum->find($albumId);
		$valAlbum->setLatitude($latitude);
		$valAlbum->setLongitude($longitude);
		$valAlbum->setLocation($address);
		$valAlbum->save();

		exit;

	}

        public function getMyAllFriendAction()
        {
            $this->_helper->layout()->disableLayout();

            $friendM	= new Application_Model_Friend();
            
            $userNs = new Zend_Session_Namespace("members");

            $arrPostVal	=	$this->getRequest()->getParams();

            $tagName	=	!(empty($arrPostVal['tagName']))?$arrPostVal['tagName']:"";

            if($tagName != ""){
                $where  =   "fr.user_id='".$userNs->userId."' AND (ur.first_name LIKE('%{$tagName}%') OR ur.last_name LIKE('%{$tagName}%'))";
            }else{
                $where  =   "fr.user_id='".$userNs->userId."'";
            }
            /*-------------------------------------------------------------------*/
            $db = Zend_Registry::get('db');
          		
            $select = $db->select()
            ->from(array("fr" => "friend"),array("fr.friend_id"))
            ->join(array("ur" => "user"),"fr.friend_id=ur.id",array("ur.first_name","ur.last_name"))
            ->where($where);

            $stmt = $db->query($select);

            $this->view->arrFriend	=	$stmt->fetchAll();
            $this->view->loggedInUserId =       $userNs->userId;
            $this->view->userFullName   =       $userNs->userFullName;
            /*-------------------------------------------------------------------*/
        }
	
	public function getAlbumTags($albumId)
	{
		$objModelAlbumTag	=	new Album_Model_AlbumTag(); 
		$objModelTag		=	new Application_Model_Tags();
		
		$whereAlbumTag	=	"album_id='{$albumId}'";
		$arrTagId	=	$objModelAlbumTag->fetchAll($whereAlbumTag);
		
		$strTag	=	"";
		if(!empty($arrTagId))
		{			
			foreach($arrTagId as $tagId)
			{
				$tId	=	$tagId->tagId;
				$whereTag	=	"id='{$tId}'";
				$arrTag	=	$objModelTag->fetchRow($whereTag);

				$strTag	=	$strTag.','.$arrTag->tag;
			}
			$strTag	=	substr($strTag, 1, strlen($strTag));
		}
		return $strTag;		
	}
	
	

        public function captureTaggingAction()
        {
             $this->_helper->layout()->disableLayout();

             $arrPostVal	=	$this->getRequest()->getParams();

             $userNs = new Zend_Session_Namespace("members");

             $objModelPhotoTag  =   new Album_Model_PhotoTag();

             $flag      =   $arrPostVal['flag'];

             if($flag == 1)
             {
                    $option['taggedId'] =   $arrPostVal['tagValue'];
                    $option['keyword']   =   '';
             }else{
                    $option['keyword']   =    $arrPostVal['tagValue'];
                    $option['taggedId'] =   0;
             }

                $option['userId']  =   $userNs->userId;
                $option['photoId'] =   $arrPostVal['photoId'];
                $option['photoTag']=   addslashes($arrPostVal['photoTag']);
                $option['htmlTag'] =   addslashes($arrPostVal['htmlTag']);
                $option['counter'] =   $arrPostVal['counter'];

                $objModelPhotoTag->setOptions($option);
                $id = $objModelPhotoTag->save();
                echo $id;

             exit;
        }

        public function removeTaggingAction()
        {
             $this->_helper->layout()->disableLayout();

             $objModelPhotoTag  =   new Album_Model_PhotoTag();

             $arrPostVal    =   $this->getRequest()->getParams();
             $userNs        =   new Zend_Session_Namespace("members");

             $photoId   =   $arrPostVal['photoId'];
             $counter   =   $arrPostVal['counter'];
             $userId    =   $userNs->userId;

             $where =   "photo_id='{$photoId}' AND user_id='{$userId}' AND counter='{$counter}'";
             $objModelPhotoTag->delete($where);

             exit;
        }

        public function loadTaggingAction()
        {
            $this->_helper->layout()->disableLayout();

            $objModelPhotoTag  =   new Album_Model_PhotoTag();

            $arrPostVal	=   $this->getRequest()->getParams();

            $photoId    =   $arrPostVal['photoId'];

            $wherePhotoTagging= "photo_id='{$photoId}'";

            $arrPhotoTagging    =   $objModelPhotoTag->fetchAll($wherePhotoTagging);

            $strTagging = "";

            foreach($arrPhotoTagging as $tagging)
            {
                $strTagging .= stripslashes($tagging->photoTag);
            }
            echo $strTagging;
            exit;
        }

        public function loadTaggingTagAction()
        {
            $this->_helper->layout()->disableLayout();

            $objModelPhotoTag  =   new Album_Model_PhotoTag();

            $arrPostVal	=   $this->getRequest()->getParams();

            $photoId    =   $arrPostVal['photoId'];

            $wherePhotoTagging= "photo_id='{$photoId}'";

            $arrPhotoTagging    =   $objModelPhotoTag->fetchAll($wherePhotoTagging);

            $strTagging = "";

            foreach($arrPhotoTagging as $tagging)
            {
                $strTagging .= stripslashes($tagging->htmlTag);
            }
            echo $strTagging;
            exit;
        }
	
	public function getAllAlbumComment($albumId, $item_type)
	{
		$objModelComment	=	new Application_Model_Comment();
		$objModelUser		=	new Application_Model_User();
		
		$arrAllComment	=	array();
		
		$whereComment	=	"parent_id='0' AND item_type='{$item_type}' AND item_id='{$albumId}' AND publish='1'";
        $orderComment	=	"addedon DESC"; 
        $arrComment		=	$objModelComment->fetchAll($whereComment, $orderComment);
        
        $i=0;
        foreach ($arrComment as $com){
        	
        	$userId		=	$com->userId;
        	
        	$valUser	=	$objModelUser->find($userId);

        	$arrAllComment[$i]['commenterName']	=	$valUser->getFirstName().' '.$valUser->getLastName();
        	$arrAllComment[$i]['imageName']		=	$valUser->getImage();
        	$arrAllComment[$i]['comment']		=	nl2br(stripslashes($com->comment));
        	$arrAllComment[$i]['commentId']		=	stripslashes($com->id);
        	$arrAllComment[$i]['addedon']		=	date("D, M j, Y", $com->addedon);
        	
        	$i++;
        }
        
        return $arrAllComment;
	}
	
	public function albumPhotoLocationMapAction()
	{
		//$this->_helper->layout()->disableLayout();
		$this->_helper->layout->setLayout('map');
		$objModelPhotoAlbum	=	new Album_Model_AlbumPhoto();
		
		//$arrPostVal	=	$this->getRequest()->getParams();
		
		//$photoId	=	$arrPostVal['photoId'];	
		$photoId	=	$this->_getParam('photoId');
		$this->view->photoId	=	$photoId;	
		
		$valAlbumPhoto	=	$objModelPhotoAlbum->find($photoId);
		
		$location	=	$valAlbumPhoto->getLocation();
		$longitude	=	$valAlbumPhoto->getLongitude();
		$latitude	=	$valAlbumPhoto->getLatitude();
		
		
	}

        public function albumEditSubmitAction()
        {
            $this->_helper->layout()->disableLayout();

            $arrPostVal     =	$this->getRequest()->getParams();

            $objModelAlbum  =   new Album_Model_Album();
            $objModelTags   =   new Application_Model_Tags();
            $objModelAlbumTag=  new Album_Model_AlbumTag();

            $name              =    addslashes(strip_tags($arrPostVal['name']));
            $description       =    addslashes(strip_tags($arrPostVal['description']));
            $location          =    $arrPostVal['location'];
            $permission        =    $arrPostVal['permissions'];
            $tags              =    $arrPostVal['tags'];
            $albumId           =    $arrPostVal['albumId'];
            $latlang           =   $arrPostVal['latlang'];

            $arrLatLang		=	explode(",", $latlang);
            $latitude		=	substr($arrLatLang[0], 1, strlen($arrLatLang[0]));	// Longitude of location
            $longitude		=	substr($arrLatLang[1], 0, -1);

            $valAlbum   =   $objModelAlbum->find($albumId);
            $valAlbum->setName($name);
            $valAlbum->setDescription($description);
            $valAlbum->setLocation($location);
            $valAlbum->setPermission($permission);
            $valAlbum->setLatitude($latitude);
            $valAlbum->setLongitude($longitude);
            $valAlbum->save();
           /*--------------------- ALBUM TAG ---------------------*/
		$arrTag	=	explode(",", $tags);

                $objModelAlbumTag->delete("album_id='{$albumId}'");

		foreach ($arrTag as $tag)
                {
			$newTag		=	trim($tag);
			$whereTag	=	"";
			$whereTag	=	"tag='{$newTag}'";
			$arrTags	=	$objModelTags->fetchAll($whereTag);
			if(count($arrTags) > 0)
			{
				$optionAlbumTag['albumId']	=	$albumId;
				$optionAlbumTag['tagId']	=	$arrTags[0]->id;
				$objModelAlbumTag->setOptions($optionAlbumTag);
				$objModelAlbumTag->save();
			}else{
				$optionTag['tag']	=	$newTag;
				$objModelTags->setOptions($optionTag);
				$id	=	$objModelTags->save();
				/*-----------------------------------*/
				$optionAlbumTag['albumId']	=	$albumId;
				$optionAlbumTag['tagId']	=	$id;
				$objModelAlbumTag->setOptions($optionAlbumTag);
				$objModelAlbumTag->save();
			}
            }

            exit;
        }
	
	public function getImageSize($option)
	{
		$arrImageSize	=	array();
		
		switch ($option) 
		{
		    case 'small':
		        $arrImageSize['width']	=	300;
				$arrImageSize['height']	=	250;
		        break;
		    case 'medium':
		        $arrImageSize['width']	=	591;
				$arrImageSize['height']	=	443;
		        break;
		    case 'high':
		        list($width, $height) 	= 	getimagesize($targetPath); 
				$arrImageSize['width']	=	(int)$width;
				$arrImageSize['height']	=	(int)$height;
		        break;
		}
		return $arrImageSize;
	}
	
	public function getPhotoInfo($photoId)
	{
		$objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
		$objModelVote		=	new Application_Model_Vote();
		
		$arrPhotoIds	=	array();
		
		$valAlbumPhoto	=	$objModelAlbumPhoto->find($photoId);
		
		$this->view->photo		=	$valAlbumPhoto->getImage();
		$this->view->name		=	$valAlbumPhoto->getName();
		$this->view->caption	=	stripslashes($valAlbumPhoto->getCaption());
		$this->view->location	=	$valAlbumPhoto->getLocation();
		$this->view->permission	=	$valAlbumPhoto->getPermission();
		
		$albumId	=	$valAlbumPhoto->getAlbumId();
		
		$this->view->myLatitude		=	$latitude	=	$valAlbumPhoto->getLatitude();
		$this->view->myLongitude	=	$longitude	=	$valAlbumPhoto->getLongitude();
		
		$this->getAlbumInfo($albumId);	// Get album info
		
		$this->view->albumId	=	$albumId;
		
		$this->view->photoId	=	$photoId;
		
	/*-----------------------------------------------------------------------*/
		
		$whereAlbumPhoto	=	"album_id='{$albumId}' AND status='1'";
		$orderAlbumPhoto	=	"addedon DESC";
		
		$arrAlbumPhoto		=	$objModelAlbumPhoto->fetchAll($whereAlbumPhoto, $orderAlbumPhoto);
		
		foreach ($arrAlbumPhoto as $photo)
		{
			$arrPhotoIds[]	=	$photo->id;
		}
		
		$position = array_search($photoId, $arrPhotoIds);
		
		$nextPosition	=	$position+1;
		$prevPosition	=	$position-1;
		$arrSize		=	count($arrPhotoIds);
		
		$this->view->photoPosition	=	$nextPosition;
		
		$this->view->numPhotoAlbum	=	$arrSize;
		
		if(array_key_exists($nextPosition, $arrPhotoIds))
		{
			$this->view->nextId	=	$arrPhotoIds[$nextPosition];
		}else{
			$this->view->nextId	=	$arrPhotoIds[0];
		}
		
		if(array_key_exists($prevPosition, $arrPhotoIds))
		{
			$this->view->prevId	=	$arrPhotoIds[$prevPosition];
		}else{
			$this->view->prevId	=	$arrPhotoIds[$arrSize-1];
		}
		
	/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/
		$usersNs	=	new Zend_Session_Namespace("members");
		$userId		=	$usersNs->userId;
		
		$whereVote	=	"item_type='album_photo' AND item_id='{$photoId}' AND user_id='{$userId}' AND vote='1'";
            $arrVote	=	$objModelVote->fetchAll($whereVote);
            if(count($arrVote) > 0){
                    $this->view->numVote	=	1;
            }else{
                    $this->view->numVote	=	0;
            }
	}

        public function getTaggesPhotoInfo($photoId)
	{
		$objModelAlbumPhoto	=	new Album_Model_AlbumPhoto();
		$objModelVote		=	new Application_Model_Vote();

                $usersNs	=	new Zend_Session_Namespace("members");
		$userId		=	$usersNs->userId;
                $userFullName	=	$usersNs->userFullName;

		$arrPhotoIds	=	array();

		$valAlbumPhoto	=	$objModelAlbumPhoto->find($photoId);

		$this->view->photo	=	$valAlbumPhoto->getImage();
		$this->view->name	=	$valAlbumPhoto->getName();
		$this->view->caption	=	stripslashes($valAlbumPhoto->getCaption());
		$this->view->location	=	$valAlbumPhoto->getLocation();
		$this->view->permission	=	$valAlbumPhoto->getPermission();

		$albumId	=	$valAlbumPhoto->getAlbumId();

		$this->view->myLatitude		=	$latitude	=	$valAlbumPhoto->getLatitude();
		$this->view->myLongitude	=	$longitude	=	$valAlbumPhoto->getLongitude();

		$this->getAlbumInfo($albumId);	// Get album info

		$this->view->albumId	=	$albumId;

		$this->view->photoId	=	$photoId;
	/*-----------------------------------------------------------------------*/

                $db = Zend_Registry::get('db');

                $where="tagged_id='{$userId}'";
                
                $query  =   $db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image","ap.id"))
                ->where($where)
                ->order(array('pt.created DESC'));

                $recordSet  =   $db->query($query);
                $arrRecord  =   $recordSet->fetchAll();
                $this->view->numRecord = $numRecord=count($arrRecord);

                foreach ($arrRecord as $photo)
		{
			$arrPhotoIds[]	=	$photo->id;
		}

                $position = array_search($photoId, $arrPhotoIds);

                $nextPosition	=	$position+1;
		$prevPosition	=	$position-1;
                $arrSize	=	count($arrPhotoIds);

                $this->view->photoPosition	=	$nextPosition;

		$this->view->numPhotoAlbum	=	$arrSize;

                if(array_key_exists($nextPosition, $arrPhotoIds))
		{
			$this->view->nextId	=	$arrPhotoIds[$nextPosition];
		}else{
			$this->view->nextId	=	$arrPhotoIds[0];
		}

		if(array_key_exists($prevPosition, $arrPhotoIds))
		{
			$this->view->prevId	=	$arrPhotoIds[$prevPosition];
		}else{
			$this->view->prevId	=	$arrPhotoIds[$arrSize-1];
		}
        /*--------------------------------------------------------------------------*/
	/*	$whereAlbumPhoto	=	"album_id='{$albumId}' AND status='1'";
		$orderAlbumPhoto	=	"addedon DESC";

		$arrAlbumPhoto		=	$objModelAlbumPhoto->fetchAll($whereAlbumPhoto, $orderAlbumPhoto);

		foreach ($arrAlbumPhoto as $photo)
		{
			$arrPhotoIds[]	=	$photo->id;
		}

		$position = array_search($photoId, $arrPhotoIds);

		$nextPosition	=	$position+1;
		$prevPosition	=	$position-1;
		$arrSize		=	count($arrPhotoIds);

		$this->view->photoPosition	=	$nextPosition;

		$this->view->numPhotoAlbum	=	$arrSize;

		if(array_key_exists($nextPosition, $arrPhotoIds))
		{
			$this->view->nextId	=	$arrPhotoIds[$nextPosition];
		}else{
			$this->view->nextId	=	$arrPhotoIds[0];
		}

		if(array_key_exists($prevPosition, $arrPhotoIds))
		{
			$this->view->prevId	=	$arrPhotoIds[$prevPosition];
		}else{
			$this->view->prevId	=	$arrPhotoIds[$arrSize-1];
		}
*/
	/*------------------ CHECK LIKED-UNLIKED ALBUM ------------------*/
                $this->view->userFullName=$userFullName;

		$whereVote	=	"item_type='album_photo' AND item_id='{$photoId}' AND user_id='{$userId}' AND vote='1'";
                $arrVote	=	$objModelVote->fetchAll($whereVote);
            if(count($arrVote) > 0){
                    $this->view->numVote	=	1;
            }else{
                    $this->view->numVote	=	0;
            }
	}
	
	public function getAlbumInfo($albumId)
	{
		$objModelAlbum	=	new Album_Model_Album();
		
		$valAlbum	=	$objModelAlbum->find($albumId);
		
		$albumName	=	$valAlbum->getName();
		$albumDesc	=	$valAlbum->getDescription();
		
		$this->view->albumName	=	$albumName;
		$this->view->description=	stripslashes($albumDesc);
	}
	
	function like($item_id, $item_type)
	{
		$objModelVote	=	new Application_Model_Vote();
		
		$usersNs	=	new Zend_Session_Namespace("members");
			
        $userId		=	$usersNs->userId;
        
        $whereVote	=	"item_type='{$item_type}' AND item_id='{$item_id}' AND user_id='{$userId}'";
        $arrVote	=	$objModelVote->fetchAll($whereVote);
       
        if(count($arrVote) > 0)
        {
        	$option['id']		=	$arrVote[0]->id;
        }
        	$option['vote']		=	1;
	        $option['itemType']	=	$item_type;
	        $option['itemId']	=	$item_id;
	        $option['addedon']	=	time();
	        $option['updatedon']=	time();
	        $option['userId']	=	$userId;         
        	$objModelVote->setOptions($option);
	        $id	=	$objModelVote->save();
	        return $id; 
	}
	
	function unlike($item_id, $item_type)
	{
		$objModelVote	=	new Application_Model_Vote();
		
		$usersNs	=	new Zend_Session_Namespace("members");
		
        $userId		=	$usersNs->userId;
        
        $whereVote	=	"item_type='{$item_type}' AND item_id='{$item_id}' AND user_id='{$userId}'";
        $arrVote	=	$objModelVote->fetchAll($whereVote);
        
		if(count($arrVote) > 0)
        {
        	$option['id']		=	$arrVote[0]->id;
        }
        
        $option['vote']		=	-1;
        $option['itemType']	=	$item_type;
        $option['itemId']	=	$item_id;
        $option['addedon']	=	time();
        $option['updatedon']=	time();
        $option['userId']	=	$userId;
        
        $objModelVote->setOptions($option);
        $id	=	$objModelVote->save();
        
        return $id;
	}
	
	public function getAlbum()
	{
		
	}

        public function getTaggedImageOfUser($userId)
        {
            $tag_page   =   $this->_getParam('tag_tage',1);
            $limit      =   12;
            $offset     =   $tag_page*$limit-$limit;

            $db = Zend_Registry::get('db');
                $where="tagged_id='{$userId}'";
                // Joining photo_tag, album_photo
                $select = $db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image"))
                ->where($where)
                ->order(array('created DESC'))
                ->limit($limit, $offset);

                $stmt = $db->query($select);

                $this->view->arrTaggedUser  =   $stmt->fetchAll();
                /*------------------------------------------------*/
                $query=$db->select()
                ->from(array("pt" => "photo_tag"),array("pt.photo_id"))
                ->join(array("ap" => "album_photo"),"pt.photo_id=ap.id",array("ap.image"))
                ->where($where);

                $recordSet = $db->query($query);
                $arrRecord=$recordSet->fetchAll();
                $this->view->numRecord=$numRecord=count($arrRecord);
                /*------------------------------------------------*/
                $this->view->numPages   =   $numPages   =  ceil($numRecord/$limit);

                $nextPage   =   $tag_page+1;
                $prevPage   =   $tag_page-1;

                if($nextPage > $numPages){
                    $nextLink   =   "&gt;";
                }else{
                    $nextLink   =   "<a href='/album/my-photos/index/tag_tage/{$nextPage}'>&gt;</a>";
                }

                if($prevPage < 1){
                    $prevLink   =   "&lt;";
                }else{
                    $prevLink   =   "<a href='/album/my-photos/index/tag_tage/{$prevPage}'>&lt;</a>";
                }

                $pagingStr  =   "<span class='pages'>Page $tag_page of $numPages <span> $prevLink $nextLink </span></span>";

               // "";

                $this->view->pagingStr  =   $pagingStr;
                
        }
	
	
		
}









