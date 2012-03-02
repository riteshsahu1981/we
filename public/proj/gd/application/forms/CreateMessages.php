<?php
class Application_Form_CreateMessages extends Zend_Form
{

	public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element'),array('tag' => 'option', 'class' => 'selected')),
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
        // Set the method for the display form to POST
        $this->setMethod('post');
		//$this->setAttrib("onsubmit", "return fncSubmitMessageForm(this);");
        // Add an email element
         $this->addElement('text', 'toEmail', array(
            'label'      => 'To',
			'id' => 'toEmail',
        	'required'   => true,
			'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enter your name.')))
            	),
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        ));
		
	  /*	
       $toEmailArr = array(""=>"--- Select Receipents ---");
	   
	   $this->addElement('select', 'toEmail', array(
            'label'      => 'To',
			'id' => 'toEmail',
        	'required'   => false,
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
			'MultiOptions'=>$toEmailArr
		));
		*/
        $this->addElement('hidden', 'toId', array(            
        	//'required'   => true,
        	'class' =>'form',        	
            'filters'    => array('StringTrim'),            
        ))->clearDecorators();
       
        $this->addElement('text', 'subject', array(
            'label'      => 'Subject',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),           
        ));
        
        $this->addElement('textarea', 'body', array(
            'label'      => 'Message',
            'required'   => true,
            'rows'=>'4',
            'cols'=>'40',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            /*'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )*/
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(         
            'label'    => 'Send Message',
        	'decorators'=>$this->buttonDecorators
        ));
		/*	
         $this->addElement('reset', 'reset', array(          
            'label'    => 'Cancel',
            'decorators'=>$this->buttonDecorators
        ));
		*/
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
