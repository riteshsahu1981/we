<?php

class Admin_Form_State extends Zend_Form
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
            'label'      => 'State Name :',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the state name')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
	
        
       $region=new Application_Model_Region();
       $arrRegion=$region->getRegion("--select---");
         
        $this->addElement('select', 'regionId',array(
            'label'      => 'Region :',
        	'style'=>'width: 100%;',
        	'TABINDEX'=>'6',
            
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select region')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrRegion
        	
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