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
class Application_Form_Login extends Zend_Form
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
      

	$this->addElement('text', 'email', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            
            'required'   => true,
            'validators' => array(
        			array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your username/email.'))),        	
            ),
            'class' =>"text-input small-input",
           
             
            'label'      => 'Email/Username',
            'autocomplete'=>"off",
            'decorators' => $this->elementDecorators,
        ));

       $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
       			array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter password.'))),
                'Alnum',
                array('StringLength', false, array(6, 20)),
            ),
            'required'   => true,
           
            'label'      => 'Password',
            "class"	=> "text-input small-input",
            'autocomplete'=>"off",
            'decorators' => $this->elementDecorators,
        ));
        
          
        

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
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
