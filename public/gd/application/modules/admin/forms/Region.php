<?php

class Admin_Form_Region extends Zend_Form
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
            'label'      => 'Region Name :',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the region name')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
	
        
       $country=new Application_Model_Country();
       $arrCountry=$country->getCountry("--select---");
         
        $this->addElement('select', 'countryId',array(
            'label'      => 'Country:',
        	'style'=>'width: 100%;',
        	'TABINDEX'=>'6',
            
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select country')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCountry
        	
        ));
        
        $continent=new Application_Model_Continent();
       $arrContinent=$continent->getContinent("--select---");
         
        $this->addElement('select', 'continentId',array(
            'label'      => 'Continent:',
        	'style'=>'width: 100%;',
        	'TABINDEX'=>'6',
            
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select continent')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrContinent
        	
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