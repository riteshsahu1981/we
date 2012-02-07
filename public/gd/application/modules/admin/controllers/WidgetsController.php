<?php
class Admin_WidgetsController extends Base_Controller_Action {
	
	public function indexAction()
	{
		$settings	= new Admin_Model_GlobalSettings();
		$page_size	= $settings->settingValue('pagination_size');
		
		$model		=	new Application_Model_Widgets();
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
	
	public function addAction()
	{
		$request = $this->getRequest();
		$form = new Admin_Form_HomeSlide();
		
		//set default options
		$form->getElement('widgetType')->setValue("image");
		$form->getElement('widgetLinkTarget')->setValue("_self");
		$form->getElement('weight')->setValue("1");	
		$form->getElement('status')->setValue("1");	
		//$model = new Application_Model_Widgets();
		
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
				//Upload image start here
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
                    $file_name = $upload->getFileName('widgetImage');
                    $cardImageTypeArr = explode(".", $file_name);

                    $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

                    $target_file_name = "slide_".time().".{$ext}";

                    $targetPath = "media/picture/home/".$target_file_name;
                    $targetPathThumb = "media/picture/home/thumb_".$target_file_name;

                    $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

                    $filterFileRename -> filter($file_name);

                    $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
                    $thumb->resize(639, 386);
                    $thumb->save($targetPathThumb);
				 }
				//upload image Ends here
				
				$params = $options;
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$params['userId'] = $usersNs->userId;
				
				//set image
				$params['widgetImage']	=	$target_file_name;
				
				$model	= new Application_Model_Widgets($params);
				$id		= $model->save();                     
				if($id)
				{
					$_SESSION['errorMsg'] = "Slide has been added successfully.";
					$this->_helper->redirector('add','widgets','admin',array('id'=>$page_id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}				
			}//end if
		}//end if		
		$this->view->form = $form;		
	}
	
	public function editAction()
	{
		$id		=	$this->_getParam('id');
		$widgetRes	=	new Application_Model_Widgets();
		$widgetRes	=	$widgetRes->find($id);

		$options = array(
						'widgetTitle'		=> $widgetRes->getWidgetTitle(),
						'widgetType'		=> $widgetRes->getWidgetType(),
						'widgetImage'		=> $widgetRes->getWidgetImage(),
						'widgetText'		=> $widgetRes->getWidgetText(),
						'widgetAltText'		=> $widgetRes->getWidgetAltText(),
						'widgetLinkLabel'   => $widgetRes->getWidgetLinkLabel(),
						'widgetLinkUrl'		=> $widgetRes->getWidgetLinkUrl(),
						'widgetLinkTarget'	=> $widgetRes->getWidgetLinkTarget(),
						'weight'			=> $widgetRes->getWeight(),
						'status'			=> $widgetRes->getStatus(),
						'widgetDesc'		=> $widgetRes->getWidgetDesc()	
						);

		$form    = new Admin_Form_HomeSlide();
		$this->view->widgetImage = $widgetRes->getWidgetImage();
		$form->populate($options);
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set previous image name if not uploaded new one
				$target_file_name =	$widgetRes->getWidgetImage();

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
					unlink("media/picture/home/".$widgetRes->getWidgetImage());
					unlink("media/picture/home/thumb_".$widgetRes->getWidgetImage());

					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('widgetImage');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "slide_".time().".{$ext}";

					$targetPath			= "media/picture/home/".$target_file_name;
					$targetPathThumb	= "media/picture/home/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(639, 386);
					$thumb->save($targetPathThumb);
				}
				//Image Upload END
				
