<?php
class IndexController extends Base_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    	/*$uri=$this->_request->getPathInfo();
		$activeNav=$this->view->navigation()->findByUri($uri);
		$activeNav->active=true;    	*/
       
    }
	
	public function __call($method,$args)
	{
	}

        public function smtpAction()
        {
             $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

          
            $mail=new Base_Mail();
            $mail->setBodyHtml ( "This is just a test mail!!!. Please ignore!!!!!!!");
            $mail->setFrom ("ritesh@ortegra.com", "Ritesh K Sahu");
            $mail->addTo("ritesh@profitbyoutsourcing.com");
            //$mail->addCc("zareef@ortegra.com");
            //$mail->addCc("mahipal@ortegra.com");
            $mail->setSubject ("SMTP is enabled! c cool");
            $mail->send();

        }

        public function badwordAction()
        {
            $this->view->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $valueString="Dear Nadia,

My name is Francesca Harper, I'm 25 and about to set off on my first backpacking adventure around Asia and Australasia/Pacific in May for 6 months.

I am getting in touch really because being a writer/copywriter, I would love to use my professional skills whilst away to help others thinking of and planning their own backpacking trip. I would love to help Gap Daemon with before, during and after backpacking blogs, articles and general advice, as I know how much your site and similar backpacking sites have really helped me to plan my trip.

Having been planning for many months now, I really feel as though I could offer some genuine helpful advice to fellow backpackers. And also having been an online web editor as well as a cuurent freelance copywriter, I understand how to write for the online consumer market.

I've kept my initial email quite short for now, but if you would like to know more about my previous experience, or just a bit more about me in general, don't hesitate to ask - I'm really friendly! If you don't use freelancers, but would still like to know more, that would be fine, too :0)

I would really appreciate hearing from you.

