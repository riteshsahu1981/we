<?php
class Application_Form_Department extends Zend_Form
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
  


    
    
    public function init()
    {
        $this->setName('frmDepartment');
	   
	   $this->addElement('text', 'title', array(
            'label'      => 'Department Title:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter designation title'))),
            array('Db_NoRecordExists', true, array(
            'table' => 'department',
            'field' => 'title',
            'messages'=>'department title already exists'
            ))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
           
           $this->addElement('select', 'type',array(
            'label'      => 'Type:',

                'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select department type.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>array("normal"=>"Normal", "operations"=>"Operations")
        ));
           $arrUser=array();
           $user=new Application_Model_User();
           $arrUser=$user->getAllUsers("active");
           //$arrUser=array_merge(array(''=>'Select'),$arrUser);
           $this->addElement('select', 'departmentHeadId',array(
            'label'      => 'Department Head:',

                'style' => 'width:193px',
        	'class' =>'text-input medium-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select department head.')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrUser
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
