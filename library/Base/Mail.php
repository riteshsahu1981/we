<?php
class Base_Mail extends Zend_Mail 
{

        public function send($transport = null)
        {
            //return parent::send($transport);
            /*if ($transport === null) {

                $config = array('auth' => 'login',
                'username' => 'donotreply@GapDaemon.com',
                'password' => 'Bettera11!',
                    'ssl'=>'ssl',
                    'port'=>'465'

                    );
                $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            }*/
            //return parent::send($transport);
        }
        
        
       public function sendRequestNotification($requestId)
       {
            $request=new Application_Model_Request();
            $request=$request->find($requestId);
            if(false===$request)
            {
                return false;   
            }

            $departmentId=$request->getDepartmentId();
            $user=new Application_Model_User();
            $users=$user->fetchAll("department_id='{$departmentId}' and status='active'");
            if(count($users)==0)
                return false;
            $emails=array();
            foreach($users as $_user)
            {
                $emails[$_user->getFirstName()." ".$_user->getLastName()]=$_user->getEmail();
            }
            
            if(count($emails)==0)
                return false;
            
            $user=new Application_Model_User();
            $requestedBy=$user->find($request->getRequestedBy());
            
            
            $from_email=$this->settingValue('admin_email');
            $from_name=$this->settingLable('admin_email');
            
            /*---Template-----*/
            $template=$this->getEmailTemplate('request_notification_email');		
            $htmlBody=$template['body'];
            $htmlBody=str_replace("__REQUESTER_NAME__", $requestedBy->getFirstName()." ".$requestedBy->getLastName(), $htmlBody);
            $htmlBody=str_replace("__REQUESTER_EMAIL__", $requestedBy->getEmail(), $htmlBody);
            $htmlBody=str_replace("__REQUESTER_EMP_CODE__", $requestedBy->getEmployeeCode(), $htmlBody);
            $htmlBody=str_replace("__REQUEST__", $request->getRequest(), $htmlBody);
            /*---------------------*/
            
            $subject=$template['subject'];
            $this->setBodyHtml ( $htmlBody);
            $this->setFrom ($from_email, $from_name);
            $this->addTo($emails);
            $this->setSubject ($subject);
            $this->send();
           
       }
        
        
        
	private function settingValue($identifire='support_email')
	{
		$settings=new Application_Model_GlobalSettings();
		$value= $settings->settingValue($identifire);
		return $value;
	}
	
	private function settingLable($identifire='support_email')
	{
		$settings=new Application_Model_GlobalSettings();
		
		$row=$settings->fetchRow("identifire='$identifire'");
		return $row->getLabel();
	}
	
	private function getEmailTemplate($emailTemplateIdentifire)
	{
		$template=new Application_Model_EmailTemplate();
		
		$where="identifire='{$emailTemplateIdentifire}'";
	
		$row=$template->fetchRow($where);
		$array['body']=$row->getBody();
		$array['subject']=$row->getSubject();
		$array['name']=$row->getName();
		$array['identifire']=$row->getIdentifire();
		return $array;
	}
	
