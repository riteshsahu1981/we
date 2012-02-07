<?php
class Admin_Form_User extends Zend_Form
{
   public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );   

    public $fileDecorators =array( 
    array('File'), 
    array('Errors'),
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
            	
  		$this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
        $this->setName('frmRegistration');
		/*
		$FName		=	new Zend_Form_Element_Text('firstName');
        $FName		->	setLabel('First Name')
        			
                	->	setRequired(true)
                	->	addFilter('StripTags')
                	->	addFilter('StringTrim')
                	->	addValidator('NotEmpty')
                	-> clearDecorators()
                	->	addDecorators($this->elementDecorators);

        $LName		=	new Zend_Form_Element_Text('lastName');
        $LName 		-> setLabel('Last Name')
        			
               		->	setRequired(true)
               		->	addFilter('StripTags')
               		->	addFilter('StringTrim')
               		->	addValidator('NotEmpty')
               		-> clearDecorators()
               		->	addDecorators($this->elementDecorators);
               		
		$Country	=	new Zend_Form_Element_Text('countryId');
        $Country	->	setLabel('CountryName')
        			
              		->	setRequired(true)
              		->	addFilter('StripTags')
              		->	addFilter('StringTrim')
              		->	addValidator('NotEmpty')
              		-> clearDecorators()
              		->	addDecorators($this->elementDecorators);              
                      
        $City		=	new Zend_Form_Element_Text('cityName');
        $City		->	setLabel('City')
        			
              		->	setRequired(true)
              		->	addFilter('StripTags')
              		->	addFilter('StringTrim')
              		->	addValidator('NotEmpty')
              		-> clearDecorators()
              		->	addDecorators($this->elementDecorators);
              		
        
		$model=new Application_Model_UserLevel();
        $arrUserLevel=$model->getUserLevel();

    	$userlevel=new	Zend_Form_Element_Select('userLevelId');
    	$userlevel	->setAttrib('id','userLevelId')
    				->setAttrib('style', 'width:100%')
    				->setLabel('User Level')
    				->setRequired(true)
    				->addMultiOptions($arrUserLevel)	
					->clearDecorators()
              		->addDecorators($this->elementDecorators)
              		
              		;
              		
        $submit		=	new Zend_Form_Element_Submit('submitbutton');
        $submit		->	setAttrib('id', 'submitbutton')        
        			
        			->	setLabel('Submit')
        			-> clearDecorators()
        			->	addDecorators($this->buttonDecorators)
        			;
       

		        

        $this->addElements(array($FName, $LName, $Country, $City,  $userlevel,$submit));
		*/
       
	   
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
	       			'messages'=>'username already exists'
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

            // Add an password element
        

	   
	    // Add an first name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'First Name:',
        	'class' =>'form',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        // Add an last name element
        $this->addElement('text', 'lastName', array(
            'label'      => 'Surame:',
        	'class' =>'form',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'email', array(
            'label'      => 'Email Address:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter email')))
            	),
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));

        $language=new Application_Model_Language();
        $arrLang=$language->getLanguage("--select--");
        $this->addElement('select', 'preferredLanguage',array(
            'label'      => 'Preferred Language:',
        	'class' =>'form',
			'style' => 'width:193px',
        	'required'   => false,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select language')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrLang
        ));
        
         
        $this->addElement('text', 'otherLanguages',array(
            'label'      => 'Other Languages:',
        	'class' =>'form',
        	'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        
        $country=new Application_Model_Country();
        //$arrCountry=$country->getCountry("--select---");
		$nationalitiesArr = $country->getNationalities("---Select Nationality---");
         
        $this->addElement('select', 'countryPassport',array(
            'label'      => 'Nationality:',
        	'class' =>'form',
			'style' => 'width:193px',
        	'required'   => false,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select nationality.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$nationalitiesArr
        	
        ));        
        
        $this->addElement('hidden', 'cityId', array(
            'label'      => '',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'cityName', array(
            'label'      => 'Home Town/City:',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
       
         $day['']="Day";
        for($i=1;$i<32;$i++)
        $day[$i]=$i;
        $this->addElement('select', 'day',array(
        	'label'=>'Date of Birth:',
        	'class'		=>"select-box",
			'style' => 'width:193px',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$day
        ));
        
        $month[""]="Month";
        for($i=1;$i<13;$i++)
        $month[$i]=$i;
        $this->addElement('select', 'month',array(        	    
        	'class'		=>"select-box",
			'style' => 'width:193px',
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
			'style' => 'width:193px',
        	'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$year
        ));
        
        
        $this->addElement('radio', 'sex', array(    	
    	'label'=>'Gender: ',
         'required'   => true,
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the gender.')))
   							),
    	'multiOptions'=>array(
        'male'=>"Male",
        'female'=>"Female",
		),
		'value'=>"male",
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));
        
        $this->addElement('radio', 'firstTimeTraveller', array(
    	'label'=>'First time traveller? ',
         'required'   => true,
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select option.')))
   							),
    	'multiOptions'=>array(
        'yes'=>"Yes",
        'no'=>"No",
      	),
		'value'=>"no",
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));
  		/*
        $this->addElement('text', 'mobileCountryCode', array(
            'label'      => 'Mobil No. Country Code:',
        	'validators'=>array('Digits'),
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));*/
        
        $this->addElement('text', 'mobile', array(
            'label'      => 'Mobile Number:',
        	'validators'=>array('Digits'),
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));        
        
        $this->addElement('file', 'image', array(
            'class'		=>"input-browse",
        	'label'      => 'Profile Photo:',
            'required'   => false,
        	'decorators' => $this->fileDecorators,
        ));
        $this->getElement('image')->addValidator('Size', false, 1024*1024*5); //2 MB file is allowed
		$this->getElement('image')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 5 MB.","fileSizeTooSmall"=>""));
		$this->getElement('image')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('image')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
        /*$this->addElement('textarea', 'dreamDestination', array(
            'label'      => 'What is your dream destination?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        	
        $this->addElement('textarea', 'wayToTravel', array(
            'label'      => 'Favourite way to travel?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        $this->addElement('textarea', 'travelGear', array(
            'label'      => 'Best bit of travel gear?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        $this->addElement('textarea', 'yearGoal', array(
            'label'      => 'Gap Year goal?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        	
        $this->addElement('textarea', 'leaveHomeWithout', array(
            'label'      => 'Never leave home without …?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));

       $this->addElement('textarea', 'interests', array(
            'label'      => 'Interests?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));*/
		$this->addElement('textarea', 'evenTakenGapYear', array(
            'label'      => 'Ever taken a gap year?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        	
		$this->addElement('textarea', 'nextTravelToDoList', array(
            'label'      => 'Next on your travel To Do list?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));
        	
		$this->addElement('textarea', 'favouriteTravelExperience', array(
            'label'      => 'Your favourite travel experience so far?',
            'required'   => false,
         	'rows'=>'5',
         	'cols'=>'50',
        	'decorators' => $this->elementDecorators,
        	));	
			
		$model	=	new Application_Model_UserLevel();
        $arrUserLevel	=	$model->getUserLevel();
		$this->addElement('select', 'userLevelId',array(
            'label'      => 'User Level:',
			'id' => 'userLevelId',
			'style' => 'width:193px',
        	'class' =>'form',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user level.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrUserLevel
        ));	
		
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'signup',
            'ignore'   => true,
            'label'    => 'Submit',
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
