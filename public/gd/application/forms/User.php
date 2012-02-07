<?php
class Application_Form_User extends Zend_Form
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


    public $fileDecorators =array( 
	    array('File'), 
	    array('Errors'),
	    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
	    array('Label', array('tag' => 'td')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
	
    public function init()
    {

        $this->setMethod('post');
        $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');

        
      $this->addElement('password', 'currentPassword', array(
            'label'      => 'Current Password:',
            'required'   => false,
          'autocomplete' =>'off',
        	'TABINDEX'=>'2',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
       		
        ));
        
        
      $this->addElement('password', 'password', array(
            'label'      => 'New Password:',
            'required'   => false,
          'autocomplete' =>'off',
        	'TABINDEX'=>'2',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
      			array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the new password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))
                
                
            )
        ))
        ->getElement('password')
        ->addValidator('IdenticalField', false, array('confirmPassword', 'Confirm Password'));

       
        $this->addElement('password', 'confirmPassword', array(
            'label'      => 'Confirm Password:',
            'required'   => false,
            'autocomplete' =>'off',
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
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
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
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('text', 'email', array(
            'label'      => 'Your Email Address:',
        	'TABINDEX'=>'1',
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
        	'TABINDEX'=>'7',
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
        	'TABINDEX'=>'8',
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        
        $country = new Application_Model_Country();
        //$arrCountry=$country->getCountry("--select---");
		$nationalitiesArr = $country->getNationalities("---Select Nationality---");
         
        $this->addElement('select', 'countryPassport',array(
            'label'      => 'Nationality:',
        	'class' =>'form',
        	'TABINDEX'=>'6',            
         	'required'   => false,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select nationality.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$nationalitiesArr
        	
        ));        
        
        $this->addElement('hidden', 'cityId', array(
            'label'      => 'Home Town/City:',
        	'TABINDEX'=>'9',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'cityName', array(
            'label'      => 'Home Town/City:',
        	'TABINDEX'=>'10',
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
        	'TABINDEX'=>'11',    
        	'class'		=>"select-box",
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
        
        
        $this->addElement('radio', 'sex', array(
    	
    	'label'=>'Gender:',
         'required'   => true,
        	'TABINDEX'=>'14',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the gender.')))
   							),
    	'multiOptions'=>array(
        'male'=>"Male",
        'female'=>"Female",
      	),
      	'separator'=>"",
      	'decorators' => $this->elementDecorators,
  		));
        
        $this->addElement('radio', 'firstTimeTraveller', array(
    	
  		'TABINDEX'=>'16',
    	'label'=>'First time traveller? ',
         'required'   => true,
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
  		
        $this->addElement('text', 'mobileCountryCode', array(
            'label'      => 'Mobil No. Country Code:',
        	'validators'=>array('Digits'),
        	'TABINDEX'=>'18',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'mobile', array(
            'label'      => 'Mobile Number:',
        	'validators'=>array('Digits'),
        	'TABINDEX'=>'19',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));        
        
        $this->addElement('file', 'image', array(
            'class'		=>"input-browse",
        	'label'      => 'Add/Edit (Up to 5MB)',
            'required'   => false,
        	'decorators' => $this->fileDecorators,
        ));
        $this->getElement('image')->addValidator('Size', false, 1024*1024*5); //5 MB file is allowed
		$this->getElement('image')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 5 MB.","fileSizeTooSmall"=>""));
		$this->getElement('image')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('image')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
        
		$this->addElement('textarea', 'dreamDestination', array(
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
        	));
        	
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
        	
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'signup',
      
	      	'TABINDEX'=>'20',
            'ignore'   => true,
            'label'    => 'Save Update Settings',
        'decorators' => $this->buttonDecorators,
        ));
		//$this->getElement('firstName')->addValidator('Badwords', true);
		//$this->getElement('firstName')->getValidator('Badwords')->setMessages(array("badWords"=>"Bad words are not allowed."));
         
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