	public function sendRegistrationMail($options)
	{
		
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('registration_email');		
		$htmlBody=$template['body'];
		//$htmlBody=str_replace("__NAME__", $options ['firstName']." ".$options ['lastName'], $htmlBody);
                $htmlBody=str_replace("__NAME__", $options['firstName']." ".$options['lastName'], $htmlBody);
		$htmlBody=str_replace("__FIRSTNAME__", $options ['firstName'], $htmlBody);
                $htmlBody=str_replace("__LASTNAME__", $options ['lastName'], $htmlBody);
		$htmlBody=str_replace("__EMAIL__", $options ['email'], $htmlBody);
                $htmlBody=str_replace("__USERNAME__", $options ['username'], $htmlBody);
		$htmlBody=str_replace("__PASSWORD__", $options ['password'], $htmlBody);
		$htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		$htmlBody=str_replace("__ACTIVATE_LINK__", "<a href='".$options['activate_link']."'>".$options['activate_link']."</a>", $htmlBody);
		
		/*---------------------*/

		$subject=$template['subject'];
		$this->setBodyHtml ( $htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($subject);
		$this->send();		
	}

	public function sendForgotMail($options)
	{
	   //echo "<pre>";
	  // print_r($options);
	   //exit;
	   
		
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('forgot_password_email');		
		$htmlBody=$template['body'];
		$htmlBody=str_replace("__NAME__", $options['firstName']." ".$options['lastName'], $htmlBody);
                $htmlBody=str_replace("__FIRSTNAME__", $options ['firstName'], $htmlBody);
                $htmlBody=str_replace("__LASTNAME__", $options ['lastName'], $htmlBody);
                
		$htmlBody=str_replace("__PASSWORD__", $options['password'], $htmlBody);
		$htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		/*---------------------*/
		
		$this->setBodyHtml ($htmlBody);
		$this->setFrom ( $from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($template['subject']);
		return $this->send();
		
	}
	
	public function sendForgotUsernameMail($options)
	{
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('forgot_username_email');		
		$htmlBody=$template['body'];
		//$htmlBody=str_replace("__NAME__", $options['firstName']." ".$options['lastName'], $htmlBody);
                $htmlBody=str_replace("__NAME__", $options['firstName']." ".$options['lastName'], $htmlBody);

                $htmlBody=str_replace("__FIRSTNAME__", $options ['firstName'], $htmlBody);
                $htmlBody=str_replace("__LASTNAME__", $options ['lastName'], $htmlBody);

		$htmlBody=str_replace("__USERNAME__", $options['username'], $htmlBody);
		$htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		/*---------------------*/
		
		$this->setBodyHtml($htmlBody);
		$this->setFrom( $from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($template['subject']);
		return $this->send();
		
	}
	public function sendEnquiryMail($options)
	{
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('contactus_email');		
		$htmlBody=$template['body'];
		$htmlBody=str_replace("__NAME__", $options['name'], $htmlBody);
		$htmlBody=str_replace("__EMAIL__", $options['email'], $htmlBody);
		$htmlBody=str_replace("__ENQUIRY__", $options['enquiry'], $htmlBody);
		/*---------------------*/
		
		$this->setBodyHtml ($htmlBody);
		$this->setFrom ( $from_email, $from_name);
		$this->addTo($from_email);
		$this->setSubject ($template['subject']);
		return $this->send();	
	}
	
	public function sendAdvertiseMail($options)
	{
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('advertise_email');		
		$htmlBody=$template['body'];
		$htmlBody=str_replace("__NAME__", $options['name'], $htmlBody);
		$htmlBody=str_replace("__EMAIL__", $options['email'], $htmlBody);
		$htmlBody=str_replace("__ENQUIRY__", $options['enquiry'], $htmlBody);
		$htmlBody=str_replace("__PHONE__", $options['phone'], $htmlBody);
		/*---------------------*/
		
		$this->setBodyHtml ($htmlBody);
		$this->setFrom ( $from_email, $from_name);
		$this->addTo($from_email);
		$this->setSubject ($template['subject']);
		return $this->send();
	}

    public function sendNotificationMail($identifier, $options)
	{
                switch($identifier){
                    case 'comment':
						$this->getCommentMail($options);
                        break;
                    case 'accept-friend-request':
                        $this->getFriendRequest($options);
                        break;
					case 'message_notification':
                        $this->getMessageNotification($options);
                        break;
                }

	}

	public function getCommentMail($options)
	{
		$from_email	= $this->settingValue('comment');
		$from_name	= $this->settingLable('comment');
		
		/*---Template-----*/
		$template	= $this->getEmailTemplate('comment');
		$htmlBody	= $template['body'];
		$subject	= $template['subject'];
        $arr = preg_split("/[ ]+/",$options['CommentedPersonName']);
        $CommentedPersonName = $arr[0];
		
		//set view comment url
		$comment_url = Zend_Registry::get('siteurl')."/gapper/my-travel-wall/wall_id/".$options['wall_id'];
		$view_comment_url = "<a href='".$comment_url."' target='_blank'>".$comment_url."</a>";
		
		$htmlBody = str_replace("__COMMENTED_PERSON_NAME__", $CommentedPersonName, $htmlBody);
		$htmlBody = str_replace("__COMMENT__", $options['Comment'], $htmlBody);
		$htmlBody = str_replace("__VIEW_COMMENTS_URL__", $view_comment_url, $htmlBody);
        $htmlBody = str_replace("__COMMENTED_BY_NAME__", $options ['CommentedByName'], $htmlBody);		
		$htmlBody = str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		/*---------------------*/

		$this->setBodyHtml ($htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($subject);
		$this->send();
      }

      public function getFriendRequest($options){

        $from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('registration_email');
		$htmlBody=$template['body'];
		$htmlBody=str_replace("__NAME__", $options ['firstName']." ".$options ['lastName'], $htmlBody);
		$htmlBody=str_replace("__EMAIL__", $options ['email'], $htmlBody);
		$htmlBody=str_replace("__PASSWORD__", $options ['password'], $htmlBody);
		$htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		$htmlBody=str_replace("__ACTIVATE_LINK__", $options['activate_link'], $htmlBody);

		/*---------------------*/

		$subject=$template['subject'];
		$this->setBodyHtml ( $htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($subject);
		$this->send();

     }
	 
	 public function getMessageNotification($options)
	 {
	
		$from_email=$this->settingValue('support_email');
		$from_name=$this->settingLable('support_email');
		/*---Template-----*/
		$template=$this->getEmailTemplate('message_notification');
		$htmlBody=$template['body'];

                $arr=preg_split("/[ ]+/",$options['toName']);
                $toName=$arr[0];
				
		$messageLink	=	Zend_Registry::get('siteurl')."/gapper/message-detail/id/".base64_encode($options ['messageId']);
		$textMessageLink=	"<a href='{$messageLink}'>".$messageLink."</a>";

		$htmlBody=str_replace("__RECEIVER_NAME__", $toName, $htmlBody);

		$htmlBody=str_replace("__SENDER_NAME__", $options ['fromName'], $htmlBody);
		
		$htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);

		$htmlBody=str_replace("__MESSAGE__", $options ['message'], $htmlBody);
		
		$htmlBody=str_replace("__LINK__", $textMessageLink, $htmlBody);

		/*---------------------*/

		$subject	=	$template['subject'];
		$this->setBodyHtml ( $htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['toEmail']);
		$this->setSubject ($subject);
		$this->send();
	 }
    public function sendInvitation($options)
    {
        $from_email=$this->settingValue('support_email');
        $from_name=$this->settingLable('support_email');
		
        //Template
        $template=$this->getEmailTemplate('invitation');
        $htmlBody=$template['body'];
        $htmlBody=str_replace("__SENDER_NAME__", $options ['name'], $htmlBody);
        $htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
        $htmlBody=str_replace("__INVITATION_LINK__", $options['invitation_link'], $htmlBody);
        $htmlBody=str_replace("__MESSAGE__", $options['message'], $htmlBody);
        
        if($options['provider_box']=="facebook")
        {
            $htmlBody=strip_tags($htmlBody);
        }
        //$contacts=preg_split("/[\s,]+/", $options['contacts']);
        $total_contacts=$options['total_contacts'];
        $inviter=new Base_OpenInviter_OpenInviter();
        $inviter->startPlugin($options['provider_box']);
        $internal=$inviter->getInternalError();
        if ($internal)
			return false;
            
        for($i=0;$i<$total_contacts;$i++)
        {
            $contacts=array();
            $selected_contacts=array();
            if(isset($options["contacts_{$i}"]))
			{
                //echo $options["contacts_{$i}"];
				$contacts[]=$options["contacts_{$i}"];
				$selected_contacts[$options["contacts_{$i}"]]="Dear";
				$message=array('subject'=>$template['subject'],'body'=>$htmlBody,'attachment'=>"");
				$sendMessage=$inviter->sendMessage($options['oi_session_id'],$message,$selected_contacts);            
           
                if ($sendMessage===-1)
                {
                    $mail=new Base_Mail();
                    $subject=$template['subject'];
                    $mail->setBodyHtml ( $htmlBody);
                    $mail->setFrom ($from_email, $from_name);
                    $mail->addTo($contacts);
                    $mail->setSubject($subject);
                    $mail->send();
                }
				else
                {
                    echo ("i m  here ");
                }
            }//end if
        }//end for
        $inviter->logout();
    }
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 17-Feb-2011
	 * @Description: Used to send invitation emails to all contacts mannually entered by user
	 */
	public function sendInvitationToEmails($options)
	{
		//get HTML email Template
        $template	=	$this->getEmailTemplate('invitation');
        $subject	=	$template['subject'];
		$htmlBody	=	$template['body'];
		$htmlBody	=	str_replace("__SENDER_NAME__", $options ['name'], $htmlBody);
        $htmlBody	=	str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
        $htmlBody	=	str_replace("__INVITATION_LINK__", $options['invitation_link'], $htmlBody);
        $htmlBody	=	str_replace("__MESSAGE__", $options['message'], $htmlBody);
		
		//set mail options
		$from_email	=	$this->settingValue('support_email');
		$from_name	=	$this->settingLable('support_email');
		
		//send email to each contact
        $total_contacts = $options['contactEmail'];
		
		$receiver_email = "";
        for($i=0;$i<count($total_contacts);$i++)
        {
            $receiver_email = trim($total_contacts[$i]);
			if($receiver_email!="")
			{
				$mail	=	new Base_Mail();
				$mail->setSubject($subject);
				$mail->setBodyHtml ($htmlBody);
				$mail->setFrom ($from_email, $from_name);
				$mail->addTo($receiver_email);				
				$mail->send();
			}	
        }//end for		
    }
	
	public function ___sendInvitation($options)
    {

        $from_email=$this->settingValue('support_email');
        $from_name=$this->settingLable('support_email');
        /*---Template-----*/
        $template=$this->getEmailTemplate('invitation');
        $htmlBody=$template['body'];
        $htmlBody=str_replace("__SENDER_NAME__", $options ['name'], $htmlBody);
        $htmlBody=str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
        $htmlBody=str_replace("__INVITATION_LINK__", $options['invitation_link'], $htmlBody);
        $htmlBody=str_replace("__MESSAGE__", $options['message'], $htmlBody);
        /*---------------------*/
        if($options['provider_box']=="facebook")
        {
            $htmlBody=strip_tags($htmlBody);
        }


        //$contacts=preg_split("/[\s,]+/", $options['contacts']);

        $total_contacts=$options['total_contacts'];
        for($i=0;$i<$total_contacts;$i++)
        {
            $contacts[]=$options["contacts_{$i}"];
            $selected_contacts[$options["contacts_{$i}"]]="Dear";
        }

//        foreach($contacts as $email)
//        {
//            $selected_contacts[$email]="Dear";
//        }
    	$inviter=new Base_OpenInviter_OpenInviter();
        $inviter->startPlugin($options['provider_box']);
        $internal=$inviter->getInternalError();
        if ($internal)
            return false;
        $message=array('subject'=>$template['subject'],'body'=>$htmlBody,'attachment'=>"");
        $sendMessage=$inviter->sendMessage($options['oi_session_id'],$message,$selected_contacts);
        $inviter->logout();
        if ($sendMessage===-1)
        {
            $subject=$template['subject'];
            $this->setBodyHtml ( $htmlBody);
            $this->setFrom ($from_email, $from_name);
            $this->addTo($contacts);
            $this->setSubject($subject);
            $this->send();
        }
        else
        {
                  return false;
        }
     }
	/**
	 * @Created By : Mahipal Adhikari
	 * @Created On : 27-Oct-2010
	 * @Description: Used to send accept/decline friend request email
	 */
    public function acceptDeclineRequest($options)
    {
		/*---Template-----*/
		$template	=	$this->getEmailTemplate('friend_request_confirmation');
		$htmlBody	=	$template['body'];
		$arr=preg_split("/[ ]+/",$options['receiver_name']);
                $receiver_name=$arr[0];
		$htmlBody	=	str_replace("__RECEIVER_NAME__", $receiver_name, $htmlBody);
		$htmlBody	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $htmlBody);
		$htmlBody	=	str_replace("__REQ_STATUS__", $options['req_status'], $htmlBody);
		$htmlBody	=	str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		
		/*---------------------*/
		$subject	=	$template['subject'];
		$subject	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $subject);
		$subject	=	str_replace("__REQ_STATUS__", $options ['req_status'], $subject);
		
		$this->setBodyHtml($htmlBody);
		$from_email	=	$this->settingValue('support_email');
		$from_name	=	$this->settingLable('support_email');
		$this->setFrom($from_email, $from_name);
		
		//$this->setFrom($options ['sender_email'], $options ['sender_name']);
		$this->addTo($options['receiver_email']);
		$this->setSubject($subject);
		$this->send();
    }//end function
	
	/**
	 * @Created By : Mahipal Adhikari
	 * @Created On : 27-Oct-2010
	 * @Description: Used to send friend request email
	 */
	public function sendFriendRequest($options)
    {
		/*---Template-----*/
		$template	=	$this->getEmailTemplate('send_friend_request');
		$htmlBody	=	$template['body'];
		//$htmlBody	=	str_replace("__RECEIVER_NAME__", $options ['receiver_name'], $htmlBody);
                 $arr=preg_split("/[ ]+/",$options['receiver_name']);
                $receiver_name=$arr[0];
		$htmlBody	=	str_replace("__RECEIVER_NAME__", $receiver_name, $htmlBody);
		$htmlBody	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $htmlBody);
		$htmlBody	=	str_replace("__CON_TYPE__", $options['con_type'], $htmlBody);
		$htmlBody	=	str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		$view_req_url = Zend_Registry::get('siteurl')."/gapper/requests";
		$view_req_url = "<a href='".$view_req_url."' target='_blank'>".$view_req_url."</a>";
		$htmlBody	=	str_replace("__VIEW_REQ_URL__", $view_req_url, $htmlBody);
		
		/*---------------------*/
		$subject	=	$template['subject'];
		$subject	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $subject);
		$subject	=	str_replace("__CON_TYPE__", $options ['con_type'], $subject);
		
		$this->setBodyHtml($htmlBody);
		$from_email	=	$this->settingValue('support_email');
		$from_name	=	$this->settingLable('support_email');
		$this->setFrom($from_email, $from_name);
		
		$this->addTo($options['receiver_email']);
		$this->setSubject($subject);
		$this->send();
    }//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 1-Dec-2010
	 * @Description: Used to send POI recommendation email to GD administrator
	 */
	public function sendPoiRecommendation($options)
    {
		/*---Template-----*/
		$template	=	$this->getEmailTemplate('send_poi_recommendation');
		$htmlBody	=	$template['body'];
		//$htmlBody	=	str_replace("__RECEIVER_NAME__", $options ['receiver_name'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_EMAIL__", $options ['sender_email'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_COMMENTS__", $options ['sender_comments'], $htmlBody);
		$htmlBody	=	str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);		
		