Regards - Francesca";
                $settings		= new Admin_Model_GlobalSettings();
		$badwordsStr	= $settings->settingValue('bad_words');
		$badwordsArr	= explode(",",$badwordsStr);
		for($i=0; $i<count($badwordsArr); $i++)
		{
			if(strstr(strtoupper($valueString), strtoupper(trim($badwordsArr[$i]))))
			{
				echo $badwordsArr[$i];
                                echo "<br>";
			}
                }
        }

	public function sliderDemoAction()
	{

	}

	public function fbAction()
	{
            //$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

                $userNs	=	new Zend_Session_Namespace('members');
                $user		=	new Application_Model_User();
		$user		=	$user->find($userNs->userId);


                $facebook	=	$this->view->facebook();
                $statusUpdate = $facebook->api('/'.$user->getFacebookId().'/friends', 'get');


                ///https://api.facebook.com/method/liveMessage.send?recipient=qa&event_name=asdfads&message=asdfdasfadsf&access_token=...
               // $statusUpdate = $facebook->api('/100001442260018/feed', 'post', array('message'=> "please join gd", 'cb' => ''));
echo "<pre>";
                var_dump($statusUpdate );
                
	}
	
	public function pageAction()
	{
		
		$identifire	=	$this->_getParam("identifire");
		$preview	=	false;
		$preview	=	$this->_getParam("preview");
				
		$page		=	new Application_Model_Page();
		$page		=	$page->getStaticContent($identifire);
		if(false!==$page)
		{
			$this->view->preview 	=	$preview;
			$this->view->status		=	$page->getStatus();
			$this->view->title		=	$page->getTitle();
			$this->view->content	=	$page->getContent();
			$this->view->headTitle()->setSeparator(' - ');
			if($page->getMetaTitle()=="")
				$this->view->headTitle()->set($page->getTitle());
			else
				$this->view->headTitle()->set($page->getMetaTitle());

			$this->view->headMeta()->appendName('keywords',$page->getMetaKeyword());
			$this->view->headMeta()->appendName('description',$page->getMetaDescription());
			$this->view->headMeta()->appendName('title',$page->getMetaTitle());
		}
		else
		{
			$this->view->status = 2; //deleted
		}	
	}
	/**
	* @Created By : Mahipal Singh Adhikari
	* @Created On : 8-Dec-2010
	* @Description: Used to display contact us page and send mails to Site Administrator
	*/
	public function contactAction()
	{
		$identifire	=	$this->view->actionName;
		$page		=	new Application_Model_Page();
        
		$preview	=	false;
		$preview	=	$this->_getParam("preview");
		    
		$page	=	$page->getStaticContent($identifire);
		$this->view->preview		=	$preview;
		$this->view->status		=	$page->getStatus();
		$this->view->title		=	$page->getTitle();
		$this->view->content	=	$page->getContent();
		$this->view->headTitle()->setSeparator(' - ');
				
		if($page->getMetaTitle()=="")
		{
			$this->view->headTitle()->set($page->getTitle());
		}	
		else
		{
			$this->view->headTitle()->set($page->getMetaTitle());
		}	
		//append meta title and keywords
		$this->view->headMeta()->appendName('keywords',$page->getMetaKeyword());
		$this->view->headMeta()->appendName('description',$page->getMetaDescription());
		$this->view->headMeta()->appendName('title',$page->getMetaTitle());
		
		//submit information
		$form		= new Application_Form_Contact();
    	$elements	= $form->getElements();    	
    	$form->clearDecorators();
    	foreach($elements as $element)
		{
                        $element->removeDecorator('label');
			$element->removeDecorator('dd');
		}	
    	$this->view->form = $form;    	
        
        if ($this->getRequest()->isPost()) 
        {
        	$params= $this->getRequest()->getPost();          
            if ($form->isValid($params)) 
            {
            	//set user id if logged in else set 0 as default
				$user_id = 0;
				$userNs = new Zend_Session_Namespace('members');
				$user_id = $userNs->userId;
				
				//create contact model object
            	$contactM	= new Application_Model_Contact();
				
				//set values
				$contactM->setContactName($this->_getParam('contact_name'));
				$contactM->setContactEmail($this->_getParam('contact_email'));
				$contactM->setContactReason(nl2br($this->_getParam('contact_reason')));
				$contactM->setUserId($user_id);
				$contactM->setStatus(1);
				
				//save data
				$contact_id	= $contactM->save();
				
				$message = "";
				
				if($contact_id>0)
				{
					//send email to admin
					$settings	= new Admin_Model_GlobalSettings();
					$admin_email= $settings->settingValue('admin_email');
					//$admin_email = "mahipal@profitbyoutsourcing.com";
					
					//set sender information
					$mailOptions['sender_name']	= ucwords($this->_getParam('contact_name'));
					$mailOptions['sender_email']= $this->_getParam('contact_email');
					$mailOptions['sender_comments']= $this->_getParam('contact_reason');
					
					//set receiver information
					$mailOptions['receiver_email']	= $admin_email;
					//$mailOptions['receiver_name']	= "Administrator";
					
					//create mail class object and send the email
					$Mail	=	new Base_Mail();
					$Mail->sendContactusEmail($mailOptions);
					$message = "Thanks! We have your feedback and will try and get in touch with you as soon as possible.";
				}
				else
				{
					$message = "Error occured while sending email.";
				}
				
				//set falsh message and redirect user
				$_SESSION["flash_msg"] = $message;
				$this->_redirect($this->view->seoUrl('/index/contact/'));
				
            }//end of if
        }//end if
	}//end function
	
	public function aboutAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function advertiseAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function privacyPolicyAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	
	public function workForUsAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	
	public function termsConditionsAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	
	public function pressMediaAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	
	public function advertisingAndPartnershipsAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function safetyPolicyAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function sitemapAction(){
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		echo $this->view->navigation()->sitemap();
	}
    public function competitionAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function videoAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function photosAction()
	{
		$this->_forward('page','index',null,array("identifire"=>$this->view->actionName));
	}
	public function adminAction()
	{
		$this->_forward('index','index','admin' );
	}
	
	public function autosuggestCityAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$where="name like '%{$q}%'";
		$model=new Application_Model_City();
		$res=$model->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row) 
		{
			array_push($result, array("id"=>$row->getId(), "value" => $row->getName()));
		}
		echo Zend_Json::encode($result);
   	}
   	
	public function autosuggestLanguageAction()
   	{
   		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$q = strtolower($this->_getParam('term'));
		if (!$q) return;
		
		$where="name like '%{$q}%'";
		$model=new Application_Model_Language();
		$res=$model->fetchAll($where, null,11);
		$result = array();
		foreach ($res as $row) 
		{
			array_push($result, array("id"=>$row->getId(), "value" => $row->getName()));
		}
		echo Zend_Json::encode($result);
   	}
   	
   	public function homeAction()
	{
		$this->_helper->layout->setLayout('home');
		$this->render('home');		
	}
	
	public function newhomeAction()
	{
		//$this->_helper->layout->setLayout('home');
		$this->_helper->layout->setLayout('newhome');
		$this->render('home');
	}
	
    public function indexAction()
    {
		$this->_helper->layout->setLayout('newhome');
		$this->render('home');
		//$this->render('home');
		
		if($this->_getParam("msg")=="le")
		{
			$this->view->lmsg="Incorrect details entered: please try again.";
		}
		else if($this->_getParam('msg')=="hle")
		{
			$this->view->hlmsg="Incorrect details entered: please try again.";
		}
		$request = $this->getRequest();
		$this->view->Lform=$form=new Admin_Form_Login();
		$elements=$form->getElements();
		$form->clearDecorators();
		
		foreach($elements as $element)
		$element->removeDecorator('label');

		if ($request->isPost())
		{
			if ($form->isValid($request->getPost())) 
			{
				$params=$request->getParams();
				$Auth = new Base_Auth_Auth();
				$Auth ->doLogout();

				$loginStatusEmail=true;
				$loginStatusUsername=true;

				$loginStatusEmail=$Auth->doLogin($params, 'email');
				if($loginStatusEmail==false)
				{
					$loginStatusUsername=$Auth->doLogin($params, 'username');
				}

				//$loginStatusUsername=$Auth->doLogin($params, 'username');
				if ($loginStatusEmail==false && $loginStatusUsername==false) 
				{
					if($this->_getParam("homeLogin")=="homeLogin")
					$this->_helper->redirector('index','index',"default",array("msg"=>"hle"));
					else
					$this->_helper->redirector('index','index',"default",array("msg"=>"le"));
				}
				else
				{
					if($params['rememberMe']==1)
					{
						$Auth->remeberMe(true, $params);
					}
					else
					{
						$Auth->forgotMe('rememberMe'); //delete existing cookies as per new requirement
					}
					header("location: {$_SERVER['HTTP_REFERER']}");
					//$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/where-i-am'));
				}
			}
			else
			{
				$this->_helper->redirector('index','index',"default",array("msg"=>"le"));
			}
		}      
    }//end function

	public function resizeImageAction()
    {
    	$path=base64_decode($this->_getParam('path'));
    	
    	$thumb = Base_Image_PhpThumbFactory ::create($path);
		$thumb->resize(70);
		$thumb->show();
    	exit;	
    }

    
	public function thumbAction()
    {
    	$path=base64_decode($this->_getParam('path'));
    	$width=$this->_getParam('width');
    	$height=$this->_getParam('height');
    	$thumb = Base_Image_PhpThumbFactory ::create($path);
		$thumb->resize($width,$height);
		$thumb->show();
    	exit;	
    }

    public function thumb1Action()
    {
    	$path=$this->_getParam('path');
    	$width=$this->_getParam('width');
    	$height=$this->_getParam('height');
    	$thumb = Base_Image_PhpThumbFactory ::create($path);
	$thumb->resize($width,$height);
        //$thumb->rotateImageNDegrees(1, '0xFFFFFF');
	$thumb->show();
    	exit;
    }
	public function doFbReturnAction()
	{
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
			
	 	/*------facebook------*/
		$usersNs = new Zend_Session_Namespace("members");	
		$user=new Application_Model_User();
		$result=$user->facebookConnect($usersNs->userId);
		if($result)
		{
	 	?>
			<script language="javascript">
				window.opener.location.reload();
				window.close();
			</script>
		<?
		}else {
		?>
			<script language="javascript">
				alert("Could not connect with facebook!");
				window.opener.location.href.reload();
				window.close();
			</script>
		<?	
		}
		/*------------------*/
	}
    
	public function __doFbReturnAction()
	{
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
			
	 	/*------facebook------*/
		$user=new Application_Model_User();
		$result=$user->doFacebookLogin();
                $redirectUrl=$this->view->seoUrl('/gapper/where-i-am');
		if($result['email']=='no')
		{
                    ?>
                    <script language="javascript">
                           window.opener.location.href='<?php echo $redirectUrl?>';
                           window.close();
                    </script>
                    <?
                    //$this->_helper->redirector('update-my-email','gapper');
		}
		else
		{
                    ?>
                    <script language="javascript">
                           window.opener.location.href='<?php echo $redirectUrl?>';
                           window.close();
                    </script>
                    <?
			//$this->_helper->redirector('where-i-am','gapper');
		}
		/*------------------*/
	}
	
	
    
	public function loginAction()
    {
    	if (Zend_Auth::getInstance()->hasIdentity()){ // if user is already logged in then redirect to home page
    		$this->_helper->redirector("index","index");
    	}
    	
    	
    	
    	/*------facebook------*/
    	$facebook = $this->view->facebook();
		$return_url=Zend_Registry::get('siteurl')."/index/do-fb-return/";
		
		//scope=offline_access,publish_stream,read_stream&display=popup
		
		$this->view->loginUrl=$loginUrl = $facebook->getLoginUrl(array("next"=>$return_url,"req_perms"=>"offline_access,publish_stream,read_stream,email,user_birthday,user_location", "display"=>"popup"));
		//$this->view->loginUrl="https://graph.facebook.com/oauth/authorize?redirect_uri=$return_url&scope=offline_access,publish_stream,read_stream&client_id=102609193129645";
		/*------------------*/
		
		
    	
    	$request = $this->getRequest();
    	$this->view->form=$form=new Admin_Form_Login();
    	$elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    		
    	if ($request->isPost())
    	{
	    	if ($form->isValid($request->getPost())) 
	        {
	        	$params=$request->getParams();
	        	$Auth = new Base_Auth_Auth();
	        	$Auth ->doLogout();
	        	
	        	$loginStatusEmail=true;
	        	$loginStatusUsername=true;
	        	
	   			$loginStatusEmail=$Auth->doLogin($params, 'email');
	   			if($loginStatusEmail==false){
	   				$loginStatusUsername=$Auth->doLogin($params, 'username');
	   			}
	   			
	   			//$loginStatusUsername=$Auth->doLogin($params, 'username');
	   			if ($loginStatusEmail==false && $loginStatusUsername==false) 
				{
					
        	    
                                    $this->_helper->redirector('index','index',"default",array("msg"=>"le"));
				}
				else
				{				
					if($params['rememberMe']==1)
					{
						$Auth->remeberMe(true, $params);
					}
					//header("location: {$_SERVER['HTTP_REFERER']}");
					//$this->_helper->redirector('index','where-i-am');
                                        $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/where-i-am'));
				}
	        }
	        else {
	        	
	        	$this->_helper->redirector('index','index',"default",array("msg"=>"le"));
	        }
	        
    	}
    }



    public function loginModalAction()
    {
    	$this->_helper->layout->disableLayout();
    	$request = $this->getRequest();
    	$form=new Admin_Form_Login();
    	$error=0;
    	if ($request->isPost())
    	{
	    	if ($form->isValid($request->getPost()))
	        {
                    $params=$request->getParams();
                    $Auth = new Base_Auth_Auth();
                    $loginStatusEmail=true;
                    $loginStatusUsername=true;

                    $loginStatusEmail=$Auth->doLogin($params, 'email');
                    if($loginStatusEmail==false){
                            $loginStatusUsername=$Auth->doLogin($params, 'username');
                    }

                    //$loginStatusUsername=$Auth->doLogin($params, 'username');
                    if ($loginStatusEmail==false && $loginStatusUsername==false)
                    {
                        $error=1;
                    }
                    else
                    {
                            $error=0;
                            if($params['rememberMe']==1)
                            {
                                    $Auth->remeberMe(true, $params);
                            }
							else
							{
								$Auth->forgotMe('rememberMe'); //delete existing cookies as per new requirement
							}								
                    }
	        }
	        else
	        {
	        	$error=2;

	        }
    	}
    		$result=array("error"=>$error);
    	echo Zend_Json::encode($result);
    	exit;;
    }


    public function usernameAction()
    {
    	$request = $this->getRequest();
    	
    	$this->view->form=$form=new Application_Form_Forgot();
    	$elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    	
    	$options=$request->getParams();
    	
    	if ($request->isPost())
    	{
	    	if ($form->isValid($request->getPost())) 
	        {
	        	$model=new Application_Model_User();
		    	$model=$model->fetchRow("email='{$options['email']}'");
		    	if(false!==$model)
		    	{
		    		$Auth=new Base_Auth_Auth();
		    		$Auth->recoverUsername($model);
					$this->view->msg="Your username has been emailed to your email address.";
					$form->reset();	
		    	}
	        }
    	}
    	
    }    
    public function forgotAction()
    {
    	$request = $this->getRequest();
    	$this->view->form=$form=new Application_Form_Forgot();
    	$elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
    		$element->removeDecorator('label');
    	
    	$options=$request->getParams();
    	
    	if ($request->isPost())
    	{
	    	if ($form->isValid($request->getPost())) 
	        {
	        	$model=new Application_Model_User();
		    	$model=$model->fetchRow("email='{$options['email']}'");
		    	if(false!==$model)
		    	{
		    		$Auth=new Base_Auth_Auth();
		    		$Auth->recoverPassword($model);
                                //$this->view->msg="Your password has been reset and emailed to your email address.";
                                $msgNs=new Zend_Session_Namespace("app");
                                $msgNs->message="Your password has been reset and emailed to your email address.";
                                $form->reset();

                                return $this->_helper->redirector('forgot','index',"default");
		    	}
	        }
    	}

        $msgNs=new Zend_Session_Namespace("app");
        $this->view->msg=$msgNs->message;
        $msgNs->message="";
    }
    
	public function logoutAction()
    {
    	
    	
    	$Auth=new Base_Auth_Auth();
		$Auth->doLogout();
		/*
		 * @Commented By: Mahipal Adhikari
		 * @Commented On : 25-Nov-2010
		 * @Description: Do not delete cookies while loggig out as per new requirement logged in mantis(bug id: 250), (now according to the bug id : 742, we have to delete the cookies on log out action. They sucks...)
		 */
		$Auth->forgotMe('rememberMe');
    	
		/*---facebook logout---*/
    	$facebook = $this->view->facebook();
    	$session = $facebook->getSession();
    	if($session)
    	{
    		try {
		    	$uid = $facebook->getUser();
		    	$me = $facebook->api('/me');
		  	} catch (FacebookApiException $e) {
			    error_log($e);
			  }
    		
    		$logoutUrl = $facebook->getLogoutUrl(array("next"=>$_SERVER['HTTP_REFERER']));
    			
    	}    	
		
		//commented by Mahipal on 10-jan-2011, redirect user to home page always after logout
		$this->_helper->redirector->gotoUrl(Zend_Registry::get('siteurl'));		
		/*
		if($me)
		{
    		//$this->_helper->redirector->gotoUrl($logoutUrl );
		}
		else
		{
    		//$this->_helper->redirector->gotoUrl($_SERVER['HTTP_REFERER']);
		}*/
    	/*----------------------------*/
		exit;
    }
    
    public function registerAction()
    {    	
		//redirect user if already logged in
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/my-profile'));
		}
		//print_r($_SESSION);
		//set session if user comes in this page by referer, and keep sender user id in session
		$usersNs = new Zend_Session_Namespace("app");
		$sender_id = "";
		$sender_id = base64_decode($this->_getParam('sender'));
		if(isset($sender_id) && is_numeric($sender_id))
		{
			$usersNs->sender_id = $sender_id;
		}
		if($usersNs->sender_id)
		{
			$sender_id = $usersNs->sender_id;
		}
		//echo "sssss=".$sender_id;
		
		//unset facebook ID session here if already exists
		$usersNs->facebookId="";
		
		$form = new Application_Form_Register();
                $elements = $form->getElements();
    	
    	$form->clearDecorators();
    	foreach($elements as $element)
    	$element->removeDecorator('label');
    	
    	$this->view->fbmsg=$this->_getParam("fbmsg");
    	
        $this->view->form = $form;    	
        $this->view->successMsg="";
		$this->view->sender=$this->_getParam('sender');
        if ($this->getRequest()->isPost()) 
        {
            $params= $this->getRequest()->getPost();          
            if ($form->isValid($params)) 
            {
                $captchaNs = new Zend_Session_Namespace("captcha");
                $captchaAnswer = $captchaNs->captchaAnswer;
                $captchaCodes = $captchaNs->captchaCodes;
                
				if (substr($params['captcha'], 10) == $captchaCodes[$captchaAnswer])
				{
					$params['dob']=$params['year']."-".$params['month']."-".$params['day'];
					$params['status']='inactive';
					$params['userLevelId']=1;
					$password=$params['password'];
					$params['password']=md5($params['password']);
					
					/*----find gapper id ---*/
					$gapper_id=0;
					if($params['gapperOrFriend']=="friend")
					{
						$gapperM=new Application_Model_User();
						$gapper=$gapperM->getDataByUsername($params['usernameOfGapper']);
						if(false!==$gapper)
						{
							$gapper_id=$gapper->getId();
						}
					}
					$params['gapperId']=$gapper_id;
					/*----------------------*/
					
					$user		=	new Application_Model_User($params);
					$user_id	=	$user->save();
					
					if($user_id>0)
					{
						//If user has checked Newsletter, then insert in subscribe table
						if($params['newsletter']=="yes")
						{
							$user->newsletterSubscribe($user_id);
						}
						/*---- default permission settings ----*/					
						$user->setDefaultPermissions($user_id);
						$user->setDefaultJournal($user_id);					
						/*---------add a friend -------------*/
						//$sender_id=base64_decode($this->_getParam('sender'));
						$sender_id = $usersNs->sender_id;
						if($sender_id>0)
						{
							$senderM = new Application_Model_Friend();
							$senderM->addAsFriend($sender_id,$user_id);
							$senderM->addAsFriend($user_id,$sender_id);
						}
						/*-------------------------------------*/					
						$params['activate_link']=Zend_Registry::get('siteurl')."/index/activate/id/".base64_encode($user_id);
						$params['password']=$password;
						
						//$usersNs = new Zend_Session_Namespace("members");
						$usersNs->registration_id=$user_id;
						$mail=new Base_Mail();
						$mail->sendRegistrationMail($params);
						$this->_helper->redirector('invite','index',"default");
						
						//$this->view->successMsg="Your registration has been complete. <br> Please check your email to activate your account.";
					}
				}
				else
				{
					$_SESSION['captchaCodes'] = NULL;
					$_SESSION['captchaAnswer'] = NULL;
					$return['bool'] = 0;
					$this->view->captchaMsg = "Captcha code is not valid. Please refresh Captcha and drag it.";
				}				
            }//end if
        }//end if
    }//end function
 	
    public function inviteAction()
    {
    	//redirect user to "Add A Connection" page if already logged in
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/add-a-connection'));
		}
		
		//get user ID from registration session
		$usersNs	= new Zend_Session_Namespace("app");
        $userId		= base64_encode($usersNs->registration_id);
		//$userId = 106;
		//if user ID exists in session then proceed for invite
		if(isset($userId) && $userId!="")
		{
			$form = new Application_Form_Invite();
			
			//remove form fields
			$form->removeElement("name");
			
			$elements=$form->getElements();
			$form->clearDecorators();
			foreach($elements as $element)
				$element->removeDecorator('label');
				
			$this->view->form = $form;    	
			$this->view->successMsg="";
			if ($this->getRequest()->isPost()) 
			{
				$params= $this->getRequest()->getPost();          
				if ($form->isValid($params)) 
				{
					$errorMsg1	=	"";
					$errorMsg2	=	"";			
					$siteurl	=	Zend_Registry::get('siteurl');
					
					//get sender information
					$userM				=	new Application_Model_User();
					$userRes			=	$userM->find($usersNs->registration_id);//$userId
					$params["name"]		=	ucwords($userRes->getFirstName()." ".$userRes->getLastName());
					$params["email"]	=	$userRes->getEmail();
			
					$params['invitation_link']="{$siteurl}/index/register/sender/{$userId}";
					$mail	=	new Base_Mail();
					
					if(isset($params["inviteEmail"]))
					{
						if($params["contacts"]=="")
						{
							$errorMsg1 = "Please add your contacts.";
						}
						if($params["contacts"]!="")
						{
							$total_contacts = explode(",",$params['contacts']);
							$receiver_email = "";
							$emailValidateObj = new Zend_Validate_EmailAddress();
							$emailError = "";
							$contactEmail = array();
							for($i=0;$i<count($total_contacts);$i++)
							{
								$receiver_email = trim($total_contacts[$i]);
								if($receiver_email!="" && $emailValidateObj->isValid($receiver_email)==false)
								{
									$emailError .= "<br /><b>{$receiver_email}</b> is not a valid email address.";							
								}
								else
								{
									$contactEmail[] = $receiver_email;
								}						
							}
							if($emailError!="")
							{
								$errorMsg1	= "Please fix following error(s):".$emailError;						
							}
							//set valid emails in new option
							$params['contactEmail'] = $contactEmail;
						}
						$this->view->errorMsg1 = $errorMsg1;
						
						//if no errors found then send invitation email
						if($errorMsg1=="")
						{
							$comment_url = $siteurl."/index/register/sender/".$userId;
							$invitation_link = "<a href='".$comment_url."' target='_blank'>".$comment_url."</a>";
							$params["invitation_link"] = $invitation_link;
							$params["message"] = "Join Gap Daemon";
							$returnMail = $mail->sendInvitationToEmails($params); //send invitation email to contact entered by user
							$this->_helper->redirector('thanks','index',"default");
						}	
					}
					else
					{
						if($params['total_contacts']=="")
						{
							$errorMsg2 = "Please add your contacts.";
						}
						$this->view->errorMsg2 = $errorMsg2;
						
						//if no errors found then send invitation email
						if($errorMsg2=="")
						{
							$mail->sendInvitation($params); //send invitation email using open inviter
							$this->_helper->redirector('thanks','index',"default");
						}						
					}//end else	
				}//end if
			}//end if post
		}//end if isset UserID
		else
		{
			$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/index/register'));
		}	
    }
	public function thanksAction()
	{
		//redirect user if already logged in
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/my-profile'));
		}
		$skipInvite				=	$this->_getParam('skip-invite');
		$this->view->skipInvite	=	$skipInvite;
	}
	
    public function connectYourAccountAction()
    {
	    //get referer sender user Id from session
		$usersNs = new Zend_Session_Namespace("app");
		$sender_id = $usersNs->sender_id;		
		//echo "sssss=".$sender_id;
		
		$facebook = $this->view->facebook();
    	$session = $facebook->getSession();
		
		//echo "<pre>";
		//print_r($session);
		
    	if (!$session) {
    		$this->_helper->redirector("register","index","default");
    	}
    	
    	$uid = $facebook->getUser();
    	$me = $facebook->api('/me');
		
		//echo "<pre>";
		//print_r($me);
		//exit;
    	
    	$params['email']=$me['email'];
       
    	$arrBday=explode("/",$me['birthday']);
    	$params['year']		=	$arrBday[2];
    	$params['month']	=	$arrBday[0];
    	$params['day']		=	$arrBday[1];    	
    	$params['firstName']=	$me['first_name'];
    	$params['lastName']	=	$me['last_name'];
    	if(isset($me['gender']) && $me['gender']!="")
		{
			$params['sex']	=	$me['gender'];
		}
    
		$form = new Application_Form_Register();
		
		$form->populate($params);
    	$elements=$form->getElements();
    	$form->clearDecorators();
    	foreach($elements as $element)
		$element->removeDecorator('label');
		
		$this->view->fbmsg=$this->_getParam("fbmsg");
		$this->view->form = $form;    	
		$this->view->successMsg="";
		$this->view->sender=$this->_getParam('sender');
        
	if ($this->getRequest()->isPost()) 
        {
            $params= $this->getRequest()->getPost();
            $params['firstName']= $me['first_name'];
            $params['lastName'] = $me['last_name'];
            if(isset($me['gender']) && $me['gender']!="")
			{
				$params['sex'] = $me['gender'];
			}
				
            if ($form->isValid($params)) 
            {
            	$params['facebookId']=$uid;
            	$params['dob']=$params['year']."-".$params['month']."-".$params['day'];
            	$params['status']='inactive';
            	$params['userLevelId']=1;
            	$password=$params['password'];
                $params['password']=md5($params['password']);
                $params['status']="active";
                
                /*----find gapper id ---*/
                $gapper_id=0;
                if($params['gapperOrFriend']=="friend"){
                    $gapperM=new Application_Model_User();
                    $gapper=$gapperM->getDataByUsername($params['usernameOfGapper']);
                    if(false!==$gapper)
                    {
                            $gapper_id=$gapper->getId();
                    }
                }
                $params['gapperId']=$gapper_id;
                /*----------------------*/

                $user		=	new Application_Model_User($params);
                $user_id	=	$user->save();
                if($user_id>0)
                {
                    //If user has checked Newsletter, then insert in subscribe table
					if($params['newsletter']=="yes")
					{
						$user->newsletterSubscribe($user_id);
					}
					
					/*---- default permission settings ----*/
                    $user->setDefaultPermissions($user_id);
                    $user->setDefaultJournal($user_id);

                    /*-------------------------------------------*/

                    /*---------add a friend -------------*/
					
					
                    //$sender_id = base64_decode($this->_getParam('sender'));
                    //$senderM=new Application_Model_Friend();
					//$senderM->addAsFriend($sender_id,$user_id);
					$sender_id = $usersNs->sender_id;
					if($sender_id>0)
					{
						$senderM = new Application_Model_Friend();
						$senderM->addAsFriend($sender_id,$user_id);
						$senderM->addAsFriend($user_id,$sender_id);
					}	
                    /*-------------------------------------*/

                    $params['activate_link']=Zend_Registry::get('siteurl')."/index/activate/id/".base64_encode($user_id);
                    $params['password']=$password;

                   
                    $usersNs->registration_id=$user_id;
                    //$mail=new Base_Mail();
                    //$mail->sendRegistrationMail($params);

                    $usersNs = new Zend_Session_Namespace("app");
                    $usersNs->facebookId=$uid;
                    $this->_helper->redirector('invite','index',"default");
                }
            }
        }
       
}
	
	public function facebookConnectAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	 	/*------facebook------*/
		//$user=new Application_Model_User();
		//$result=$user->doFacebookLogin();
		
    	$facebook = $this->view->facebook();
    	$session = $facebook->getSession();
	if ($session) 
	{
    		$uid = $facebook->getUser();
    		$user=new Application_Model_User();
    		$where="facebook_id='{$uid}'";
    		$user=$user->fetchRow($where);
    		if(false===$user)
    		{
    			 ?>
                    <script language="javascript">
                           window.opener.location.href='/index/connect-your-account';
                           window.close();
                    </script>
                    <?
    		}
    		else
    		{
    			$result=$user->doFacebookLogin();

    			 ?>
                    <script language="javascript">
                           //window.opener.location.href='/index/register/fbmsg/ar';
                    window.opener.location.href='<?php echo $this->view->seoUrl("/gapper/where-i-am")?>';
                           window.close();
                    </script>
                    <?
    			//$this->_helper->redirector("register","index", "default",array("fbmsg"=>"ar"));
    		}
	}
	}
	
	
    
	public function cancelFacebookAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		?>
                    <script language="javascript">
                           //window.opener.location.href='/index/register';
               
                           window.close();
                    </script>
                    <?
	}
	
    public function loadContactsAction()
    {
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
		$email=$this->_getParam('email');          
		$password=$this->_getParam('password');
		$provider=$this->_getParam('provider');
		
        
		$ers=array();
		if (empty($email))
			$ers['email']="Email missing !";
		if (empty($password))
			$ers['password']="Password missing !";
		if (empty($provider))
			$ers['provider']="Provider missing !";
		if (count($ers)==0)
		{
                   // include_once(LIBRARY_PATH."/Base/OpenInviter/Base_OpenInviter_OpenInviter.php");
			$inviter=new Base_OpenInviter_OpenInviter();
			$oi_services=$inviter->getPlugins();
			$inviter->startPlugin($provider);
			$internal=$inviter->getInternalError();
			if ($internal)
			$ers['inviter']=$internal;
			elseif (!$inviter->login($email,$password))
			{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
			}
			elseif (false===$contacts=$inviter->getMyContacts())
			{
				$ers['contacts']="Unable to get contacts !";
			}
			
			
		}
		
    	if(count($ers)==0)
		{
			//print_r($contacts);
			$address=array();
			$address=array_keys($contacts);
                        $data="<input onchange='toggleAll(this)' style='width:20px' type='checkbox' value='contacts_all' id='contacts_all' name='contacts_all'><strong>Check All</strong><br/>";
                        $i=0;
                        foreach($contacts as $key=>$val)
                        {
                            $data.="<input style='width:20px' type='checkbox' value='{$key}' id='contacts_{$i}' name='contacts_{$i}'>{$val}<br/>";
                            $i++;
                        }
			//$data=implode(", ",$address);
			$result=array('error'=>0, 'data'=>$data, 'total_contacts'=>count($contacts),'oi_session_id'=>$inviter->plugin->getSessionID());
		}
		else
		{
			$ers=implode(", ",$ers);
			$result=array('error'=>1, 'data'=>$ers);
			
		}
		echo Zend_Json::encode($result);
    }
    public function activateAction()
    {
    	//redirect user if already logged in
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/my-profile'));
		}
		
		$id=base64_decode($this->_getParam('id'));
    	$model=new Application_Model_User();
    	$model=$model->find($id);
    	if(false===$model)
    	{
    		$this->view->msg="Invalid request. Please try again";
    	}
    	else
    	{
    		if($model->getStatus()=="inactive")
    		{
    			$model->setStatus('active');
    			$model->save();
    			$this->view->msg="Your account has been activated. Please login to access your account.";
    		}
    		else
    		{
    			$this->view->msg="Your account is already activated. Please login to access your account.";
    		}
    		
    	}
    }
  
    
    public function checkNickNameAction(){
    	$this->_helper->layout->disableLayout();	
    	$request = $this->getRequest();
    	$options=$request->getParams();
    	
    	$model=new Application_Model_User();
    	if(true===$model->isExist("nick_name='{$options['nickName']}'"))
    	{
    		$result=Array('error'=>1,'msg'=>"Nickname already exists.");	
    	}
    	else
    	{
    		$result=Array('error'=>0,'msg'=>"Nickname is available!");
    	}

    	echo Zend_Json::encode($result);
    	exit;
    }
    
      public function checkEmailAction(){
    	$this->_helper->layout->disableLayout();	
    	$request = $this->getRequest();
    	$options=$request->getParams();
    	
    	$model=new Application_Model_User();
    	if(true===$model->isExist("email='{$options['email']}'"))
    	{
    		$result=Array('error'=>1,'msg'=>"Email already exists.");	
    	}
    	else
    	{
    		$result=Array('error'=>0,'msg'=>"Email is available!");
    	}

    	echo Zend_Json::encode($result);
    	exit;
    }
    

    

	public function warningAction()
    {
            $this->view->headTitle("Unauthorized Access");
    }
    
    public function destinationsAction(){
    	$this->_helper->viewRenderer->setNoRender(true);
    }
 
	public function forumAction(){
    	$this->_helper->viewRenderer->setNoRender(true);
    }

    
    
    public function facebookAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	$facebook = new Base_Facebook_Facebook(array(
		  'appId'  => '102609193129645',
		  'secret' => 'b8ba71904d48df9f719be20a39e87764',
		  'cookie' => true,
		));
		$session = $facebook->getSession();
    	$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $facebook->getUser();
		    $me = $facebook->api('/me');
		  } catch (Base_Facebook_FacebookApiException  $e) {
		    error_log($e);
		  }
		}
		exit("tet");
    	if ($me) {
		  $logoutUrl = $facebook->getLogoutUrl();
		} else {
		  $loginUrl = $facebook->getLoginUrl();
		}

		print_r($me);
		if($me)
		{
			echo "	<a href='$logoutUrl'>
      					<img src='http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif'>
    				</a>";	
		}
		else
		{
			echo "	<a href='$loginUrl'>
      					<img src='http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif'>
    				</a>";	
			 
		}
		//echo $this->cdnUri();
    }
    
    

