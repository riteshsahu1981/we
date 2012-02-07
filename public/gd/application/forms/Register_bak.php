<?php
class Application_Form_Register extends Zend_Form
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
        
       /* $this->addElement('text', 'email', array(		
            'label'      => 'Email:',
        	'TABINDEX'=>'1',
            'required'   => true,
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
			//'validators' => array(array('EmailAddress', true, array('messages'=>'You must enter valid email'))),
            'validators' => array(
					array('EmailAddress', false, array('messages'=>'You must enter valid email')),
        		array('Db_NoRecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'email',
	       			'messages'=>'Email already exists'
	    			))
            ),
        ));*/
		$validator = new Zend_Validate_Db_NoRecordExists(
    			array(
        			'table' => 'user',
					'field' => 'email'	,
                            'messages'=>'Email already exists'
    			)
			);
   
		$Email		=	new Zend_Form_Element_Text('email');
                $Email		->	setLabel('Email')
        			->	setAttrib('class', 'form')
        			->	setRequired(true)
                                ->	addValidator($validator, true, array('message'=>'Email already exists'))
         			->	addValidator('EmailAddress', true,  array('message'=>'Please enter the valid email address'))
         			      	
         			->	addFilter('StringToLower')
         			-> 	clearDecorators()
         			->	addDecorators($this->elementDecorators);
   
    //$this->addElement($Email);
   
        $this->addElement('text', 'email', array(
            'label'      => 'Email:',
        	'autocomplete'=>"off",
        	'class' =>'form',
        	'TABINDEX'=>'2',
            'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter the email address'))),
                        array('EmailAddress', true, array('messages'=>'Please enter valid email address'    )),
                	array('Db_NoRecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'email',
	       			'messages'=>'Email already exists'
	    			))
				
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));

        $this->addElement('text', 'username', array(
            'label'      => 'Username:',
        	'autocomplete'=>"off",
        	'class' =>'form',
        	'TABINDEX'=>'2',
            'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter username'))),
                	array('Db_NoRecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'username',
	       			'messages'=>'Username already exists'
	    			)),
					 array('Alnum', true, array(        			
	       			'allowWhiteSpace' => false,
	       			'messages'=>"Please make sure that your username does not include spaces or special characters."
	    			))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
     

        $this->addElement('password', 'password', array(
            'label'      => 'Password:',
        	'autocomplete'=>"off",
            'required'   => true,
        	'TABINDEX'=>'3',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))
                
            )
        ))
         ->getElement('password')
        ->addValidator('IdenticalField', false, array('confirmPassword', 'Confirm Password'));

            // Add an password element
        $this->addElement('password', 'confirmPassword', array(
            'label'      => 'Confirm Password:',
            'required'   => true,
        	'TABINDEX'=>'3',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 20))
            )
        ));

  
        // Add an first name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'First Name:',
        	'class' =>'form',
        	'TABINDEX'=>'4',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your first name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        // Add an last name element
        $this->addElement('text', 'lastName', array(
            'label'      => 'Surname:',
        	'class' =>'form',
        	'TABINDEX'=>'5',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
       /* $country=new Application_Model_Country();
        $arrCountry=$country->getCountry("--select---");
         
        $this->addElement('select', 'countryPassport',array(
            'label'      => 'Country Issuing Passport:',
        	'class' =>'form',
        	'TABINDEX'=>'6',
            
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select country')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCountry,
        	'value'=>'499'
        ));*/
        
        
       /* $language=new Application_Model_Language();
        $arrLang=$language->getLanguage("--select--");
        $this->addElement('select', 'preferredLanguage',array(
            'label'      => 'Preferred Language:',
        	'class' =>'form',
        	'TABINDEX'=>'7',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select language')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrLang
        ));*/
        
         
      /*  $this->addElement('text', 'otherLanguages',array(
            'label'      => 'Other Languages:',
        	'class' =>'form',
        	'TABINDEX'=>'8',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        */
       /* 
        $this->addElement('hidden', 'cityId', array(
            'label'      => 'Home Town/City:',
        	'TABINDEX'=>'9',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));*/
        
       /* $this->addElement('text', 'cityName', array(
            'label'      => 'Home Town/City:',
        	'TABINDEX'=>'10',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));*/
       
        
        $this->addElement('radio', 'sex', array(
    	
    	'label'=>'Gender: ',
         'required'   => false,
        	'TABINDEX'=>'14',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the sex.')))
   							),
    	'multiOptions'=>array(
        'male'=>"Male",
        'female'=>"Female",
      	),
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));
  		
         $day['']="Day";
        for($i=1;$i<32;$i++)
        $day[$i]=$i;
        $this->addElement('select', 'day',array(
        	'label'=>'Date of Birth: ',
        	'TABINDEX'=>'11',    
        	'class'		=>"select-box",
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$day
        ));
        
        $month[""]="Month";
        for($i=1;$i<13;$i++)
        $month[$i]=date("F",mktime(null,null, null, $i+1,null, null));
        
        $this->addElement('select', 'month',array(
        	    
        	'class'		=>"select-box",
        	'TABINDEX'=>'12',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$month
        ));
        
        $year['']="Year";
        for($i=date("Y");$i>1900;$i--)
        $year[$i]=$i;
        $this->addElement('select', 'year',array(
        	    
        	'class'		=>"select-box",
        	'TABINDEX'=>'13',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$year
        ));
		
  		/*$this->addElement('radio', 'gapperOrFriend', array(
    	
    	'label'=>'Are you a Traveller or a friend of a Traveller or a Family Member? ',
         'required'   => true,
  		'TABINDEX'=>'15',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select option.')))
   							),
    	'multiOptions'=>array(
        'traveller'=>"Gapper",
        'friend'=>"Friend of Gapper",
      	),
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));*/
  		
  		
  		$this->addElement('select', 'gapperOrFriend',array(
        	'class'		=>"select-box",
        	'TABINDEX'=>'13',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
  			'label'=>'Are you a Traveller or a friend of a Traveller or a Family Member? ',
        	'MultiOptions'=>array(
		        'gapper'=>"Traveller",
		        'friend'=>"Friend of Traveller",
	  			'family' => "Family Member"
	      	)
        ));
        
  		
  		$this->addElement('radio', 'firstTimeTraveller', array(
    	
  		'TABINDEX'=>'16',
    	'label'=>'First time traveller? ',
         'required'   => false,
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select option.')))
   							),
    	'multiOptions'=>array(
        'yes'=>"Yes",
        'no'=>"No",
      	),
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));
  		

  		
  		  $this->addElement('hidden', 'usernameOfGapper', array(
            'label'      => 'Name of Traveller',
        	'TABINDEX'=>'17',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
  		  	'validators' => array(
                	
                	array('Db_RecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'username',
	       			'messages'=>'username does not exists'
	    			))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        /*$this->addElement('text', 'mobileCountryCode', array(
            'label'      => 'Mobile No. Country Code',
        	'validators'=>array('Digits'),
        	'TABINDEX'=>'18',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'mobile', array(
            'label'      => 'Mobile Number',
        	'validators'=>array('Digits'),
        	'TABINDEX'=>'19',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));*/
        
 /*      $TermsCondition	=	new Zend_Form_Element_Checkbox('termsCondition');
       $TermsCondition	->	setLabel('I accept the Terms and Conditions')
        				->	setAttrib('class', 'styled')       
						->	setCheckedValue('1')
						->	setUncheckedValue('0')					
              			->	setRequired(true)
              			-> clearDecorators()
              			->	addDecorators($this->elementDecoratorsSpan );*/
              			
	        $this->addElement('checkbox', 'termsCondition', array(
	            'label'      => "I agree to the Gap Daemon <a href='/index/terms-conditions' target='_blank'>Terms & Conditions</a>",
	        	'TABINDEX'=>'20',
	        	'class' =>'form',
	        	'decorators' => $this->elementDecorators,	
	            'required'   => true,
	        	'uncheckedValue'=>'',
	        	'validators' => array(
	  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must agree to our Terms and Conditions in order to create an account')))
	   							),
	            'filters'    => array('StringTrim'),
	        ));
	        
			$this->addElement('checkbox', 'newsletter', array(
	            'label'      => 'Sign me up to the Gap Daemon Newsletter',
	        	'TABINDEX'=>'20',
	        	'class' =>'form',
	        	'decorators' => $this->elementDecorators,	
	            'required'   => false,
                            'value'=>'yes',
	        	'uncheckedValue'=>'no',
	 			'checkedValue'=>'yes',
	            'filters'    => array('StringTrim'),
	        ));
        
        /*$this->addElement('captcha', 'fcaptcha', array(
            'label'      => "Please verify you're a human",
        	'TABINDEX'=>'21',
			'captcha' => array(
    	    'captcha' => 'Image',
        	'font' =>'fonts/arial.ttf',
        	'wordLen' => 6,
        	'timeout' => 300,
        	
    		),
        ));*/
        
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'signup',
      
	      	'TABINDEX'=>'20',
            'ignore'   => true,
            'label'    => 'Register',
        'decorators' => $this->buttonDecorators,
        ));
         
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
