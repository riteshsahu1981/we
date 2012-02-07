<?php

class Application_Form_Advertise extends Zend_Form
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

	   $this->addElement('text', 'name', array(
            'label'      => 'Name :',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter your name')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
  		$this->addElement('text', 'email', array(
            'label'      => 'Email :',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            ),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('text', 'phone', array(
            'label'      => 'Phone :',
            'required'   => true,
            'filters'    => array('StringTrim'),
           'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter your phone number.')))
   							),
            'decorators' => $this->elementDecorators,
        ));
         $this->addElement('textarea', 'enquiry', array(
            'label'      => 'Enquiry :',
            'required'   => true,
         	'rows'=>'5',
         	'cols'=>'50',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the enquiry')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
      $this->addElement('submit', 'cmdSubmit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => '',
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