public function excelAction()
{
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);

	print "<pre>";
	
	
	$filename = "data/destinationlist.xls";

	$objPHPExcel = Base_Excel_PHPExcel_IOFactory::load($filename);

	echo date('H:i:s') . " Iterate worksheets\n";
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) 
	{
		//echo '- ' . $worksheet->getTitle() . "\r\n";

		foreach ($worksheet->getRowIterator() as $row) 
		{
			echo '    - Row number: ' . $row->getRowIndex() . "\r\n";
			if($row->getRowIndex()<>1){ //we do not need first row(column name)
				
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
				$counter=0;
				$arrRow=array();
				foreach ($cellIterator as $cell) 
				{
					$counter++;
					if (!is_null($cell)) 
					{
						//do database inserts here	
						if($counter==1){
							$arrRow['continent']=$cell->getCalculatedValue();
						}
						else if($counter==2){
							$arrRow['country']=$cell->getCalculatedValue();	
						}
						else if($counter==3){
							$arrRow['region']=$cell->getCalculatedValue();	
						}
						else if($counter==4){
							$arrRow['state']=$cell->getCalculatedValue();	
						}
						else if($counter==5){
							$arrRow['city']=$cell->getCalculatedValue();	
						}
						//echo '        - Cell: ' . $cell->getCoordinate() . ' - ' . $cell->getCalculatedValue() . "\r\n";
					}
					
				}
				
				//----insert into continent
				
					$continentM=new Application_Model_Continent();
					$continent=$continentM->fetchRow("name='{$arrRow['continent']}'");
					if(false===$continent){
						$continentM->setName($arrRow['continent']);
						$continent_id=$continentM->save();	
					}else{
						$continent_id=$continent->getId();
					}
				//--------------------------
				
				//----insert into country
				
					$countryM=new Application_Model_Country();
					$country=$countryM->fetchRow("name='{$arrRow['country']}'");
					if(false===$country){
						$countryM->setName($arrRow['country']);
						$countryM->setContinentId($continent_id);
						$country_id=$countryM->save();	
					}else{
						$country_id=$country->getId();
					}
					
				//-------------------------------
				
				
				
			}
			
		}
	}


}



