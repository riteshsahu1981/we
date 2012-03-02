<?php
class Admin_Form_SearchUsers extends Zend_Form
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
        $this->addElement('text', 'name', array(
            'label'      	=> 'Name:',
			'class'		=> '',
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('text', 'username', array(
            'label'      	=> 'Username:',
			'class'		=> '',
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('text', 'email', array(
            'label'      	=> 'Email:',
			'class'		=> '',
        	'decorators' => $this->elementDecorators,
        ));
		$this->addElement('radio', 'status', array(
			'label'=>'Staus: ',
			'value'=>'',			
			'multiOptions'=>array(
			'active'=>"Active",
			'inactive'=>"Inactive",
			''=>"All"
			),
			'decorators' => $this->elementDecorators,
  		));
		$this->getElement('status')->setSeparator('');
		
		$this->addElement('radio', 'gender', array(
			'label'=>'Publish: ',
			'value'=>'',			
			'multiOptions'=>array(
			'male'=>"Male",
			'female'=>"Female",
			''=>"All"
			),
			'decorators' => $this->elementDecorators,
  		));
		$this->getElement('gender')->setSeparator('');
//                $arrPageSize=array("10"=>"10", "25"=>"25", "50"=>"50", "75"=>"75", "100"=>"100");
//                $this->addElement('select', 'page_size',array(
//            'label'      => 'Record display per page:',
//        	'style'=>'width: 50px;',
//        	'required'   => false,
//
//        	'decorators' => $this->elementDecorators,
//            'filters'    => array('StringTrim'),
//        	'MultiOptions'=>$arrPageSize
//        ));



		$this->addElement('submit', 'submit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Search',
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
