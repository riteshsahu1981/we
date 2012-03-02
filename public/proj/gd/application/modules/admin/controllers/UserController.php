<?php
class Admin_UserController extends Base_Controller_Action {
	
	public function indexAction()
	{
        //$page_size	=       10;
                $this->view->page_size=$page_size	= $this->_getParam('page_size',25);
		$where = "1=1 AND status!='deleted'";
		
		//search users
		/*
		$q  = $this->_getParam('search-txt');
		$l = $this->_getParam('search-lable');

		if($q <> "" && $q <> "Search" )
		{
			$where	.=	" AND CONCAT(first_name,' ',last_name ) LIKE '%$q%'";
		}
		if($l <> "" && $l <>"")
		{
			$where .=" AND user_level_id ='{$l}'";
			$this->view->lableValue=$l;
		}
		$this->view->searchlable=$this->_getParam('search-lable',"Search");
		$this->view->searchValue=$this->_getParam('search-txt',"Search");
		*/
		
		//create search form
		$form    = new Admin_Form_SearchUsers();
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
		$order = "addedon DESC";
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
			$username	= $this->_getParam('username');
			$status		= $this->_getParam('status');
			$email		= $this->_getParam('email');
			$gender		= $this->_getParam('gender');
			
			//search by name
			if($name!="")
			{
				$where	.=	" AND CONCAT(first_name,' ',last_name ) LIKE '%{$name}%'";
			}
			//search by username
			if($username!="")
			{
				$where .= " AND username LIKE '%{$username}%'";
			}
			//search by status
			if($status!="")
			{
				$where .= " AND status = '{$status}'";
			}
			//search by email
			if($email!="")
			{
				$where .= " AND email LIKE '%{$email}%'";
			}
			//search by gender
			if($gender!="")
			{
				$where .= " AND sex = '{$gender}'";
			}
			$options = array("name"=>$name,"username"=>$username,"status"=>$status,"email"=>$email,"gender"=>$gender);
			$form->populate($options);
		}
		$model		=	new Application_Model_User();
		$settings	=	new Admin_Model_GlobalSettings();
		
		//$page_size	=	$settings->settingValue('pagination_size');
                 

                
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		$paginator	=	$pageObj->fetchPageData($model, $page, $page_size, $where, $order);
		
