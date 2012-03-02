<?php

class Admin_Form_Banner extends Zend_Form
{

	
	public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    public $fileDecorators =array( 
    array('File'), 
    array('Errors'),
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
	   $this->addElement('text', 'title', array(
            'label'      => 'Banner Title:',
            'required'   => true,
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the banner name')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('radio', 'bannerType', array(
    	
    	'label'=>'Banner Type : ',
         'required'   => true,
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the banner type.')))
   							),
    	'multiOptions'=>array(
        'image'=>"Image",
        'text'=>"Text / Html",
      	),
      	'decorators' => $this->elementDecorators,
  		));
		$this->getElement('bannerType')->setSeparator('');
        
        $this->addElement('file', 'image', array(
            'label'      => 'Banner Image:',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload the image.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
        
        $this->addElement('text', 'url', array(
            'label'      => 'Banner Url:',
            'required'   => true,
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the banner url')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('radio', 'position', array(
    	
    	'label'=>'Position : ',
         'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the banner position.')))
   							),
    	'multiOptions'=>array(
        'top'=>"Top",
        'bottom'=>"Bottom",
        'left'=>"Left",
        'right'=>"Right",
        'right_home'=>"Right Home"
        
      	),
      	'decorators' => $this->elementDecorators,
  		));
		 $this->getElement('position')->setSeparator(''); 		
  		
         $this->addElement('textarea', 'description', array(
            'label'      => 'Text:',
			'class'		=> 'title-input-box',
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        
      $this->addElement('submit', 'cmdSubmit', array(
            'required' => false,
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
