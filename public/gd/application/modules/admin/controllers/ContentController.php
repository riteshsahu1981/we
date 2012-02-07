<?php
class Admin_ContentController extends Base_Controller_Action
{
	//disable Status and Weight for fixed text/modules
	var $fixedTextMod = array("home_left_top_logout","home_left_top_login","home_left_top-bottom1","home_left_top-bottom2");
	
	//these modules can not be deleted
	var $fixedModules = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
	
	//logout top modules
	var $logoutTopContents = "1,3";
	
	//login top modules
	var $loginTopContents = "2,10";
	
	//login modules and contents
	var $loginModules = "4,5,6,7,8,9";
	
	public function indexAction()
	{
		$where		=	"id IS NOT NULL";
		$model		=	new Application_Model_Content();
		$settings	=	new Admin_Model_GlobalSettings();
		$page_size	=	$settings->settingValue('pagination_size');
		$page		=	$this->_getParam('page',1);
		
		$type		=	"module";
		if($this->_getParam('type')!="")
		{
			$type		=	$this->_getParam('type');
		}	
		$this->view->type =	$type;
		
		if($type=="logout")
		{
			$where	.=	" AND id IN ({$this->logoutTopContents})";
		}
		else if($type=="login")
		{
			$where	.=	" AND id IN ({$this->loginTopContents})";
		}
		else
		{
			$where	.=	" AND id IN ({$this->loginModules})";
		}
		//echo "ssss=".$where;exit;
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, "weight ASC");
		
