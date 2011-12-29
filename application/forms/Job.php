<?php
class Application_Form_Job extends Zend_Form
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
        $this->setName('frmJob');
	   
	   $this->addElement('text', 'title', array(
            'label'      => 'Job Title:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter job title'))),
            array('Db_NoRecordExists', true, array(
            'table' => 'job',
            'field' => 'title',
            'messages'=>'job title already exists'
            ))
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
           
       $this->addElement('textarea', 'description', array(
            'label'      => 'Job Description:',
            'class' =>'text-input textarea address',
            'required'   => true,
           'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter job description')))
            
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
        

       $arrDepartment=array();
      $department=new Application_Model_Department();
       $arrDepartment=$department->getDepartment();
       $this->addElement('select', 'departmentId', array(    	
        'label'=>'Department:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>$arrDepartment,
        
  		));
       
       $noOfOpening=array();
       for($i=1;$i<=100;$i++)
           $noOfOpening[$i]=$i;
       $this->addElement('select', 'noOfOpenings', array(    	
        'label'=>'No Of Openings:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>$noOfOpening,
        'value'=>"1"
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
