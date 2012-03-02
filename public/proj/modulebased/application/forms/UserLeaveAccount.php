<?php
class Application_Form_UserLeaveAccount extends Zend_Form
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
        $this->setName('frmUserLeaveAccount');
	   
          
        $this->addElement('select', 'transactionType', array(    	
                'label'=>'Transaction Type:',
                'class' =>'text-input small-input',
                'required'   => true,
                'decorators' => $this->elementDecorators,
                'MultiOptions'=>array(
                    'credit'=>"Credit",
                'debit'=>"Debit"
                
		)
     
  		));
         $model	=	new Application_Model_LeaveType();
        $arrDesignation	=	$model->getLeaveTypes();
	$this->addElement('select', 'leaveTypeId',array(
            'label'      => 'Leave Type:',
			'id' => 'leaveTypeId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select leave type.')))
            	),
                'decorators' => $this->elementDecorators,
                'filtcoratoers'    => array('StringTrim'),
        	'MultiOptions'=>$arrDesignation
        ));
        
        
	   $this->addElement('text', 'value', array(
            'label'      => 'Value:',
            'autocomplete'=>"off",
            'class' =>'text-input small-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter number of leaves debit/credit'))),
            array('Float', false, array('messages'=>'Please enter float value'))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
           $this->addElement('textarea', 'narration', array(
            'label'      => 'Narration:',
            'class' =>'text-input textarea address',
            'required'   => true,
           'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter narration!')))
            ),
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