		$this->view->total			=	$pageObj->getTotalCount();
		$this->view->paginator		=	$paginator;
		$this->view->msg			=	base64_decode($this->_getParam('msg',''));
		$this->view->fixedTextMod	=	$this->fixedTextMod;
		$this->view->fixedModules	=	$this->fixedModules;
	}
	
	public function addAction()
    {
    	$type		=	"module";
		if($this->_getParam('type')!="")
		{
			$type		=	$this->_getParam('type');
		}
		$this->view->type =	$type;
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Content();
        
		//remove unwanted fields
		$form->removeElement('whereText');
		$form->removeElement('whereUrl');
		$form->removeElement('whereUrlTarget');
		$form->removeElement('whereBodyText');
		$form->removeElement('whereBodyUrl');
		$form->removeElement('whereBodyUrlTarget');
		$form->removeElement('weekPhoto');
		
		if ($this->getRequest()->isPost()) 
        { 
            $options = $request->getPost();
            if ($form->isValid($options)) 
            { 
            	$model	= new Application_Model_Content($options);
            	$id		= $model->save();
                if($id)
				{
					return $this->_helper->redirector('index','content',"admin",Array('msg'=>base64_encode("Content has been saved successfully!")));
				}
				else
				{
					return $this->_helper->redirector('index','content',"admin",Array('msg'=>base64_encode("Error occured, please try again later.")));
				}	
            }
            else
            {
            	$form->reset();
            	$form->populate($options);
            }
        }
        // Assign the form to the view
        $this->view->form = $form;
    }
    
    public function changestatusAction()
	{
		$id		=	$this->_getParam('id');
		$page	=	$this->_getParam('page');
		$status	=	$this->_getParam('status');
		
		$model	=	new Application_Model_Content();
		$model	=	$model->find($id);
		
		$model->setStatus($status);
		$model->save();
		
		$msg = "Content has beed successfully unpublished!";
		if($status==1)
		{
			$msg = "Content has beed successfully published!";
		}	
		$this->_helper->redirector('index','content','admin',Array('msg'=>base64_encode($msg),'page'=>$page));
	}
	
	public function editAction()
	{
		$type		=	"module";
		if($this->_getParam('type')!="")
		{
			$type		=	$this->_getParam('type');
		}
		$this->view->type =	$type;
		
		$id		=	$this->_getParam('id');
		$page	=	$this->_getParam('page');
		$model	=	new Application_Model_Content();
		$model	=	$model->find($id);
		
		$options['title']	=	$model->getTitle();
      	$options['alias']	=	$model->getAlias();
      	$options['body']	=	$model->getBody();
      	$options['status']	=	$model->getStatus();
      	$options['weight']	=	$model->getWeight();
		
		
		$request = $this->getRequest();
        $form    = new Admin_Form_Content();
        
		
		/****************************  Show/Hide fields as per module structure START ***************/
        //by default fields should be enabled
		
		$displayEditor = true;
		
		//remove form fields for fixed content
		if(in_array($model->getAlias(),$this->fixedTextMod))
		{
			$form->removeElement('weight');
			$form->removeElement('status');
			
			$form->removeElement('whereText');
			$form->removeElement('whereUrl');
			$form->removeElement('whereUrlTarget');
			$form->removeElement('whereBodyText');
			$form->removeElement('whereBodyUrl');
			$form->removeElement('whereBodyUrlTarget');
			
			$form->removeElement('weekPhoto');
		}
		//remove editor when updating home_journal module
		else if($model->getAlias()=="home_login_where_i_am")
		{
			$form->removeElement('body');
			$displayEditor = false;
			
			$arrBodyText = unserialize($model->getBody());
			foreach($arrBodyText AS $key=>$value)
			{
				$options[$key]	=	$value;
			}
			
			$form->removeElement('weekPhoto');
		}
		else if ($model->getAlias()=="home_journal" || $model->getAlias()=="home_advertise")
		{
			$form->removeElement('body');
			$displayEditor = false;
			
			$form->removeElement('whereText');
			$form->removeElement('whereUrl');
			$form->removeElement('whereUrlTarget');
			$form->removeElement('whereBodyText');
			$form->removeElement('whereBodyUrl');
			$form->removeElement('whereBodyUrlTarget');
			
			$form->removeElement('weekPhoto');
		}
		else if ($model->getAlias()=="home_photo_week")
		{
			$form->removeElement('whereText');
			$form->removeElement('whereUrl');
			$form->removeElement('whereUrlTarget');
			$form->removeElement('whereBodyText');
			$form->removeElement('whereBodyUrl');
			$form->removeElement('whereBodyUrlTarget');
			
			$photoBodyArr = unserialize($model->getBody());
			$target_file_name = $photoBodyArr["weekPhoto"];
			
			//$options['weekPhoto'] = $photoBodyArr["weekPhoto"];
			$this->view->weekPhoto = $target_file_name;
			$options['body'] = $photoBodyArr["body"];
		}
		else
		{
			$form->removeElement('whereText');
			$form->removeElement('whereUrl');
			$form->removeElement('whereUrlTarget');
			$form->removeElement('whereBodyText');
			$form->removeElement('whereBodyUrl');
			$form->removeElement('whereBodyUrlTarget');
			
			$form->removeElement('weekPhoto');
		}
		//display editor as per module requirement
		$this->view->displayEditor = $displayEditor;
		/****************************  Show/Hide fields as per module structure END ***************/
		
		//populate form options
		$form->populate($options);
		
		if ($this->getRequest()->isPost()) 
        {
            $options	=	$request->getPost();
            if ($form->isValid($options)) 
            {
            	//create array for module as per their structure and save in database as serialize array
				if($options["alias"]=="home_login_where_i_am")
				{
					$bodyTextArr["whereText"]			= $options["whereText"];
					$bodyTextArr["whereUrl"]			= $options["whereUrl"];
					$bodyTextArr["whereUrlTarget"]		= $options["whereUrlTarget"];
					$bodyTextArr["whereBodyText"]		= $options["whereBodyText"];
					$bodyTextArr["whereBodyUrl"]		= $options["whereBodyUrl"];
					$bodyTextArr["whereBodyUrlTarget"]	= $options["whereBodyUrlTarget"];
					$options["body"] = serialize($bodyTextArr);
				}
				//upload photo image for Photo of The Week Module
				if($options["alias"]=="home_photo_week")
				{
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
						$file_name = $upload->getFileName('weekPhoto');
						$cardImageTypeArr = explode(".", $file_name);

						$ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);

						//unlink existing image
						if($ext!="" && $target_file_name!="")
						{
							if(file_exists("media/picture/home/".$target_file_name))
							{
								unlink("media/picture/home/".$target_file_name);
								unlink("media/picture/home/thumb_".$target_file_name);
							}
						}
						//$target_file_name = "weekPhoto_".time().".{$ext}";
						$target_file_name = "photo-of-the-week.{$ext}";
						$targetPath = "media/picture/home/".$target_file_name;
						$targetPathThumb = "media/picture/home/thumb_".$target_file_name;

						$filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));

						$filterFileRename -> filter($file_name);

						$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
						$thumb->resize(278, 129);
						$thumb->save($targetPathThumb);
					 }
					//upload image Ends here
					$bodyTextArr["weekPhoto"]	= $target_file_name;
					$bodyTextArr["body"]		= $options["body"];					
					$options["body"]			= serialize($bodyTextArr);
				}
				$model->setOptions($options);
                $model->save();
                return $this->_helper->redirector('index','content',"admin",Array('type'=>$type,'msg'=>base64_encode("Content has been saved successfully!")));                
            }
            else
            {
            	$form->reset();
            	$form->populate($options);
            }
        }
        $this->view->msg=base64_decode($this->getRequest()->getParam("msg"));
        // Assign the form to the view
        $this->view->form = $form;
		
		//render different view for Photo Of The Week module
		if ($model->getAlias()=="home_photo_week")
		{
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
			$this->render('edit-photo');
		}
	}
	
	public function deleteAction()
	{
		
		$id		=	$this->_getParam('id');
		$page	=	$this->_getParam('page');
		if(!in_array($id, $this->fixedModules))
		{
			$model	=	new Application_Model_Content();
			$model	=	$model->find($id);
		
			$model->delete("id={$id}");
			return $this->_helper->redirector('index','content',"admin",Array('msg'=>base64_encode("Module/content has been deleted successfully!")));
		}
		else
		{
			return $this->_helper->redirector('index','content',"admin",Array('msg'=>base64_encode("You can not delete this module/content!")));
		}	
		
	}	
}
