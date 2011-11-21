<?php
class Application_Form_Appriciation extends Zend_Form
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
	   
        

        $model	=new Application_Model_User();
        $arr =	$model->getAllUsers();
        $arr=array_merge(array(''=>'Select'),$arr);
	$this->addElement('select', 'userId',array(
            'label'      => 'Employee:',
			
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select employee')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arr 
        ));

        $model	=new Application_Model_AppriciationType();
        $arr =	$model->getAppriciationType();
        //$arr=array_merge(array(''=>'Select'),$arr);
        $this->addElement('select', 'appriciationTypeId',array(
            'label'      => 'Appriciation Type:',
			
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select type')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arr 
        ));
       $this->addElement('text', 'appriciationDate', array(
            'label'      => 'Date:',
        	'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter date')))
            	),
        	'class' =>'text-input small-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
       
       
        
        
          
        $this->addElement('textarea', 'remarks', array(
            'label'      => 'Remarks:',
            'class' =>'text-input textarea address',
            'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter remarks.')))
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