public function friendsProfileAction()
{
	
	
	$id=$this->getRequest()->getParam('id');
	
	 $model=new Application_Model_User();
	 $viewprof=$model->find($id);
	  $this->view->viewprof=$viewprof;
	 

}
/**
* @Created By : Mahipal Singh Adhikari
* @Created On : 30-Nov-2010
* @Description: Used to accept/decline friend request and send email to users
*/
public function changeRequestAction()
{
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	
	$ctype		=	$this->getRequest()->getParam('ctype');
	$id			=	$this->getRequest()->getParam('id');
	$userid		=	$this->getRequest()->getParam('userid');
	$friendid	=	$this->getRequest()->getParam('friendid');
	$status		=	$this->getRequest()->getParam('status');
	
	$params['id']				=	$id;
	$params['userId']			=	$userid;
	$params['friendId']			=	$friendid;
	$params['status']			=	$status;
	$params['connectionType']	=	$ctype;
	
	$response	= "";
	$response	= "<span style='color:#EF4733;'>";
	
	$friend = "";
	$friendm = new Application_Model_Friend($params);
    $friend =  $friendm->save();
	
	if($friend)
	{
		//if request accepted then insert new row in reverse to make accepter as friend of requester
		if($status=="accept")
		{
			//delete any existing record sent from friend
			$delReqWhere = "user_id=$friendid AND friend_id=$userid";
			$delRes =  $friendm->delete($delReqWhere);
			
			//once deleted now insert new row to make accepter as friend of requester
			$params_u['userId']			=	$friendid;
			$params_u['friendId']		=	$userid;
			$params_u['status']			=	$status;
			$params_u['connectionType']	=	$ctype;
			$userm = new Application_Model_Friend($params_u);
			$user =  $userm->save();
		}
		
		//send email to requester for request confirmation
		$userObj = new Application_Model_User();
		
		//get accepter/sender information
		$Sender   = $userObj->find($friendid);
		$mailOptions['sender_email']= $Sender->getEmail();
		$mailOptions['sender_name']	= ucwords($Sender->getFirstName()).' '.ucwords($Sender->getLastName());
		
		//get requester/receiver information
		$Receiver   = $userObj->find($userid);
		$mailOptions['receiver_email']	= $Receiver->getEmail();
		//$mailOptions['receiver_email']	= "mahipal@profitbyoutsourcing.com";
		$mailOptions['receiver_name']	= ucwords($Receiver->getFirstName()).' '.ucwords($Receiver->getLastName());
		$mailOptions['req_status']		= ($status=="accept") ? "Accepted":"Declined";

		//send email only when request is not declined by user
		if($status!="decline")
		{
			$Mail	=	new Base_Mail();
			$Mail->acceptDeclineRequest($mailOptions);
		}
		//set confirmation message to display
		$response .= ($status=="accept") ? "Request has been accepted.":"Request has been declined.";
	}
	else
	{
		$response .= "Error occured. Please try again later.";
	}
	$response	.= "</span>";
	//sleep(5);
	echo $response;
	exit;
}

