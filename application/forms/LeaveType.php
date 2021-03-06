<?php
class Application_Form_LeaveType extends Zend_Form
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
        $this->setName('frmLeaveType');
	   
        $this->addElement('text', 'code', array(
            'label'      => 'Code:',
            
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter leave code'))),
            array('Db_NoRecordExists', true, array(
            'table' => 'leave_type',
            'field' => 'code',
            'messages'=>'leave code already exists'
            ))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
        
       $this->addElement('text', 'title', array(
            'label'      => 'Title:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter leave title'))),
            array('Db_NoRecordExists', true, array(
            'table' => 'leave_type',
            'field' => 'title',
            'messages'=>'leave title already exists'
            ))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
        
       $this->addElement('text', 'totalLeavesInYear', array(
            'label'      => 'Total Leaves In A Year:',
            'validators'=>array( array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter total leaves in a year'))),
                array('Digits', false, array('messages'=>'Please enter numeric value'))),
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,	
            'required'   => true,
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
