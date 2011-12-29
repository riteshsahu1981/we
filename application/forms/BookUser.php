<?php
class Application_Form_BookUser extends Zend_Form
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
            	
        $this->setName('frmBookUser');
                $model=new Application_Model_User();

       $users=$model->getAllUsers("active");
        $this->addElement('select', 'userId',array(
            'label'      => 'Employee:',
			
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$users
        ));
        
	   $this->addElement('text', 'issueDate', array(
            'label'      => 'Issue Date:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter issue date')))
            	),
        	'class' =>'text-input medium-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
      
        $this->addElement('text', 'estimatedReturnDate', array(
            'label'      => 'Estimated Return Date:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter estimated return date')))
            	),
        	'class' =>'text-input medium-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
	
        $this->addElement('text', 'returnDate', array(
            'label'      => 'Return Date:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter return date')))
            	),
        	'class' =>'text-input medium-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
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
