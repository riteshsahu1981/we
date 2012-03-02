<?php

/**
 * This is the user form.  It is in its own directory in the application 
 * structure because it represents a "composite asset" in your application.  By 
 * "composite", it is meant that the form encompasses several aspects of the 
 * application: it handles part of the display logic (view), it also handles 
 * validation and filtering (controller and model).  
 *
 * @uses       Zend_Form
 * @package    QuickStart
 * @subpackage Form
 */
class Application_Form_ChangePassword extends Zend_Form
{
    /**
     * init() is the initialization routine called when Zend_Form objects are 
     * created. In most cases, it make alot of sense to put definitions in this 
     * method, as you can see below.  This is not required, but suggested.  
     * There might exist other application scenarios where one might want to 
     * configure their form objects in a different way, those are best 
     * described in the manual:
     *
     * @see    http://framework.zend.com/manual/en/zend.form.html
     * @return void
     */ 
	
	 function __construct($options = null)
	 {
		parent::__construct($options);
	 	
	}
	
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
        // Dojo-enable the form:
       //Zend_Dojo::enableForm($this);

	    
 		$this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
	// Set the method for the display form to POST
        $this->setMethod('post');
        
        
       /*  // Add an email element
        $this->addElement('hidden', 'iframesignup', array(
            'value'   => 'iframesignup',
        ));*/
        

        
          // Add an password element
        $this->addElement('password', 'password', array(
            'label'      => 'Password:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 20)),
                
            ),
            'decorators' => $this->elementDecorators,
        ))
        ->getElement('password')
        ->addValidator('IdenticalField', false, array('confirmPassword', 'Confirm Password'));

            // Add an password element
        $this->addElement('password', 'confirmPassword', array(
            'label'      => 'Retype Password:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(6, 20))
                
            ),
            'decorators' => $this->elementDecorators,
        ));
        
        // Add the submit button
        
         $login = $this->addElement('submit', 'submit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        'decorators' => $this->buttonDecorators,
        ));
       /* $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save');
        $this->addElement($submit);*/
	     
    }
	public function loadDefaultDecorators(){
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }
    

}