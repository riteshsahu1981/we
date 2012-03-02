<?php
class Admin_Form_SearchArticles extends Zend_Form
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
        $this->addElement('text', 'title', array(
            'label'      	=> 'Title :',
			'class'		=> '',
        	'decorators' => $this->elementDecorators,
        ));
		
		$categories=new Application_Model_Category();
        $categoriesArr=$categories->getCategory("--- Select Category ---","wsv");
         
        $this->addElement('select', 'category_id',array(
            'label'      => 'Category:',
        	'style'=>'width: 250px;',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$categoriesArr
        ));
		
	    $this->addElement('radio', 'status', array(
			'label'=>'Staus: ',
			'value'=>'',			
			'multiOptions'=>array(
			'1'=>"Published",
			'0'=>"Unpublished",
			''=>"All"
			),
			'decorators' => $this->elementDecorators,
  		));
		$this->getElement('status')->setSeparator('');
		
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