		/*---------------------*/
		$subject	=	$template['subject'];
		//$subject	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $subject);
		
		$this->setBodyHtml($htmlBody);
		$from_email	=	$this->settingValue('support_email');
		$from_name	=	$this->settingLable('support_email');
		$this->setFrom($from_email, $from_name);
		
		$this->addTo($options['receiver_email']);
		$this->setSubject($subject);
		$this->send();
    }//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 9-Dec-2010
	 * @Description: Used to send Contact Us email to GD administrator
	 */
	public function sendContactusEmail($options)
    {
		/*---Template-----*/
		$template	=	$this->getEmailTemplate('contact_us_email');
		$htmlBody	=	$template['body'];
		//$htmlBody	=	str_replace("__RECEIVER_NAME__", $options ['receiver_name'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_EMAIL__", $options ['sender_email'], $htmlBody);
		$htmlBody	=	str_replace("__SENDER_COMMENTS__", $options ['sender_comments'], $htmlBody);
		$htmlBody	=	str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);		
		
		/*---------------------*/
		$subject	=	$template['subject'];
		//$subject	=	str_replace("__SENDER_NAME__", $options ['sender_name'], $subject);
		
		$this->setBodyHtml($htmlBody);
		$from_email	=	$this->settingValue('support_email');
		$from_name	=	$this->settingLable('support_email');
		$this->setFrom($from_email, $from_name);
		
		$this->addTo($options['receiver_email']);
		$this->setSubject($subject);
		$this->send();
    }//end function
	
	/**
	 * @Created By : Mahipal Singh Adhikari
	 * @Created On : 10-Dec-2010
	 * @Description: Used to send Blog(Journal) comment email to Journal Owner
	 */
	public function sendBlogCommentEmail($options)
	{
		$from_email	= $this->settingValue('comment');
		$from_name	= $this->settingLable('comment');
		
		/*---Template-----*/
		$template	= $this->getEmailTemplate('blog_comment');
		$htmlBody	= $template['body'];
		$subject	= $template['subject'];
        $arr = preg_split("/[ ]+/",$options['CommentedPersonName']);
        $CommentedPersonName = $arr[0];
		
		//set view comment url
		$comment_url = Zend_Registry::get('siteurl')."/journal/view-post/blog_id/".$options['blog_id']."#blog_comments_list";
		$view_comment_url = "<a href='".$comment_url."' target='_blank'>".$comment_url."</a>";
		
		$htmlBody = str_replace("__COMMENTED_PERSON_NAME__", $CommentedPersonName, $htmlBody);
		$htmlBody = str_replace("__COMMENT__", $options['Comment'], $htmlBody);
		$htmlBody = str_replace("__VIEW_COMMENTS_URL__", $view_comment_url, $htmlBody);
        $htmlBody = str_replace("__COMMENTED_BY_NAME__", $options ['CommentedByName'], $htmlBody);		
		$htmlBody = str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		/*---------------------*/

		$this->setBodyHtml ($htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($subject);
		$this->send();
      }

      public function sendErrorMail($options)
      {
       
        $htmlBody="<h1>An error occurred at {$options['siteurl']}</h1>";
        $htmlBody.="<h2>{$options['message']}</h2>";
        
        $htmlBody.="<h3>Request Uri: {$options['siteurl']}{$options['requesturi']}</h3>";
        
        $htmlBody.="<h3>Remote Address: {$_SERVER['REMOTE_ADDR']}</h3>";
        $htmlBody.="<h3>Exception information:</h3>";
        $htmlBody.=" <p><b>Message: {$options['exception']}</b></p>";

        $htmlBody.="<h3>Stack trace:</h3>";
        $htmlBody.=" <pre>{$options['traceString']}</pre>";

        if(count($options['params'])>0)
        {
            $htmlBody.="<h3>Request Parameters:</h3>";
            foreach($options['params'] as $k=>$v)
            {
                $htmlBody.="<br>{$k} => {$v}";
            }
        }
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini', APPLICATION_ENV);
        $to=trim($config->error_reporting_email);

        $from_email	=   $this->settingValue('support_email');
        $from_name	=   $this->settingLable('support_email');
        if($to<>""){
        $this->setBodyHtml($htmlBody);
        $this->setFrom ($from_email, $from_name);
        $this->addTo($to);
        $this->setSubject("ONSIS-We - [ {$options['siteurl']} ]");
        $this->send();
        }
      }
	  
	/**
	* @Created By : Mahipal Singh Adhikari
	* @Created On : 18-Jan-2011
	* @Description: Send Newsletter subscription email to user
	*/
	public function sendNewsletterSubscriptionEmail($options)
	{
		$from_email	= $this->settingValue('support_email');
		$from_name	= $this->settingLable('support_email');
		
		//get template
		$template	= $this->getEmailTemplate('newsletter_subscribe_email');
		$htmlBody	= $template['body'];
		$subject	= $template['subject'];
        
		//set unsubscribe link url
		$unsubscribe_url = Zend_Registry::get('siteurl')."/index/newsletter-unsubscribe/user_id/".$options['user_id'];
		$view_unsubscribe_url = "<a href='".$unsubscribe_url."' target='_blank'>".$unsubscribe_url."</a>";
		
		//replace variables
		$htmlBody = str_replace("__FIRSTNAME__", $options['receiver_name'], $htmlBody);
		$htmlBody = str_replace("__UNSUBSCRIBE_LINK__", $view_unsubscribe_url, $htmlBody);
        $htmlBody = str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		
		$this->setBodyHtml ($htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['receiver_email']);
		$this->setSubject ($subject);
		$this->send();
	}//end of function
	
	/**
	* @Created By : Mahipal Singh Adhikari
	* @Created On : 27-Jan-2011
	* @Description: Send report abuse email to Administrator
	*/
	public function sendReportAbuseEmail($options)
	{
		$from_email	= $this->settingValue('report_abuse');
		$from_name	= $this->settingLable('report_abuse');
		
		//get template
		$template	= $this->getEmailTemplate('report_abuse_email');
		$htmlBody	= $template['body'];
		$subject	= $template['subject'];
        
		//replace variables
		$htmlBody = str_replace("__ITEM_TYPE__", $options['item_type'], $htmlBody);
		$htmlBody = str_replace("__ITEM_TITLE__", $options['item_title'], $htmlBody);
		$htmlBody = str_replace("__AUTHOR__", $options['item_author'], $htmlBody);
		$htmlBody = str_replace("__REPORTER_NAME__", $options['reporter_name'], $htmlBody);
		$htmlBody = str_replace("__REPORTER_EMAIL__", $options['reporter_email'], $htmlBody);
        $htmlBody = str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		
		$this->setBodyHtml ($htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['receiver_email']);
		$this->setSubject ($subject);
		$this->send();
	}//end of function
	
	/**
	* @Created By : Mahipal Singh Adhikari
	* @Created On : 28-Jan-2011
	* @Description: Send travel wall email to user if somone posting on their wall
	*/
	public function sendTravelWallEmail($options)
	{
		$from_email	= $this->settingValue('comment');
		$from_name	= $this->settingLable('comment');
		
		/*---Template-----*/
		$template	= $this->getEmailTemplate('travel_wall_post');
		$htmlBody	= $template['body'];
		$subject	= $template['subject'];
        		
		//set view comment url
		$comment_url = Zend_Registry::get('siteurl')."/gapper/my-travel-wall/wall_id/".$options['wall_id'];
		$view_comment_url = "<a href='".$comment_url."' target='_blank'>".$comment_url."</a>";
		
		$htmlBody = str_replace("__COMMENTED_PERSON_NAME__", $options['CommentedPersonName'], $htmlBody);
		$htmlBody = str_replace("__COMMENT__", $options['Comment'], $htmlBody);
		$htmlBody = str_replace("__VIEW_COMMENTS_URL__", $view_comment_url, $htmlBody);
        $htmlBody = str_replace("__COMMENTED_BY_NAME__", $options ['CommentedByName'], $htmlBody);		
		$htmlBody = str_replace("__SITE_URL__", Zend_Registry::get('siteurl'), $htmlBody);
		/*---------------------*/

		$this->setBodyHtml ($htmlBody);
		$this->setFrom ($from_email, $from_name);
		$this->addTo($options ['email']);
		$this->setSubject ($subject);
		$this->send();
	}
}//end of class