				//set image
				$options['widgetImage'] =	$target_file_name;
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				
				$widgetRes->setOptions($options);
				$updateRes = $widgetRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg'] = "Slide has been updated successfully.";
					$this->_helper->redirector('index','widgets','admin',array('id'=>$id));
				}
				else
				{
					$this->view->errorMsg	=	"Error occured, please try again later.";
				}
				//return $this->_helper->redirector('index','widgets',"admin",Array('msg'=>base64_encode("Slide has been updated successfully!")));
			}//end if
			else
			{
				$form->reset();
				$form->populate($options);
			} 		
		}//end if
		$this->view->form=$form;
	}
	
	public function statusAction()
	{	
		$id		= 	$this->_getParam('id');
		$model	=	new Application_Model_Widgets();
		
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
		return $this->_helper->redirector('index','widgets',"admin");	
	}
	
	public function deleteAction()
	{
		$id		=	$this->_getParam('id');		
		$model	=	new Application_Model_Widgets();
		$widgetRes	=	$model->find($id);
		if($widgetRes)
		{
			$model->delete("id={$id}");
			
			//unlink image if files exists
			if(file_exists("media/picture/home/".$widgetRes->getWidgetImage()))
			{
				unlink("media/picture/home/".$widgetRes->getWidgetImage());
				unlink("media/picture/home/thumb_".$widgetRes->getWidgetImage());
			}	
			$_SESSION['errorMsg']	=	"Slide has been deleted!";
		}
		else
		{
			$_SESSION['errorMsg']	=	"Invalid request, no slide found.";
		}
		return $this->_helper->redirector('index','widgets',"admin");
	}
	
	//Update logged out home page Mid Contents
	public function homepageMidContentAction()
	{
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Application_Model_HomeMidContent();
		$modelRes	=	$modelRes->find($id);

		$options = array(
						'title'				=> $modelRes->getTitle(),
						'subTitle1'			=> $modelRes->getSubTitle1(),
						'subTitle1Text'		=> $modelRes->getSubTitle1Text(),
						'subTitle2'			=> $modelRes->getSubTitle2(),
						'subTitle2Text'		=> $modelRes->getSubTitle2Text(),
						'editorPic'			=> $modelRes->getEditorPic(),
						'editorPicTitle'	=> $modelRes->getEditorPicTitle(),
						'editorPicText'		=> $modelRes->getEditorPicText(),
						'editorPicUrlLabel'	=> $modelRes->getEditorPicUrlLabel(),
						'editorPicUrlLink'	=> $modelRes->getEditorPicUrlLink(),
						'editorPicUrlTarget'=> $modelRes->getEditorPicUrlTarget(),
						'status'			=> $modelRes->getStatus()
						);
		//set Shared link URLs form fields
		$SubTitle1TextArr = unserialize($modelRes->getSubTitle1Text());
		foreach($SubTitle1TextArr AS $key=>$value)
		{
			$options[$key] = $value;
		}
		
		//set Read link URLs form fields
		$SubTitle2TextArr = unserialize($modelRes->getSubTitle2Text());
		foreach($SubTitle2TextArr AS $key=>$value)
		{
			$options[$key] = $value;
		}
		
		$form    = new Admin_Form_HomeMidContent();
		
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
		
		$this->view->editorPic = $modelRes->getEditorPic();
		$form->populate($options);			
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set previous image name if not uploaded new one
				$target_file_name =	$modelRes->getEditorPic();

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
					//unlink previous uploaded image file if exists
					if(file_exists("media/picture/home/".$modelRes->getEditorPic()))
					{
						unlink("media/picture/home/".$modelRes->getEditorPic());
						unlink("media/picture/home/thumb_".$modelRes->getEditorPic());
					}	

					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('editorPic');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "editor_".time().".{$ext}";

					$targetPath			= "media/picture/home/".$target_file_name;
					$targetPathThumb	= "media/picture/home/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(138, 125);
					$thumb->save($targetPathThumb);
				}
				//Image Upload END
				
				//set image
				$options['editorPic'] =	$target_file_name;
				
				//set Shared links array
				$sharedLinkArr = array();
				$sharedLinkArr["sharedLink1Text"]	= $options["sharedLink1Text"];
				$sharedLinkArr["sharedLink1Url"]	= $options["sharedLink1Url"];
				$sharedLinkArr["sharedLink1Target"]	= $options["sharedLink1Target"];
				
				$sharedLinkArr["sharedLink2Text"]	= $options["sharedLink2Text"];
				$sharedLinkArr["sharedLink2Url"]	= $options["sharedLink2Url"];
				$sharedLinkArr["sharedLink2Target"]	= $options["sharedLink2Target"];
				
				$sharedLinkArr["sharedLink3Text"]	= $options["sharedLink3Text"];
				$sharedLinkArr["sharedLink3Url"]	= $options["sharedLink3Url"];
				$sharedLinkArr["sharedLink3Target"]	= $options["sharedLink3Target"];
				
				$sharedLinkArr["sharedLink4Text"]	= $options["sharedLink4Text"];
				$sharedLinkArr["sharedLink4Url"]	= $options["sharedLink4Url"];
				$sharedLinkArr["sharedLink4Target"]	= $options["sharedLink4Target"];
				
				$sharedLinkArr["sharedLink5Text"]	= $options["sharedLink5Text"];
				$sharedLinkArr["sharedLink5Url"]	= $options["sharedLink5Url"];
				$sharedLinkArr["sharedLink5Target"]	= $options["sharedLink5Target"];
				$options['subTitle1Text'] = serialize($sharedLinkArr);
				
				//set Read links array
				$readLinkArr = array();
				$readLinkArr["readLink1Text"]	= $options["readLink1Text"];
				$readLinkArr["readLink1Url"]	= $options["readLink1Url"];
				$readLinkArr["readLink1Target"]	= $options["readLink1Target"];
				
				$readLinkArr["readLink2Text"]	= $options["readLink2Text"];
				$readLinkArr["readLink2Url"]	= $options["readLink2Url"];
				$readLinkArr["readLink2Target"]	= $options["readLink2Target"];
				
				$readLinkArr["readLink3Text"]	= $options["readLink3Text"];
				$readLinkArr["readLink3Url"]	= $options["readLink3Url"];
				$readLinkArr["readLink3Target"]	= $options["readLink3Target"];
				
				$readLinkArr["readLink4Text"]	= $options["readLink4Text"];
				$readLinkArr["readLink4Url"]	= $options["readLink4Url"];
				$readLinkArr["readLink4Target"]	= $options["readLink4Target"];
				
				$readLinkArr["readLink5Text"]	= $options["readLink5Text"];
				$readLinkArr["readLink5Url"]	= $options["readLink5Url"];
				$readLinkArr["readLink5Target"]	= $options["readLink5Target"];
				$options['subTitle2Text'] = serialize($readLinkArr);
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				$modelRes->setOptions($options);
				$updateRes = $modelRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg']	=	"Content has been updated successfully.";
					$this->_helper->redirector('homepage-mid-content','widgets','admin',array('id'=>$id));
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
	}//end function
	
	//Update logged out home page Bottom Contents
	public function homepageBottomContentAction()
	{
		$id			=	$this->_getParam('id',1);
		$modelRes	=	new Application_Model_HomeBottomContent();
		$modelRes	=	$modelRes->find($id);

		$options = array(
						'leftTitle'			=> $modelRes->getLeftTitle(),
						'leftText'			=> $modelRes->getLeftText(),
						'rightText'			=> $modelRes->getRightText(),
						'rightTitle'		=> $modelRes->getRightTitle(),
						'backgroundImage'	=> $modelRes->getBackgroundImage(),
						'status'			=> $modelRes->getStatus()
						);

		$form    = new Admin_Form_HomeBottomContent();
		$this->view->backgroundImage = $modelRes->getBackgroundImage();
		$form->populate($options);
		
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
		
		//submit form
		$request = $this->getRequest();
		if ($request->isPost()) 
		{ 
			$options = $request->getPost();

			if($form->isValid($options))
			{
				//set previous image name if not uploaded new one
				$target_file_name =	$modelRes->getBackgroundImage();

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
					//unlink previous uploaded image file if exists
					if(file_exists("media/picture/home/".$modelRes->getBackgroundImage()))
					{
						unlink("media/picture/home/".$modelRes->getBackgroundImage());
						unlink("media/picture/home/thumb_".$modelRes->getBackgroundImage());
					}	

					$upload->setOptions(array('useByteString' => false));

					$file_name = $upload->getFileName('backgroundImage');  

					$cardImageTypeArr = explode(".", $file_name);

					$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

					$target_file_name = "bottom_".time().".{$ext}";

					$targetPath			= "media/picture/home/".$target_file_name;
					$targetPathThumb	= "media/picture/home/thumb_".$target_file_name;

					$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

					$filterFileRename -> filter($file_name);

					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(641, 299);
					$thumb->save($targetPathThumb);
				}
				//Image Upload END
				
				//set image
				$options['backgroundImage'] =	$target_file_name;
				
				//set user id
				$usersNs = new Zend_Session_Namespace("members");
				$options['userId'] = $usersNs->userId;
				
				$modelRes->setOptions($options);
				$updateRes = $modelRes->save();
				if($updateRes)
				{
					$_SESSION['errorMsg']	=	"Content has been updated successfully.";
					$this->_helper->redirector('homepage-bottom-content','widgets','admin',array('id'=>$id));
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
	}//end function
}

