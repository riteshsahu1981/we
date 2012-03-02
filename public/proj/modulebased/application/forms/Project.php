<?php
class Application_Form_Project extends Zend_Form
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
        $this->setName('frmProject');
	   
	   $this->addElement('text', 'title', array(
            'label'      => 'Project Title:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter project title')))
            
            ),
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
        $this->addElement('textarea', 'clientInfo', array(
            'label'      => 'Client Info.:',
            'class' =>'text-input textarea address',
            'required'   => false,
           
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));   
         $this->addElement('text', 'startDate', array(
            'label'      => 'Start Date:',
            'required'   => true,
            'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter start date')))
            	),
        	'class' =>'text-input small-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('text', 'endDate', array(
            'label'      => 'End Date:',
            'required'   => false,
           
        	'class' =>'text-input small-input',
           'readonly' =>'true',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
        ));
         $this->addElement('select', 'status', array(    	
        'label'=>'Status:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        'open'=>"Open",
        'close'=>"Close",
		),
        'value'=>"open"
  		));
         
         $user=new Application_Model_User();
         $arrUser=$user->getAllUsers('active');
          $this->addElement('select', 'projectManagerId', array(    	
        'label'=>'Project Manager:',
            'class' =>'text-input small-input',
         'required'   => false,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>$arrUser
       
  		));
          
          $this->addElement('select', 'teamLeaderId', array(    	
        'label'=>'Team Leader:',
            'class' =>'text-input small-input',
         'required'   => false,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>$arrUser
       
  		));
          
         
         $this->addElement('select', 'resource', array(    	
        'label'=>'Resource:',
            'class' =>'text-input small-input',
         'required'   => false,
         'decorators' => $this->elementDecorators,
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
