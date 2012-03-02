<?php

class Application_Form_Invite extends Zend_Form
{
	public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );

    public $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array(array('label' => 'HtmlTag'), array('tag' => 'td', 'placement' => 'prepend')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );


    public function init()
    {

        $this->setMethod('post');
        $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');        
        
        $this->addElement('text', 'email_box', array(
            'label'      => 'Your Email',
        	'class' =>'form',
        	/*'required'   => true,
			'validators' => array(
                array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter your email')))
            ),*/
			'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
   
          // Add an first name element
        $this->addElement('text', 'name', array(
            'label'      => 'Your Name',
        	'class' =>'form',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter your name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
		
      
		/**
		 * @Created By : Mahipal Adhikari
		 * @Created on : 26-Oct-2010
		 * @Description : set array to allow only selected services for open inviter as per client requiremnt
		 **/
		//'facebook'=>'Facebook',
		$serviceAllowed = array('gmail'=>'GMail',
								'yahoo'=>'Yahoo!',
								'hotmail'=>'Hotmail',
								'bebo'=>'Bebo',
								'aol'=>'AOL',
								'hi5'=>'Hi5',
								'friendster'=>'Friendster',
								'orkut'=>'Orkut',
								'myspace'=>'MySpace');
		
    	$inviter=new Base_OpenInviter_OpenInviter();
        $oi_services=$inviter->getPlugins();
        $arrayMain=array();
        $providersArray=array();
        foreach ($oi_services as $type=>$providers)
        {
            foreach ($providers as $provider=>$details)
            {
                //check if service is allowed
				if(array_key_exists($provider, $serviceAllowed))
				{
					$providersArray[$provider]=$details['name'];
				}	
			}
            $arrayMain[$inviter->pluginTypes[$type]]=$providersArray;
        }
		
		//$oi_services['social'];
        $this->addElement('select', 'provider_box',array(
            'label'      => 'Select Account',
        	'class' =>'form',
			'style' =>'width:221px;',
        	'value'	=>'gmail',
         	/*'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select your account')))
            	),*/
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrayMain
        	
        ));
        
		// Add an password element
        $this->addElement('password', 'password_box', array(
            'label'      => 'Your Password',
        	'autocomplete'=>"off",
            'class' =>'form',
        	/*'required'   => true,
			'validators' => array(
        		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))
                
            ),*/
			'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ))
         ;
      
        $this->addElement('button', 'load', array(
            'required' => false,
      		'class' =>'load_contacts',      
	      	'ignore'   => true,
            'label'    => 'LOAD CONTACTS',
            'decorators' => $this->buttonDecorators,
        ));
        
        $this->addElement('textarea', 'contacts', array(
            'label'      => 'Your Contacts',
            'cols'=>'40',
        	'rows'=>'1',
			'class'=>'invite-email_textarea',
            'TABINDEX'=>'6',
        	'required'   => false,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your contacts')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
		
        $this->addElement('textarea', 'message', array(
            'label'      => 'Message',
            'cols'=>'50',
        	'rows'=>'10',
			'class'=>'textarea',
			'value'	=>'Gap Daemon Message here',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the message')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        
		$this->addElement('submit', 'sendInvitataion', array(
            'required' => false,
      		'class' =>'invite_button',
			'ignore'   => true,
            'label'    => 'SEND INVITE TO CONTACTS',
			'decorators' => $this->buttonDecorators,
        ));
		
		$this->addElement('submit', 'inviteEmail', array(
            'required' => false,
      		'class' =>'invite_button',
	      	'ignore'   => true,
            'label'    => 'INVITE',
			'decorators' => $this->buttonDecorators,
        ));
       
	    //add badword validations to each form fields
		$this->getElement('name')->addValidator('Badwords', true);
		$this->getElement('message')->addValidator('Badwords', true);
    }
    
	public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
}
