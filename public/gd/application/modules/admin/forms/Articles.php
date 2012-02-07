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
class Admin_Form_Articles extends Zend_Form
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
    
	public $fileDecorators =array(
            array('File'),
            array('Errors'),
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    
    public function init()
    {
		//get user lsit
		$userM		= 	new Application_Model_User();
        $usersArr	=	$userM->getUsersList(null, '--- Select Author ---');
         
        $this->addElement('select', 'userId',array(
            'label'      => 'Author:',
        	'style'=>'width: 313px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select author.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$usersArr
        	
        ));
		
		$categories=new Application_Model_Category();
        $categoriesArr=$categories->getCategory("--- Select Category ---","wsv");
		          
        $this->addElement('select', 'categoryId',array(
            'label'      => 'Category:',
        	'style'=>'width: 313px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select category.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$categoriesArr
        	
        ));
	   
	   $this->addElement('text', 'title', array(
            'label'      => 'Title :',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
         $this->addElement('text', 'identifire', array(
            'label'      => 'URL Re-write :',
			'class'		=> 'title-input-box',
             'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the URL Re-write.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        // Add an body element
         $this->addElement('textarea', 'content', array(
            'label'      => 'Content:',
            'required'   => false,
        	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page content.')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        // Add an body element
         $this->addElement('textarea', 'synopsis', array(
            'label'      => 'Synopsis:',
            'required'   => false,
			'class'		=> 'title-input-box',
            'cols'=>'50',
        	'rows'=>'3',
        	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the synopsis.')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        $this->addElement('textarea', 'metaTitle', array(
            'label'      => 'Meta Title :',
        	'cols'=>'50',
			'class'		=> 'title-input-box',
        	'rows'=>'3',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page identifire.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaKeyword', array(
            'label'      => 'Meta Keyword :',
        	'cols'=>'50',
        	'rows'=>'3',
            'required'   => false,
         	'class'		=> 'title-input-box',
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaDescription', array(
            'label'      => 'Meta Description :',
        	'cols'=>'50',
        	'rows'=>'3',
            'required'   => false,
         	'class'		=> 'title-input-box',
        	'decorators' => $this->elementDecorators,
        ));
         
        $Name	=	new Zend_Form_Element_File('image');
        $Name	->setLabel('Upload an image:')
                ->setRequired(false)
                ->addValidator('Extension', false, 'jpg,png,gif')
                ->clearDecorators()
                ->addDecorators($this->fileDecorators); 
      
	  $this->addElements(array($Name));
	  /*
      $this->addElement('submit', 'cmdSubmit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        'decorators' => $this->buttonDecorators,
        ));*/
	   
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
