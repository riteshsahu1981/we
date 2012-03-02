<?php
class Application_Form_Contact extends Zend_Form
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
        
        // Add an first name element
        $this->addElement('text', 'contact_name', array(
            'label'      => 'Name:',
			'maxlength'=>100,
        	'class' =>'form',
			'style' => 'width:570px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your name.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
		
		$this->addElement('text', 'contact_email', array(
            'label'      => 'Email:',
        	/*'autocomplete'=>"off",*/
        	'class' =>'form',
			'style' => 'width:570px;',
			'maxlength'=>100,
        	'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your email address.'))),
                    array('EmailAddress', true, array('messages'=>'Please enter valid email address.')),
                ),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));

        $this->addElement('textarea', 'contact_reason', array(
            'label' => 'Reason for Contacting:',
        	'class' => 'textarea-img',
			'style' => '',
			'rows' => 10,
			'cols' => 80,
        	'required' => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter reason for contacting.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));  		
  		
        /*
  		$this->addElement('captcha', 'fcaptcha', array(
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
      		'class' =>'signup right',
            'ignore'   => true,
            'label'    => 'Submit',
			'decorators' => $this->buttonDecorators,
        ));
		
		//add badword validations to each form fields
		//$this->getElement('contact_name')->addValidator('Badwords', true);
		//$this->getElement('contact_email')->addValidator('Badwords', true);
		//$this->getElement('contact_reason')->addValidator('Badwords', true);         
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
