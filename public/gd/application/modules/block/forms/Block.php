<?php

class Block_Form_Block extends Zend_Form
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
            'label'      => 'Block Title:',
            'required'   => true,
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Block title')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'alias', array(
            'label'      => 'Alias:',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the alias')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        $this->addElement('textarea', 'body', array(
            'label'      => 'Body:',
			'class'		=> 'title-input-box',
         	'rows'=>'5',
         	'cols'=>'60',
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        $this->addElement('radio', 'status', array(
    	'label'=>'Staus : ',
         'required'   => true,
        'value'=>'1',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the status.')))
   							),
    	'multiOptions'=>array(
        '1'=>"Publish",
        '0'=>"Unpublish",
      	),
      	'decorators' => $this->elementDecorators,
  		));
        $this->getElement('status')->setSeparator('');
  		
  		$country=new Block_Model_BlockRegion();
        $arrCountry=$country->getBlockRegion("--select---");
         
        $this->addElement('select', 'blockRegionId',array(
            'label'      => 'Block-Region:',
        	'class' =>'form',
        	'TABINDEX'=>'6',
            
         	
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCountry
        ));
        
  		
  		$this->addElement('text', 'weight', array(
            'label'      => 'Weight:',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the weight')))
   							),
   			'value'=>'0',
        	'decorators' => $this->elementDecorators,
        ));
        
  		
         $this->addElement('textarea', 'visibilityPaths', array(
            'label'      => 'Visibility Paths:',
			'class'		=> 'title-input-box',
         	'rows'=>'5',
         	'cols'=>'60',
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
