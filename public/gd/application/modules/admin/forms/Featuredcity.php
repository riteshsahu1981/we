<?php
/**
 * This is the featured city form.
 *
 * @uses       Zend_Form
 */
class Admin_Form_Featuredcity extends Zend_Form
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
    
	public $fileDecorators =array(
            array('File'),
            array('Errors'),
            array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    
    public function init()
    {
        // Dojo-enable the form:
        //Zend_Dojo::enableForm($this);
		
        $cityM		=	new Application_Model_City();
        $citiesArr	=	$cityM->getCities(array(""=>"--Select City--"));
		
		$countryM	=	new Application_Model_Country();
        $countryArr	=	$countryM->getCountry();
		
		/*
		$this->addElement('select', 'featured_top',array(
            'label'      => 'Top Featured Place:',
        	'style'=>'width: 350px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select top featured place.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$citiesArr        	
        ));
		*/
		
		$this->addElement('Multiselect', 'featured_other',array(
            'label'      => 'Featured Places/Cities:',
        	'style'=>'width: 350px;',
			'size'=>10,
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select featured places/cities.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$citiesArr
        ));
		
		$this->addElement('Multiselect', 'featured_country',array(
            'label'      => 'Featured Countries:',
        	'style'=>'width: 350px;',
			'size'=>10,
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select featured countries.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$countryArr
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
