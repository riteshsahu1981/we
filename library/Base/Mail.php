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
        //$this->clearRecipients();
//         $config = array('auth' => 'login',
//            'username' => 'ritesh@profitbyoutsourcing.om',
//            'password' => 'ritesh11!',
//                'ssl'=>'ssl',
//                'port'=>'465'
//
//                );
//        $transport = new Zend_Mail_Transport_Smtp('smtp.profitbyoutsourcing.com',$config);
        
           
    
//        $this->addBcc(array('Ritesh development mode'=>"ritesh@profitbyoutsourcing.com"));
        return parent::send($transport);
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
    public function sendRequestNotification($requestId)
   {
        $request=new Application_Model_Request();
        $request=$request->find($requestId);
        if(false===$request)
        {
            return false;   
        }

        $departmentId=$request->getDepartmentId();
        
        $dept=new Application_Model_Department();
         $dept=$dept->find($departmentId);
         if($dept===false)
             return false;
         
        
        
        $user=new Application_Model_User();
        $users=$user->fetchAll("department_id='{$departmentId}' and status='active' and id ='{$dept->getDepartmentHeadId()}'");
        
        
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

   public function sendRequestCompleteNotification($requestId)
   {
        $request=new Application_Model_Request();
        $request=$request->find($requestId);
        if(false===$request)
        {
            return false;   
        }


        $requestedBy=$request->getRequestedByObj();

        $from_email=$this->settingValue('admin_email');
        $from_name=$this->settingLable('admin_email');

        /*-------Template------*/
        $template=$this->getEmailTemplate('request_complete_notification_email');		
        $htmlBody=$template['body'];
        $htmlBody=str_replace("__REQUESTER_NAME__", $requestedBy->getFirstName()." ".$requestedBy->getLastName(), $htmlBody);
        $htmlBody=str_replace("__REQUEST_NO__",$requestId, $htmlBody);
        $htmlBody=str_replace("__REMARKS__",$request->getRemarks(), $htmlBody);
        /*---------------------*/
        $emails[$requestedBy->getFirstName()." ".$requestedBy->getLastName()]=$requestedBy->getEmail();
        $subject=$template['subject'];
        $this->setBodyHtml ( $htmlBody);
        $this->setFrom ($from_email, $from_name);
        $this->addTo($emails);
        $this->setSubject ($subject);
        $this->send();
   }


    public function sendForgotMail($options)
    {
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
        $this->setSubject("OSNIS-WE Appliction Error - [ {$options['siteurl']} ]");
        $this->send();
        }
      }
}//end of class


