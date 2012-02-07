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
class Admin_Form_Page extends Zend_Form
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
        // Dojo-enable the form:
       //Zend_Dojo::enableForm($this);

	   $this->addElement('text', 'title', array(
            'label'      => 'Page Title :',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page title')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'identifire', array(
            'label'      => 'URL Re-write :',
			'class'		=> 'title-input-box',
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
        	'filters'    => array('StringTrim')
        ));
        
        $this->addElement('textarea', 'metaTitle', array(
            'label'      => 'Meta Title :',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
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
			'class'		=> 'title-input-box',
            'required'   => false,
         	
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaDescription', array(
            'label'      => 'Meta Description :',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => false,         	
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('submit', 'savePublish', array(
            'required' => false,
            'ignore'   => true,
			'title'	=> 'Save and Publish',
            'label'    => 'Save and Publish',
            'decorators' => $this->buttonDecorators,
        ));
	
		$this->addElement('submit', 'saveUnpublish', array(
            'required' => false,
            'ignore'   => true,
			'title'	=> 'Save and Unpublish',
            'label'    => 'Save and Unpublish',
            'decorators' => $this->buttonDecorators,
        ));
		
		$this->addElement('submit', 'previewPage', array(
            'required' => false,
            'ignore'   => true,
			'title'	=> 'Preview Page',
            'label'    => 'Preview Page',
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
