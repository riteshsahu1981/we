<?php
class ImageController extends Base_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    	/*$uri=$this->_request->getPathInfo();
		$activeNav=$this->view->navigation()->findByUri($uri);
		$activeNav->active=true;    	*/
    }
	public function preDispatch()
	{
		parent::preDispatch();
		
		//$this->_helper->layout->disableLayout();
    	//$this->_helper->viewRenderer->setNoRender(true);
		//$this->_helper->layout->setLayout('advice-layout-2column');
	}
	
	//function is used to display resized image on browser
    public function indexAction()
    {
		$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
		
		$width		=	$this->_getParam('w');
    	$height		=	$this->_getParam('h');
		$old_image	=	$this->_getParam('src');
		$size		=	$this->_getParam('size');
    	
		//set Width/Height as per size
		if(isset($size) && $size!="")
		{
			if($size == "request_right")
			{
				$width = 50;
				$height = 50;
			}
			else if($size == "journal")
			{
				$width = 60;
				$height = 70;
			}
			else if($size == "comment")
			{
				$width = 37;
				$height = 43;
			}
			else if($size == "friends")
			{
				$width = 85;
				$height = 90;
			}
			else if($size == "profile_left")
			{
				$width = 60;
				$height = 70;
			}
			else if($size == "city")
			{
				$width = 625;
				$height = 347;
			}
			else if($size == "country")
			{
				$width = 625;
				$height = 330;
			}
			else
			{
				$width = 40;
				$height = 40;
			}
		}
		//set new image
		//$namePartsArr	= explode('.', $old_image);
		//$file_ext		= $namePartsArr[count($namePartsArr) - 1];
		//$new_image		= "thumb-".time().".".$file_ext;
		$new_image		= "thumb-".time().".jpg";

		$image	= new Base_Image_ThumbImageClass($old_image);
		
		$imgStr = $image->resize($width, $height);
		//var_dump($imgStr);
		
		if($imgStr!==false)
		{
			$image->save($new_image);
		}
		else
		{
			//echo "No image found";
		}
	}//end of function
	
	public function albumUploadPhotoAction()
	{
		
		$this->_helper->layout()->disableLayout();

		$albumId	=	$this->_getParam('album_id');   // For uploade photo on edit time of Album
		$this->view->albumId    =   $albumId;                   // For uploade photo on edit time of Album

		$review_edit	=	$this->_getParam('review_edit');   // For uploade photo on Album create time
		$this->view->review_edit    =   $review_edit;               // For uploade photo on Album create time
		
		$objModelAlbum	=	new Album_Model_Album();
		
		$usersNs	=	new Zend_Session_Namespace("members");
        $userId		=	$usersNs->userId;
		/*---------------------- GET USED PHOTO SIZE OF USER --------------------------*/
		$arrAlbumCapacity = $objModelAlbum->albumCapacity($userId);
		$this->view->capacityImage	=	$arrAlbumCapacity[0];
		$this->view->capacityPercent=	$arrAlbumCapacity[1];
		
		$whereAlbum	=	"status=1 AND user_id='{$userId}'";
		
		$orderAlbum	=	"addedon DESC";
		
		$arrAlbum	=	$objModelAlbum->fetchAll($whereAlbum, $orderAlbum);
		
		$this->view->arrAlbum	=	$arrAlbum;
		/*---------------------------------------------------------------------*/
		 // no output before this declaration
        $form = new Album_Form_Upload();
        if ($this->getRequest()->isPost()) 
        {
            if ($form->isValid($this->getRequest()->getParams())) 
            {
                if (method_exists($form->getElement('file'), 'isUploadify')) 
                {
                    if (! $form->getElement('file')->isUploadify()) 
                    {
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
                    
                }else{
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
}//end of class