public function changeProfileAction()
{
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	$ctype=$this->getRequest()->getParam('ctype');
	$id=$this->getRequest()->getParam('id');
	$userid=$this->getRequest()->getParam('userid');
	$friendid=$this->getRequest()->getParam('friendid');

	$params['id']=$id;
	//$params['friendId']=$id;
	$params['userId']=$userid;
	$params['friendId']=$friendid;
	$params['status']='accept';

	$params['connectionType']=$ctype;

	$friendm = new Application_Model_Friend($params);
	$friend =  $friendm->save();
}

public function deleteProfileAction()
{
    $id=$this->getRequest()->getParam('id');
    $friendm = new Application_Model_Friend();
    $userdata = $friendm->find($id);
    
    $userId = $userdata->getUserId();
    $friendId = $userdata->getFriendId();
    
    $friendm->delete("id = $id");
    $friendm->delete("user_id = $friendId and friend_id=$userId");
    $this->_redirect('/gapper/my-friends');
 }




public function xmlAction()
{
	
	$this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(true);
	echo "<pre>";
	$filename = "data/sample - Chiang Mai.xml";
	$xml_parser = new Base_Xml_Parser(null, $filename); 
	
	$continentName=$xml_parser->Data['identification']['geoTag1'];
	$countryName=$xml_parser->Data['identification']['geoTag2'];
	$cityName=$xml_parser->Data['identification']['geoTag3'];
	$regionName=$cityName;
	$stateName=$cityName;
	//----insert into continent
		$continent_id=0;
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
	//--------------------------
	
	//----insert into country
		$country_id=0;
		$countryM=new Application_Model_Country();
		$country=$countryM->fetchRow("name='{$countryName}' and continent_id='{$continent_id}'");
		if(false===$country){
			$countryM->setName($countryName);
			$countryM->setContinentId($continent_id);
			$country_id=$countryM->save();	
		}else{
			$country_id=$country->getId();
		}
		
	//-------------------------------

		
	///------insert into region
		$region_id=0;
		$regionM=new Application_Model_Region();
		$region=$regionM->fetchRow("name='{$regionName}' and country_id='{$country_id}'");
		if(false===$region){
			$regionM->setName($regionName);
			$regionM->setCountryId($country_id);
			$region_id=$regionM->save();	
		}else{
			$region_id=$region->getId();	
		}
	//------------------------
 
	///------insert into state
		$state_id=0;
		$stateM=new Application_Model_State();
		$state=$stateM->fetchRow("name='{$stateName}' and region_id='{$region_id}'");
		if(false===$state){
			$stateM->setName($stateName);
			$stateM->setRegionId($region_id);
			$state_id=$stateM->save();	
		}else{
			$state_id=$state->getId();	
		}
	//------------------------
		
		
	///------insert into city
		$city_id=0;
		$cityM=new Application_Model_City();
		$city=$cityM->fetchRow("name='{$cityName}' and country_id='{$state_id}'");
		if(false===$city){
			$cityM->setName($cityName);
			$cityM->setCountryId($country_id);
			$city_id=$cityM->save();	
		}else{
			$city_id=$city->getId();	
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
	
	///////////Remove/////////
	$destinationM=new Application_Model_Destination();
	$destinationM->delete();
	$experiencesM=new Application_Model_Experiences();
	$experiencesM->delete();
	$practicalitiesM=new Application_Model_Practicalities();
	$practicalitiesM->delete();
	//------------------------------
	
	
	
	
	$title=$xml_parser->Data['content']['title'];
	$introduction=$xml_parser->Data['content']['introduction'];
	$destinationM=new Application_Model_Destination();
	$destinationM->setTitle($title);
	$destinationM->setIntroduction($introduction);
	$destinationM->setLocationId($locationId);
	$destinationM->setLocationType($locationType);
	$destination_id=$destinationM->save();

	
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
	
	
	//print_r($xml_parser->Data); 
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
* @Created By : Mahipal Singh Adhikari
* @Created On : 17-Nov-2010
* @Description: Used to display login page and when guest user try to access private pages
*/
public function userLoginAction()
{
	// if user is already logged in then redirect to were-I-am page
	if(Zend_Auth::getInstance()->hasIdentity())
	{
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/where-i-am'));
	}
	if($this->_getParam("msg")=="le")
	{
		$this->view->message="Incorrect details entered: please try again.";
    }
	else if($this->_getParam('msg')=="hle")
	{
		$this->view->message="Incorrect details entered: please try again.";
    }
	$request = $this->getRequest();
	if ($request->isPost())
	{
		$params=$request->getParams();
		$Auth = new Base_Auth_Auth();
		$Auth ->doLogout();

		$loginStatusEmail=true;
		$loginStatusUsername=true;

		$loginStatusEmail=$Auth->doLogin($params, 'email');
		if($loginStatusEmail==false)
		{
			$loginStatusUsername=$Auth->doLogin($params, 'username');
		}

		//$loginStatusUsername=$Auth->doLogin($params, 'username');
		if ($loginStatusEmail==false && $loginStatusUsername==false) 
		{
			$this->_helper->redirector('user-login','index',"default",array("msg"=>"le"));
		}
		else
		{
			if($params['rememberMe']==1)
			{
				$Auth->remeberMe(true, $params);
			}
			else
			{
				$Auth->forgotMe('rememberMe');//delete existing cookies as per new requirement
			}
			//if reffered from secured pages
			if($_SESSION['session_redirect_url'])
			{
				$redirect_url = $_SESSION['session_redirect_url'];
				unset($_SESSION['session_redirect_url']);
				header("location:".$redirect_url);
				exit;
			}
			else
			{
                $this->_helper->_redirector->gotoUrl($this->view->seoUrl('/gapper/where-i-am'));
			}	
		}//else		
	}//end of if
}//end of function
	

	public function appLoginAction()
	{
		//$this->_helper->layout->setLayout('home-layout');
		$this->_helper->layout->disableLayout();
		$appNs = new Zend_Session_Namespace("app");
		$request = $this->getRequest();
	    if($request->isPost())    
		{
			$params=$request->getParams();
			if(strtolower($params['test_username'])=="gdbetatest" && strtolower($params['test_password'])=="tester1")
			{
				$appNs->userName = $params['test_username'];
				$appNs->password = $params['test_password'];
				$this->_helper->redirector('index','index');
			}
			else
			{
				$this->view->msg="Incorrect details entered: please try again.";
			}
		}
    	
	}
	
	function captchaBackUpAction() {
                $requestVars = isset($_REQUEST) ? $_REQUEST : array();

                switch($requestVars['action']) {
                    case 'verify':
                        if (substr($requestVars['captcha'], 10) == $_SESSION['captchaCodes'][$_SESSION['captchaAnswer']]) {
                            echo json_encode(array('status' => 'success'));
                        } else {
                            $_SESSION['captchaCodes'] = NULL;
                            $_SESSION['captchaAnswer'] = NULL;
                            echo json_encode(array('status' => 'error'));
                        }

                        break;
                    case 'refresh':
                        $captchaImages = array(	array(	'label'	=> 'star',
                                        'on'		=> array(	'top'		=> '-120px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-120px',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'heart',
                                        'on'		=> array(	'top'		=> '0',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '0',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'bwm',
                                        'on'		=> array(	'top'		=> '-56px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-56px',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'diamond',
                                        'on'		=> array(	'top'		=> '-185px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-185px',
                                                'left'	=> '-66px'),
                                )
                        );

                        $captchaCodes = array(	'star'		=> md5(mt_rand(00000000, 99999999)),
                                'heart'		=> md5(mt_rand(00000000, 99999999)),
                                'bwm' 		=> md5(mt_rand(00000000, 99999999)),
                                'diamond' => md5(mt_rand(00000000, 99999999))
                        );
                        shuffle($captchaImages);
                        $randomCaptcha = array_rand($captchaImages);

                        $_SESSION['captchaAnswer'] = $captchaImages[$randomCaptcha]['label'];
                        $_SESSION['captchaCodes'] = $captchaCodes;

                        //HTML output
                        echo '<div class="captchaWrapper" id="captchaWrapper">';

                        foreach ($captchaImages as $count => $captchaImage) {
                            echo '	<a href="#" class="captchaRefresh"></a>
							<div	id="draggable_' . $captchaCodes[$captchaImage['label']] . '" 
										class="draggable" 
										style="left: ' . (($count * 68) + 15) . 'px; background-position: ' . $captchaImage['on']['top'] . ' ' . $captchaImage['on']['left'] . ';"></div>';
                        }

                        echo '	<div class="targetWrapper">
							<div	class="target" 
										style="background-position: ' . $captchaImages[$randomCaptcha]['off']['top'] . ' ' . $captchaImages[$randomCaptcha]['off']['left'] . ';"></div>
						</div>
						<input type="hidden" class="captchaAnswer" name="captcha" value="" />
					</div>';

                        break;
                }
                exit;
            }

            function captchaAction() {
              
                $requestVars = $this->getRequest()->getParams();
              
                $captchaNs = new Zend_Session_Namespace("captcha");

                switch($requestVars['actionc']) {

                    case 'verify':
                        $captchaAnswer = $captchaNs->captchaAnswer;
                        $captchaCodes = $captchaNs->captchaCodes;
                        if (substr($requestVars['captcha'], 10) == $captchaCodes[$captchaAnswer]) {
                            echo Zend_Json::encode(array('status' => 'success'));
                        } else {
                            $captchaNs->captchaAnswer = NULL;
                            $captchaNs->captchaCodes = NULL;
                            //echo json_encode(array('status' => 'error'));
                            echo Zend_Json::encode(array('status' => 'error'));
                        }

                        break;
                    
                    case 'refresh':
                    case 'captcha':
                        $captchaImages = array(	array(	'label'	=> 'star',
                                        'on'		=> array(	'top'		=> '-120px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-120px',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'heart',
                                        'on'		=> array(	'top'		=> '0',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '0',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'bwm',
                                        'on'		=> array(	'top'		=> '-56px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-56px',
                                                'left'	=> '-66px'),
                                ),
                                array(	'label'	=> 'diamond',
                                        'on'		=> array(	'top'		=> '-185px',
                                                'left'	=> '-3px'),
                                        'off'		=> array(	'top'		=> '-185px',
                                                'left'	=> '-66px'),
                                )
                        );

                        $captchaCodes = array('star' => md5(mt_rand(00000000, 99999999)),
                                'heart'	=> md5(mt_rand(00000000, 99999999)),
                                'bwm' 	=> md5(mt_rand(00000000, 99999999)),
                                'diamond' => md5(mt_rand(00000000, 99999999))
                        );
                        shuffle($captchaImages);
                        $randomCaptcha = array_rand($captchaImages);
                       
                        $captchaNs->captchaAnswer = $captchaImages[$randomCaptcha]['label'];
                        $captchaNs->captchaCodes  = $captchaCodes;

                        //HTML output
                        echo '<div class="captchaWrapper" id="captchaWrapper">';

                        foreach ($captchaImages as $count => $captchaImage) {
                            echo '	<a href="#" class="captchaRefresh"></a>
							<div	id="draggable_' . $captchaCodes[$captchaImage['label']] . '"
										class="draggable"
										style="left: ' . (($count * 68) + 15) . 'px; background-position: ' . $captchaImage['on']['top'] . ' ' . $captchaImage['on']['left'] . ';"></div>';
                        }

                        echo '	<div class="targetWrapper">
							<div	class="target"
										style="background-position: ' . $captchaImages[$randomCaptcha]['off']['top'] . ' ' . $captchaImages[$randomCaptcha]['off']['left'] . ';"></div>
						</div>
						<input type="hidden" class="captchaAnswer" name="captcha" value="" />
					</div>';

                        break;
                }
                
                $this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
            }
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 18-Jan-2011
	 * @Description	: Subscribe for newsletter functionality and send email to user
	 */
	//currently this function not in use
	public function newsletterSubscribe1234Action()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get logged in user ID
		$usersNs = new Zend_Session_Namespace('members');
		$user_id = $usersNs->userId;
		if($user_id=="" || $user_id==0)
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Please login to subscribe." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		$userM		=	new Application_Model_User();
		$userRes	=	$userM->find($user_id);
		
		if($userRes)
		{
			$updateMsg = "";
			$linkLabel = "";
			$newsStatus = "";
			
			if($userRes->getNewsletter()!="" && $userRes->getNewsletter()=="yes")
			{
				$JsonResultArray = Array('error'=>1, 'response'=>"You've already subscribed to our newsletter.");
				//$updateMsg = "Sorry to see you go.  You have been successfully unsubscribed.";
				//$linkLabel = "Subscribe";
				//$newsStatus = "no";
			}
			else
			{
				$newsStatus = "yes";
				$updateMsg = "Thanks for subscribing!";
				$linkLabel = "Unsubscribe";
				
				$dbRes		=	$userM->newsletterSubscribe($user_id, $newsStatus);
				if($dbRes)
				{
					//Now send confirmation email to user
					$mailOptions['receiver_email']	= trim($userRes->getEmail());
					$mailOptions['receiver_name']	= ucwords($userRes->getFirstName());
					$mailOptions['user_id']			= base64_encode($userRes->getId());					
					
					//create mail class object and send the email
					$Mail	=	new Base_Mail();
					$Mail->sendNewsletterSubscriptionEmail($mailOptions);
					
					//send response
					$JsonResultArray = Array('error'=>2, 'response'=>$updateMsg, 'linkLabel'=>$linkLabel);
				}
				else
				{
					$JsonResultArray = Array('error'=>1, 'response'=>"Error occured, please try again later.");
				}				
			}
		}
		else
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Invalid request: User not found.");
		}
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 19-Jan-2011
	 * @Description	: Subscribe for newsletter functionality and send email to user
	 */
	public function newsletterSubscribeAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get logged in user ID
		$usersNs = new Zend_Session_Namespace('members');
		$user_id = $usersNs->userId;
		if($user_id=="" || $user_id==0)
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Please login to subscribe." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		$userM		=	new Application_Model_User();
		$userRes	=	$userM->find($user_id);
		
		if($userRes)
		{
			//get user subscription info
			$subscribeM		=	new Application_Model_Subscribe();
		    $subscribeRes	=	$subscribeM->fetchRow("user_id={$user_id}");
			
			$updateMsg = "";
			$linkLabel = "";
			$newsStatus = "";
			//echo "sss=".;
			//print_r($subscribeRes);exit;
			if($subscribeRes && $subscribeRes->getStatus()==1)
			{
				$JsonResultArray = Array('error'=>1, 'response'=>"You've already subscribed to our newsletter.");
			}
			else
			{
				$dbRes		=	$userM->newsletterSubscribe($user_id);
				if($dbRes)
				{
					//set message
					$updateMsg = "Thanks for subscribing!";
					$linkLabel = "Unsubscribe";
				
					//Now send confirmation email to user
					$mailOptions['receiver_email']	= trim($userRes->getEmail());
					$mailOptions['receiver_name']	= ucwords($userRes->getFirstName());
					$mailOptions['user_id']			= base64_encode($userRes->getId());					
					
					//create mail class object and send the email
					$Mail	=	new Base_Mail();
					$Mail->sendNewsletterSubscriptionEmail($mailOptions);
					
					//send response
					$JsonResultArray = Array('error'=>2, 'response'=>$updateMsg, 'linkLabel'=>$linkLabel);
				}
				else
				{
					$JsonResultArray = Array('error'=>1, 'response'=>"Error occured, please try again later.");
				}				
			}
		}
		else
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Invalid request: User not found.");
		}
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}
		
    /**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 18-Jan-2011
	 * @Description	: Unsubscribe user from newsletter service
	 */
	public function newsletterUnsubscribeAction()
	{
		$user_id	= $this->_getParam('user_id');
		$user_id	= base64_decode($user_id);		
		
		if($user_id=="" || !is_numeric($user_id) || $user_id==0)
		{
			$this->view->errorMsg = "Invalid request: No user fond, please make sure that you are addressing correct page URL.";
		}
		else
		{
			$userM		=	new Application_Model_User();
			$userRes	=	$userM->find($user_id);
				
			if($userRes)
			{
				//get user subscription info
				$subscribeM		=	new Application_Model_Subscribe();
				$subscribeRes	=	$subscribeM->fetchRow("user_id={$user_id}");
				
				//if($userRes->getNewsletter()!="" && $userRes->getNewsletter()=="yes")
				if($subscribeRes)
				{
					$dbRes		=	$userM->newsletterSubscribe($user_id, 0);
					//$dbRes		=	$subscribeM->delete("user_id={$user_id}");
					if($dbRes)
					{
						$this->view->errorMsg = "Sorry to see you go.  You have been successfully unsubscribed.";
					}
					else
					{
						$this->view->errorMsg = "Error occured, please try again later.";
					}
				}
				else
				{					
					$this->view->errorMsg = "You've already unsubscribed from our newsletter service.";			
				}
			}
			else
			{
				$this->view->errorMsg = "Invalid request: No user fond, please make sure that you are addressing correct page URL.";
			}		
		}//else
	}//end function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 27-Jan-2011
	 * @Description	: Report Journal/Wall and other items as abuse to admin
	 */
	public function reportAbuseAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get request parameters
		$item_id	= $this->_getParam('item_id');
		$item_type	= $this->_getParam('item_type');
		
		//get logged in user ID
		$usersNs = new Zend_Session_Namespace('members');
		$user_id = $usersNs->userId;
		
		if($user_id=="" || $user_id==0)
		{
			$JsonResultArray = Array('error'=>1, 'response'=>"Please login to report abuse." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		if($item_id=="" || $item_id==0)
		{
			$JsonResultArray = Array('error'=>2, 'response'=>"No item is selected to report abuse." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		if($item_type=="")
		{
			$JsonResultArray = Array('error'=>2, 'response'=>"No item type is selected to report abuse." );
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		
		//Get user report abuse info for item
		$modelM		=	new Application_Model_ReportAbuse();
		$modelRes	=	$modelM->fetchRow("item_id={$item_id} AND item_type='{$item_type}' AND user_id={$user_id}");
		
		if($modelRes && $modelRes->getStatus()==1)
		{
			$JsonResultArray = Array('error'=>2, 'response'=>"You've already reported this as abuse.");
			echo Zend_Json::encode($JsonResultArray);
			exit;
		}
		else
		{
			$params["itemId"]	= $item_id;
			$params["itemType"]	= $item_type;
			$params["userId"]	= $user_id;
			$params["comment"]	= "";
			$params["status"]	= 1;
			
			$modelM->setOptions($params);
			$dbRes = $modelM->save();
			
			if($dbRes)
			{
				//get item type information
				$itemTitle = "";
				$authorId = "";
				$author = "";
				if($item_type=='blog')
				{
					$blogM		=	new Application_Model_Blog();
					$blogRes	=	$blogM->find($item_id);
					$itemTitle  = 	$blogRes->getTitle();
					$authorId	=	$blogRes->getUserId();
					
					$blog_url = Zend_Registry::get('siteurl')."/journal/view-post/blog_id/".$item_id;
					$itemTitle = "<a href='".$blog_url."' target='_blank'>".$itemTitle."</a>";
				}
				else if($item_type=='wall')
				{
					$wallM		=	new Application_Model_Wall();
					$wallRes	=	$wallM->find($item_id);
					$itemTitle  = 	$wallRes->getStatus();
					$authorId	=	$wallRes->getUserId();
				}
				else if($item_type=='photo')
				{
					$objModelAlbumPhoto		=	new Album_Model_AlbumPhoto();
					$albumPhotoRes	=	$objModelAlbumPhoto->find($item_id);
					$itemTitle  	= 	$albumPhotoRes->getName();
					$authorId		=	$albumPhotoRes->getUserId();
				}
				
				//get Blog/Wall owner/author user information
				if($authorId!="")
				{
					$useAuthor	= 	new Application_Model_User();
					$authorRes	=	$useAuthor->find($authorId);
					$author		=	ucfirst($authorRes->getFirstName())." ".ucfirst($authorRes->getLastName())." (".$authorRes->getUsername().")";
				}
				
				//get user information who is reporting abuse item
				$userM	= 	new Application_Model_User();
				$userR	=	$userM->find($user_id);
				$reporterName		=	ucfirst($userR->getFirstName())." ".ucfirst($userR->getLastName())." (".$userR->getUsername().")";
				$reporterEmail		=	$userR->getEmail();
				
				//Now send report abuse email to Administrator
				$settings		= new Admin_Model_GlobalSettings();
				$admin_email	= $settings->settingValue('report_abuse');
				//$admin_email	= "mahipal@profitbyoutsourcing.com";
				
				$mailOptions['receiver_email']	= $admin_email;
				$mailOptions['item_type']		= ucfirst($item_type);
				$mailOptions['item_title']		= $itemTitle;
				$mailOptions['item_author']		= $author;
				$mailOptions['reporter_name']	= $reporterName;
				$mailOptions['reporter_email']	= $reporterEmail;					
				
				//create mail class object and send the email
				$Mail	=	new Base_Mail();
				$Mail->sendReportAbuseEmail($mailOptions);
					
				//send response
				$JsonResultArray = Array('error'=>3, 'response'=>"Consider it reported!");
			}
			else
			{
				$JsonResultArray = Array('error'=>2, 'response'=>"Error occured, please try again later.");
			}				
		}
		
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 25-Feb-2011
	 * @Description	: Check user login
	 */
	public function checkUserLoginAction()
	{
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		//get request parameters
		//$user_id	= $this->_getParam('user_id');
		
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			//$usersNs	= new Zend_Session_Namespace('members');
			//$login_id	= $usersNs->userId;
			$JsonResultArray = Array('error'=>1, 'response'=>"User is logged in.");
		}
		else
		{
			//$JsonResultArray = Array('error'=>2, 'response'=>"User is not logged in.");
			//above line commented by mahipal on 5-march-2011, now any guest user can access user profiles
			$JsonResultArray = Array('error'=>1, 'response'=>"User is logged in.");
		}
		echo Zend_Json::encode($JsonResultArray);
		exit;
	}//end function
	
	/**
	 * @Created By	: Mahipal Singh Adhikari
	 * @Created On	: 2-Mar-2011
	 * @Description	: Invite facebook friends
	 */
	public function inviteFacebookFriendsAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$siteurl	= Zend_Registry::get('siteurl');
		
		//get facebook API, Secrete keys etc from config
		$facebook = $this->view->facebook();
		//print_r(get_class_methods($facebook));
		
		$app_id = $facebook->getAppId();
		$app_secret = $facebook->getApiSecret();
		$my_url = "{$siteurl}/index/invite-facebook-friends";
		//echo "appid={$app_id} app_secret={$app_secret} my_url={$my_url}";exit;
		$errorMsg = "";
		$code = "";
		if(isset($_REQUEST["code"]))
		{
			$code = $_REQUEST["code"];
		}
		
		//check user login or registration session
		$senderId	= "";
		$usersNs	= new Zend_Session_Namespace("members");
		if(isset($usersNs->userId) && $usersNs->userId!="")
		{
			$senderId	= base64_encode($usersNs->userId);
		}
		else
		{
			$senderId	= base64_encode($usersNs->registration_id);
		}
		if($senderId!="")
		{
			
			$invitation_link = "{$siteurl}/index/register/sender/{$senderId}";

			if(empty($code))
			{
				$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&scope=publish_stream&redirect_uri=" . urlencode($my_url);
				echo("<script> top.location.href='".$dialog_url."'</script>");
			}

			$token_url		= "https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&redirect_uri=".urlencode($my_url)."&client_secret=".$app_secret."&code=".$code;
			$access_token	= @file_get_contents($token_url);
			$graph_url		= "https://graph.facebook.com/me/friends/?".$access_token;

			$user = json_decode(@file_get_contents($graph_url));
			$s = curl_init();
			
			foreach($user->data as $value)
			{
				$userid=$value->id;
				$postFields=array();
				//$postFields['access_token']=$access_token;
				$postFields['link']			= $invitation_link;
				$postFields['picture']		= "{$siteurl}/images/logo.png";
				$postFields['name']			= "Join Gap Daemon";
				$postFields['caption']		= "Your Ultimate Travel Guide";
				$message = "Gap Daemon is a great resource for gap year travellers and other backpackers, allowing you to:";
				$message .= "(1)Keep in touch with friends and family.(2)Get access to useful, up-to-date travel advice.(3)Join the best gap year community on the web.";
				$postFields['description']	= $message;

				$url = "https://graph.facebook.com/".$userid."/feed/?".$access_token;

				curl_setopt($s,CURLOPT_URL,$url); 
				curl_setopt($s,CURLOPT_POST,true);
				curl_setopt($s,CURLOPT_POSTFIELDS,$postFields);
				ob_start();
				if(curl_exec($s))
				{
					//print $value->name ."has been invited <br>";
				}
				ob_clean();
			}//end foreach
			
			$errorMsg = "Thank you for inviting your friends to Gap Daemon!";
		}
		else
		{
			$errorMsg = "You are not authorise to access this page.";
		}
		
		//set view and message
		$this->view->errorMsg = $errorMsg;
		if($code!="")
		{
			$this->_helper->viewRenderer->setNoRender(false);
		}		
	}//end function

    public function facebookInviteAction()
    {
        $this->view->msg=$this->_getParam('msg');
        $this->_helper->layout->setLayout('facebook-popup');
        $siteurl	= Zend_Registry::get('siteurl');
        //check user login or registration session
        $senderId	= "";
        $usersNs	= new Zend_Session_Namespace("members");
        if(isset($usersNs->userId) && $usersNs->userId!="")
        {
            $senderId = base64_encode($usersNs->userId);
        }
        else
        {
            $usersNs	= new Zend_Session_Namespace("app");
            $senderId = base64_encode($usersNs->registration_id);
        }
        
        if($senderId!="")
        {
            $invitation_link = "{$siteurl}/index/register/sender/{$senderId}";
            $facebook = $this->view->facebook();
            $session = $facebook->getSession();
            if ($session)
            {
               if ($this->getRequest()->isPost())
                {
                    $params = $this->getRequest()->getPost();
                    if(isset($params['facebook_contacts']) && count($params['facebook_contacts'])>0)
                    {
                        foreach($params['facebook_contacts'] as $fbid)
                        {
                            $postFields['link']			= $invitation_link;
                            $postFields['picture']		= "{$siteurl}/images/logo.png";
                            $postFields['name']			= "... Wants You to Join Gap Daemon";
                            $postFields['caption']		= "The Ultimate Gap Year Site";
                            $postFields['description'] = "Don't leave home without Gap Daemon: get top-notch travel guides, keep a journal of your trip and invite friends and family along for the ride";
                            $statusUpdate = $facebook->api('/'.$fbid.'/feed', 'post', $postFields);
                            
                        }
                        $this->_helper->redirector('facebook-invite','index',"default",array("msg"=>"s"));
                    }
                    else
                    {
                        $friends = $facebook->api('/me/friends');
                        $this->view->friends=$friends['data'];
                        $this->view->msg="Please select the friends you want to send invitation message.";
                    }
                }
                else
                {
                    $friends = $facebook->api('/me/friends');
                    $this->view->friends=$friends['data'];
                }
                
                /*---Send a email to me--*/
                /*
				ob_start();
                echo "<pre>";
                var_dump($friends);
                echo "</pre>";
                $output=ob_get_clean();
                $mail=new Base_Mail();
				$mail->setBodyHtml ( $output);
				$mail->setFrom ("ritesh@ortegra.com", "Ritesh");
				$mail->addTo("ritesh@ortegra.com");
				$mail->setSubject ("Facebook Invitation [ $siteurl ] [ ".$_SERVER['REMOTE_ADDR']." ] [".date("Y-m-d H:i:s")."]");
				$mail->send();
				*/
                /*-----------------------*/
            }
        }
            
    }

   

}//end of class