		$this->view->total_users=$pageObj->getTotalCount(); 
		$this->view->paginator=$paginator;
		$this->view->msg=base64_decode($this->_getParam('msg',''));		
	}
    
	public function autosuggestUserAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$where	 =	"status!='deleted'";
		$where	.=	" AND CONCAT(first_name,' ',last_name ) LIKE '%$q%'";
		
		$model=new Application_Model_User();
		$res=$model->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row)
		{
			$name = $row->getFirstName()." ".$row->getLastName();
			array_push($result, array("id"=>$row->getId(), "first_name"=>$name,  "value" =>$name));
		}
		echo Zend_Json::encode($result);
   	}
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 24-Feb-2011
	 * @Description: Get user records to dsplay auto suggest field
	 */
	public function autoSuggestFieldAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$field	 = $this->_getParam('field');
		$where	 =	"status!='deleted'";
		$where	.=	" AND {$field} LIKE '%$q%'";
		
		$model	=	new Application_Model_User();
		$res	=	$model->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row)
		{
			if($field=="username")
			{
				$name = $row->getUsername();
			}
			else if($field=="email")
			{
				$name = $row->getEmail();
			}
			array_push($result, array("id"=>$row->getId(), "first_name"=>$name,  "value" =>$name));
		}
		echo Zend_Json::encode($result);
   	}

    public function exportAction()
    {
    	$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		include_once LIBRARY_PATH."/Base/Excel/PHPExcel.php";
		$objPHPExcel = new PHPExcel();
		
		$where = "1=1 AND status!='deleted'";
		$order = "addedon DESC";
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'S. No.')
		            ->setCellValue('B1', 'Username')
					->setCellValue('C1', 'First Name')
					->setCellValue('D1', 'Surname')
					->setCellValue('E1', 'Email')
					->setCellValue('F1', 'Gender')
					->setCellValue('G1', 'Number of Friends')
					->setCellValue('H1', 'Created On')					
					;
		$model	=   new Application_Model_User();
	  	$users	=   $model->fetchAll($where, $order);
	  	if(count($users)>0)
	  	{
	  		$i=2;
	  		$sno=1;
			foreach($users as $_user)
			{
				//select users Numbers of friends
				$noOfFriends = 0;
				$friendM = new Application_Model_Friend();
				$userFriends = $friendM->countUserFriends($_user->getId());
				$noOfFriends = $userFriends["totalFriends"];
		
				//$country = $_user->findParentRow('Application_Model_DbTable_Country','Country');
			   // $state  =  $_user->findParentRow('Application_Model_DbTable_State','State');
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $sno)
							->setCellValue('B'.$i, $_user->getUsername())
							->setCellValue('C'.$i, $_user->getFirstName())
							->setCellValue('D'.$i, $_user->getLastName())
							->setCellValue('E'.$i, $_user->getEmail())
							->setCellValue('F'.$i, ucfirst($_user->getSex()))
							->setCellValue('G'.$i, $noOfFriends)
							->setCellValue('H'.$i, date("M j, Y", $_user->getAddedOn()))							
						;
				$i++;
				$sno++;
			}
	  	}
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Users');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		//$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		//$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		//$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		if($this->_getParam('type')=='xls')
		{
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="users.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		}
		else if($this->_getParam('type')=='pdf')
		{
			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="users.pdf"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		}
                else if($this->_getParam('type')=='csv')
		{
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="users.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		}
		$objWriter->save('php://output');
    }
	public function editAction()
	{
		$id = $this->_getParam('id');
		$this->view->user_id = $id;
		$model1 = new Application_Model_User();
		$model = $model1->find($id);
		
		$options['firstName']		=	$model->getFirstName();
		$options['lastName']		=	$model->getLastName();
        $options['email']			=	$model->getEmail();
		$options['countryPassport']	=	$model->getCountryPassport();
		$options['preferredLanguage']=	$model->getPreferredLanguage();
		$options['otherLanguages']	=	$model->getOtherLanguages();
		$options['cityId']			=	$model->getCityId();
		$options['cityName']		=	$model->getCityName();
		
		$arrDob=explode("-",$model->getDob());
		if(count($arrDob)>0)
		{
			$options['year']	=	$arrDob[0];	
			$options['month']	=	$arrDob[1];
			$options['day']		=	$arrDob[2];
		}
		$options['sex']					=	$model->getSex();
		$options['firstTimeTraveller']	=	$model->getFirstTimeTraveller();
		$options['mobileCountryCode']	=	$model->getMobileCountryCode();
		$options['mobile']				=	$model->getMobile();
		$options['dreamDestination']	=	$model->getDreamDestination();
		$options['wayToTravel']			=	$model->getWayToTravel();
		$options['travelGear']			=	$model->getTravelGear();
		$options['yearGoal']			=	$model->getYearGoal();
		$options['leaveHomeWithout']	=	$model->getLeaveHomeWithout();
		$options['interests']			=	$model->getInterests();
		$options['evenTakenGapYear']	=	$model->getEvenTakenGapYear();
		$options['nextTravelToDoList']	=	$model->getNextTravelToDoList();
		$options['favouriteTravelExperience'] =	$model->getFavouriteTravelExperience();
		$options['userLevelId']			=	$model->getUserLevelId();
		$this->view->username			=	$model->getUsername();
		
		$request = $this->getRequest();
        $form    = new Admin_Form_User();
		//remove fields do not need to display in Edit
		$form->removeElement('username');
		$form->removeElement('password');
		$form->removeElement('confirmPassword');
		
        $form->populate($options);
        
        $options=$request->getPost();
		if ($request->isPost()) 
        { 
        	 /*---- email validation ----*/
            if($options['email']!=$model->getEmail())
            {
				$form->getElement('email')->addValidators(array(
				array('Db_NoRecordExists', false, array(
				'table' => 'user',
				'field' => 'email',
				'messages'=>'Email already exists, Please choose another email address.'
					))
				));
            }
            /*-------------------------*/
			
			if ($form->isValid($options))
        	{
                /*---------  Upload image START -------------------------*/
				$upload = new Zend_File_Transfer_Adapter_Http();
				if($upload->isValid('image'))
		        {
		        	//unlink existing images
					if(file_exists("media/picture/profile/".$model->getImage()))
					{
						unlink("media/picture/profile/".$model->getImage()); //main uploaded image
						unlink("media/picture/profile/thumb_".$model->getImage()); //thumb image
					}	
					
					$upload->setDestination("images/uploads/");
		        	try 
		        	{
					 	$upload->receive('image');
					 	
					 } 
					 catch (Zend_File_Transfer_Exception $e) 
					 {
					 	$msg= $e->getMessage();
					 }			 
								 
					 $upload->setOptions(array('useByteString' => false));
					 
					 $file_name = $upload->getFileName('image');
		 		 	 $cardImageTypeArr = explode(".", $file_name);
		 		 	 $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]); 			 	 
		 		 	 $target_file_name = "profile_".$id.".{$ext}";
				 	 $targetPath = 'media/picture/profile/'.$target_file_name;
				 	 $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
					 $filterFileRename -> filter($file_name);
					 $options['image'] = $target_file_name;
					 
					 
					/*--- Generate Thumbnail ---*/ 
					$thumb = Base_Image_PhpThumbFactory ::create($targetPath);
					$thumb->resize(100,100);
					$thumb->save($targetPath = 'media/picture/profile/thumb_'.$target_file_name);
				}
		        /*---------  Upload image END -------------------------*/
				
				$options['dob'] = $options['year']."-".$options['month']."-".$options['day'];
				$model->setOptions($options);
                $model->save();
                $this->view->msg="'User information has been updated successfully!";
        	}
        	else
        	{
        		$form->reset();
            	$form->populate($options);
        	} 		
        }
        $this->view->thumbImage	=	$model->getThumbnail();
		$this->view->image_name	=	$model->getImage();
        $this->view->form		=	$form;
	}
	
	public function addAction()
	{
            
            $request = $this->getRequest();
            $form    = new Admin_Form_User();
           
            $options=$request->getPost();
            if ($request->isPost())
            {
                     /*---- email validation ----*/

               
                    $form->getElement('email')->addValidators(array(
                    array('Db_NoRecordExists', false, array(
                    'table' => 'user',
                    'field' => 'email',
                    'messages'=>'Email already exists, Please choose another email address.'
                            ))
                    ));
               
                /*-------------------------*/

                if ($form->isValid($options))
                {
                    $model=new Application_Model_User();
                    $options['dob'] = $options['year']."-".$options['month']."-".$options['day'];
                    $options['status']='active';
                    $options['password']=md5($options['password']);
					$options['preferredLanguage']='English';
		            //$options['userLevelId']	=$options['userLevelId'];					
                    //$model->setOptions($options);
                   // $id=$model->save();
                    /*---------  Upload image START -------------------------*/
                    $upload = new Zend_File_Transfer_Adapter_Http();
                    if($upload->isValid('image'))
                    {
                        $upload->setDestination("media/picture/profile/");
                        try
                        {
                              $upload->receive('image');
                         }
                         catch (Zend_File_Transfer_Exception $e)
                         {
                                $msg= $e->getMessage();
                         }

                         $upload->setOptions(array('useByteString' => false));

                         $file_name = $upload->getFileName('image');
                         $cardImageTypeArr = explode(".", $file_name);
                         $ext = strtolower($cardImageTypeArr[count($cardImageTypeArr)-1]);
                         $target_file_name = "profile_".$id.".{$ext}";
                         $targetPath = 'media/picture/profile/'.$target_file_name;
                         $filterFileRename = new Zend_Filter_File_Rename(array('target' => $targetPath , 'overwrite' => true));
                         $filterFileRename -> filter($file_name);
                         $options['image'] = $target_file_name;


                        /*--- Generate Thumbnail ---*/
                        $thumb = Base_Image_PhpThumbFactory ::create($targetPath);
                        $thumb->resize(100,100);
                        $thumb->save($targetPath = 'media/picture/profile/thumb_'.$target_file_name);

                        $model->setOptions($options);
                        $model->setId($id);
                        $id=$model->save();
                      }
                        /*---------  Upload image END -------------------------*/

                   
				   //$options['dob'] = $options['year']."-".$options['month']."-".$options['day'];
				   //$model->setOptions($options);
                   //$model->save();
				   $user=new Application_Model_User($options);
				   $user_id=$user->save();
				   if($user_id>0)
				   {
					/*---- default permission settings ----*/					
					   $user->setDefaultPermissions($user_id);
					   $user->setDefaultJournal($user_id);	
				   }
                   $this->view->msg="'User has been inserted successfully!";
				   $form->reset();
                }
                else
                {
                    $form->reset();
                    $form->populate($options);
               }
            }
          
            $this->view->form		=	$form;
	}
	public function blockAction()
	{
		$id=$this->_getParam('id');
		$model1=new Application_Model_User();
		$model=	$model1->find($id);
		if($model->getStatus()=="active")
		{
			$model->setStatus("inactive");
			$publish="blocked";
		}
		else
		{
			$model->setStatus('active');
			$publish="unblocked";
		}
		$model->save();
		return $this->_helper->redirector('index','user',"admin",Array('msg'=>base64_encode("User [Id : {$model->getId()}] has been $publish!")));
	}
	
	public function resetPasswordAction()
	{
		$id=$this->_getParam('id');
		$User = new Application_Model_User();
		$res=$User->find($id);
		$Auth=new Base_Auth_Auth();
    	$Auth->recoverPassword($res);
        return $this->_helper->redirector('index','user',"admin",Array('msg'=>base64_encode("User [Id : {$res->getId()}] Password has been changed!")));
        	
	}
	

	function changePasswordAction(){
	
		$usersNs = new Zend_Session_Namespace("members");
		$user = new Application_Model_User();
		$model = $user->find($usersNs->userId);
		
		
		$request = $this->getRequest ();
		$form = new Application_Form_ChangePassword();
		
		if ($request->isPost ()) 
		{
			$options = $request->getPost ();
			if ($form->isValid ( $options )) {
				$model->setPassword(md5($options ['password']));
				$model->save();
				$this->view->msg ="Your password changed successfully!" ;
				
			
			} else {
				$form->reset ();
				$form->populate ( $options );
			}
		}
		
		// Assign the form to the view
		$this->view->form = $form;
	}
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 26-Nov-2010
	 * @Description: Delete user profile image
	 */
	public function removeProfileimageAction()
	{
		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
		
		//$userNs = new Zend_Session_Namespace('members');
        $id		= $this->_getParam('user_id');
		
		if(is_null( $id) && !numeric($id))
		{
			$response = "<span style='color:#ff0000;'>user Id can not be left blank.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		if($this->_getParam('image')=="")
		{
			$response = "<span style='color:#ff0000;'>Profile image does not exists.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		//remove profile image
		$userm	= new Application_Model_User();
		$userm	= $userm->find($id);
		
		if(false!==$userm)
		{
			$resp = "";
			$userm->setImage("NULL");
			$resp	=  $userm->save();
			//unlink images from uploaded directory
			if(file_exists("media/picture/profile/".$this->_getParam('image')))
			{
				unlink("media/picture/profile/".$this->_getParam('image')); //main uploaded image
				unlink("media/picture/profile/thumb_".$this->_getParam('image')); //thumb image
			}	
			
			$response = "<span style='color:#ff0000;'>Profile image has been deleted.</span>";
			$JsonResultArray = Array('error'=>2, 'response'=>$response);
		}
		else
		{
			$response = "<span style='color:#ff0000;'>Invalid request, please try again later.</span>";
			$JsonResultArray = Array('error'=>1, 'response'=>$response);
        }
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 27-Dec-2010
	 * @Description: Used to delete user(simply change user status as 'deleted')
	 */
	public function deleteAction()
	{
		$id		= 	$this->_getParam('id');
		$page	= 	$this->_getParam('page');
		$userM	=	new Application_Model_User();
		if(false !== $userM)
		{
			$userR  =	$userM->find($id);
			$userR->setStatus('deleted');
			$userR->save();
			
			//delete user data
			$userM->deleteUserData($userR->getId());
			
			//redirect user to index
			$this->_helper->redirector('index','user',"admin",Array('page'=>$page, 'msg'=>base64_encode("User [Id : {$userR->getId()}] has been deleted!")));
		}
		else	
		{
			$this->_helper->redirector('index','user',"admin",Array('msg'=>base64_encode("Invalid request. No user exists.")));
		}
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 19-Jan-2011
	 * @Description: Select all users subscribed for newsletter service
	 */
	public function newsletterUsersAction()
	{
		$sSQL  = "SELECT u.id, u.email, u.username, u.first_name, u.last_name, u.sex, s.addedon";
		$sSQL .= " FROM user AS u";
		$sSQL .= " JOIN subscribe AS s ON s.user_id=u.id";
		$sSQL .= " WHERE u.status!='deleted' AND s.status=1";
		$sSQL .= " ORDER BY s.addedon DESC";
		
		//$settings	=	new Admin_Model_GlobalSettings();		
		//$page_size	=	$settings->settingValue('pagination_size');
		$page_size	= $this->_getParam('page_size',25);
		
		$page		=	$this->_getParam('page',1);
		$pageObj	=	new Base_Paginator();
		
		$paginator	=	$pageObj->fetchPageDataRaw($sSQL, $page, $page_size);
		//$paginator	=	$pageObj->fetchPageData($model,$page,$page_size, $where);
		
		//set view variables
		$this->view->total_users	=	$pageObj->getTotalCount();
		$this->view->paginator		=	$paginator;
	}//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 27-Jan-2011
	 * @Description: Export all subscribed users in CSV/Excel file
	 */
	public function exportSubscriberAction()
    {
    	$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		include_once LIBRARY_PATH."/Base/Excel/PHPExcel.php";
		$objPHPExcel = new PHPExcel();
		
		//Set top header
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'S. No.')
		            ->setCellValue('B1', 'First Name')
		            ->setCellValue('C1', 'Surname')
		            ->setCellValue('D1', 'Email')
					->setCellValue('E1', 'Gender')
					->setCellValue('F1', 'Date Subscribed')
                    ;
		
		$sSQL  = "SELECT u.id, u.email, u.username, u.first_name, u.last_name, u.sex, s.addedon";
		$sSQL .= " FROM user AS u";
		$sSQL .= " JOIN subscribe AS s ON s.user_id=u.id";
		$sSQL .= " WHERE u.status!='deleted' AND s.status=1";
		$sSQL .= " ORDER BY s.addedon DESC";
		
		//create database object
		$db = Zend_Registry::get("db");
		
		$result			=	$db->fetchAll($sSQL);
    	$total_users 	=	count($result);
		
		if($total_users > 0)
	  	{
	  		$i=2;
	  		$sno=1;
			foreach($result as $row)
			{    
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, $sno)
							->setCellValue('B'.$i, $row->first_name)
							->setCellValue('C'.$i, $row->last_name)
							->setCellValue('D'.$i, $row->email)
							->setCellValue('E'.$i, ucwords($row->sex))
							->setCellValue('F'.$i, date("M j, Y", $row->addedon))							                         
						;
				$i++;
				$sno++;
			}//end foreach
	  	}//end if
		
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Newsletter Subscribed Users');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		if($this->_getParam('type')=='xls')
		{
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="subscribers.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		}
		else if($this->_getParam('type')=='pdf')
		{
			// Redirect output to a client’s web browser (PDF)
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="subscribers.pdf"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		}
        else if($this->_getParam('type')=='csv')
		{
			// Redirect output to a client’s web browser (CSV)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="subscribers.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		}
		$objWriter->save('php://output');
    }
}
