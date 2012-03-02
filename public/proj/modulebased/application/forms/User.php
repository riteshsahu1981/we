<?php
class Application_Form_User extends Zend_Form
{
   public $elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
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
       array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
    array('Label', array('tag' => 'td')),
    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
);

    
    
    public function init()
    {
            	
        $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
        $this->setName('frmRegistration');
		
       
//        $this->addElementPrefixPath('Base_Decorator',
//                            'Base/Decorator/',
//                            'decorator');
        
	  
           
	   $this->addElement('text', 'username', array(
            'label'      => 'Username:',
        	'autocomplete'=>"off",
        	'class' =>'text-input medium-input',
        	
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
        	
        	'class' =>'text-input medium-input',
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
        	
        	'class' =>'text-input medium-input',
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
        	'class' =>'text-input medium-input',
            'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter first name')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       
        
        // Add an last name element
        $this->addElement('text', 'lastName', array(
            'label'      => 'Last Name:',
        	'class' =>'text-input medium-input',
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
        	'class' =>'text-input medium-input',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('text', 'dob', array(
            'label'      => 'Date of Birth:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter dob')))
            	),
        	'class' =>'text-input medium-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('select', 'sex', array(    	
        'label'=>'Gender:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        'male'=>"Male",
        'female'=>"Female",
		),
        'value'=>"male"
  		));
       
        $model	=	new Application_Model_Group();
        $arrGroup=	$model->getGroups();
       // print_r($arrGroup);die();
	$this->addElement('select', 'groupId',array(
            'label'      => 'Group:',
			'id' => 'groupId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user group.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrGroup
        ));
        
        $model	=	new Application_Model_Subgroup();
        $arrSubgroup	=	$model->getSubgroup();
	$this->addElement('select', 'subgroupId',array(
            'label'      => 'Sub Group:',
			'id' => 'subgroupId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => false,
        	/*'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select Subgroup.')))
            	),*/
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrSubgroup
        ));
        
        
        $model	=	new Security_Model_UserRole();
        $arrUserRole	=	$model->getUserRole();
	$this->addElement('select', 'userRoleId',array(
            'label'      => 'User Role:',
			'id' => 'userRoleId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user Role.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrUserRole
        ));
      
       
         
        $this->addElement('text', 'mobile', array(
            'label'      => 'Mobile Number:',
        	
        	'class' =>'text-input medium-input',
        	'decorators' => $this->elementDecorators,	
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));   
        
        
        $this->addElement('textarea', 'correspondenceAddress', array(
            'label'      => 'Correspondence Address:',
            'class' =>'text-input textarea address',
            'required'   => false,
           
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        
        $this->addElement('file', 'profilePicture', array(
            'class' =>'text-input medium-input',
        	'label'      => 'Profile Picture:',
            'required'   => false,
        	'decorators' => $this->fileDecorators,
        ));
        $this->getElement('profilePicture')->addValidator('Size', false, 1024*1024*5); //2 MB file is allowed
        $this->getElement('profilePicture')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 5 MB.","fileSizeTooSmall"=>""));
        $this->getElement('profilePicture')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
        $this->getElement('profilePicture')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		
			
		
        
        $this->addElement('select', 'status',array(
            'label'      => 'Status:',
			'id' => 'status',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select status.')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>array("active"=>"Active","inactive"=>"Inactive")
        ));
        
		
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'button',
            'ignore'   => true,
            'label'    => 'Submit',
          'value'=>'submit',
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
