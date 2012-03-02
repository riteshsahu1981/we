<?php

class Application_Form_Email extends Zend_Form
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
      
        
        
        
        
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address',
        	'TABINDEX'=>'1',
            'required'   => true,
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
        		array('Db_NoRecordExists', true, array(
        			'table' => 'user',
	       			'field' => 'email',
	       			'messages'=>'Please choose another email address.'
	    			))
            )
            
            
        ));
   
             $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'signup',
      
	      	'TABINDEX'=>'20',
            'ignore'   => true,
            'label'    => 'Save',
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