<?php

class Album_Form_CreateAlbum extends Zend_Form
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
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('text', 'name', array(
            'label'      => 'Album Name',
        'class'=>"form",
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter the album name.')))
        		
            )
        ));
        
     	$this->addElement('text', 'datepicker', array(
            'label'      => 'Album Date',
     		'class'=>"form",
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter the album date.')))
        		
            )
        ));
        
        
        $this->addElement('hidden', 'date', array(
            'label'      => 'Date',
          
        	
            'filters'    => array('StringTrim'),
            
        ))->clearDecorators();
        
        
        $arrStatus=Array("public"=>"Public(Default)", "private"=>"Private");
    	$this->addElement('select', 'status',array(
            'label'      => 'Album Status',
        	'class' =>'form',
        	'TABINDEX'=>'6',
            'class'=>"form",
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the status')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrStatus
        ));
        
        
        
        $category=new Application_Model_Category();
        $arrCategory=$category->getCategory("--Category--");
        
        
    	$this->addElement('select', 'categoryId',array(
            'label'      => 'Category',
        	'class' =>'form',
        	'TABINDEX'=>'6',
            'class'=>"form",
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the category')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCategory
        ));
        
         $this->addElement('text', 'location', array(
            'label'      => 'Location',
         'class'=>"form",
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the location')))
        		
            )
        ));
          $this->addElement('textarea', 'description', array(
            'label'      => 'Description',
            'required'   => false,
            'rows'=>'4',
            'cols'=>'40',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
         
        ));
        
       $this->addElement('text', 'tags', array(
            'label'      => 'Tags',
      		 'class'=>"form",
            'required'   => false,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            
        ));
        
        
        
        
         
        
        
   	$this->addElement('radio', 'enableComments', array(
    	
    	'label'=>'Enable Comments ',
         'required'   => true,
        'TABINDEX'=>'14',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'please enable comment')))
   							),
    	'multiOptions'=>array(
        'yes'=>"Yes",
        'no'=>"No",
      	),
      	'separator'=>"  ",
      	'decorators' => $this->elementDecorators,
      	'value'=>'yes'
  		));

  		$this->addElement('radio', 'enableLikes', array(
    	'label'=>'Enable Likes',
        'required'   => true,
        'TABINDEX'=>'14',
        'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'please enable comment')))
   							),
    	'multiOptions'=>array(
        'yes'=>"Yes",
        'no'=>"No",
      	),
      	'separator'=>"  ",
      	'decorators' => $this->elementDecorators,
      	'value'=>'yes'
  		));
  		
  		
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Save',
        	'decorators'=>$this->buttonDecorators
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