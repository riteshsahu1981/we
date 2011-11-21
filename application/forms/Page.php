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
class Application_Form_Page extends Zend_Form
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
    
    
    public function init()
    {
        // Dojo-enable the form:
       //Zend_Dojo::enableForm($this);

	   $this->addElement('text', 'title', array(
            'label'      => 'Page Title :',
			'class' =>'text-input medium-input',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page title')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'identifire', array(
            'label'      => 'URL Re-write :',
			'class' =>'text-input medium-input',
           // 'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page URL Re-write.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        // Add an body element
         $this->addElement('textarea', 'content', array(
            'label'      => 'Page Content:',
            'required'   => false,
        	'validators' => array(
                    array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page content')))
                    ),
        	'decorators' => $this->elementDecorators,
                'class' =>'ckeditor',
        	'filters'    => array('StringTrim')
        ));
        
        $this->addElement('textarea', 'metaTitle', array(
            'label'      => 'Meta Title :',
        	'cols'=>'50',
        	'rows'=>'3',
		'class' =>'text-input textarea address',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page identifire')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaKeyword', array(
            'label'      => 'Meta Keyword :',
        	'cols'=>'50',
        	'rows'=>'3',
			'class' =>'text-input textarea address',
            'required'   => false,
         	
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaDescription', array(
            'label'      => 'Meta Description :',
        	
			'class' =>'text-input textarea address',
            'required'   => false,         	
        	'decorators' => $this->elementDecorators,
        ));
         $this->addElement('select', 'status', array(    	
        'label'=>'Status:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        '1'=>"Publish",
        '0'=>"Unpublish",
		),
        'value'=>"1"
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
