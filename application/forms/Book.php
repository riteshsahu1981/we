<?php
class Application_Form_Book extends Zend_Form
{
   public $elementDecorators = array(
        'ViewHelper',
        array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
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
       array('Errors', array('class'=>'input-notification-ul-li error png_bg')),
    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
    array('Label', array('tag' => 'td')),
    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
);

    
    
    public function init()
    {
            	
        $this->setName('frmBook');
	$this->addElement('text', 'title', array(
            'label'      => 'Title:',
        	
        	'class' =>'text-input medium-input',
        	
                'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter the book title'))),
                	 array('Db_NoRecordExists', true, array(
                        'table' => 'book',
                        'field' => 'title',
                        'messages'=>'book with the same title already exists'
                        ))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
        
       $this->addElement('text', 'isbn', array(
            'label'      => 'ISBN:',
            'class' =>'text-input medium-input',
            'required'   => true,
           'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter the isbn'))),
                	 array('Db_NoRecordExists', true, array(
                        'table' => 'book',
                        'field' => 'isbn',
                        'messages'=>'book with the same isbn already exists'
                        ))
            	),
           
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
       $this->addElement('text', 'author', array(
            'label'      => 'Author:',
            'class' =>'text-input medium-input',
            'required'   => false,
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
       
        $this->addElement('textarea', 'description', array(
            'label'      => 'Description:',
            'class' =>'text-input textarea address',
            'required'   => false,
           
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        
        $this->addElement('text', 'publisher', array(
            'label'      => 'Publisher:',
            'class' =>'text-input medium-input',
            'required'   => false,
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
			 
       

        
      
        
		
      $this->addElement('submit', 'submit', array(
            'required' => false,
      		'class' =>'button',
            'ignore'   => true,
            'label'    => 'Submit',
          'value'=>'submit',
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
