<?php
//ritesh
class Application_Form_ADDACONNECTION extends Zend_Form
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
	
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
         $this->addElement('text', 'toEmail', array(
            'label'      => 'Your Email',
        	'TABINDEX'=>'1',
            
            'required'   => true,
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),            
        ));
		
		$this->addElement('text', 'name', array(
            'label'      => 'Your Name:',
        	'class' =>'form',
        	'TABINDEX'=>'5',
            'required'   => true,
        	'decorators' => $this->elementDecorators,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter surname')))
            	),
            'filters'    => array('StringTrim'),
        ));
        
      
        
        $arrStatus=Array("gmail"=>"Gmail", "yahoo"=>"Yahoo");
    	$this->addElement('select', 'status',array(
            'label'      => 'Select Account',
        	'class' =>'form',
        	//'TABINDEX'=>'6',
            
         	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the account')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrStatus
        ));
        
        
        
        
        
             $this->addElement('password', 'password', array(
            'label'      => 'Password:',
        	'autocomplete'=>"off",
            'required'   => true,
        	'TABINDEX'=>'3',
        	'class' =>'form',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter password'))),
                array('validator' => 'StringLength', 'options' => array(6, 20))
                
            )
        ))
        ;
        
        
          $this->addElement('submit', 'submit', array(
         
            'label'    => 'LOAD CONTACT',
        	'decorators'=>$this->buttonDecorators
        ));
    
      
    
        
        
         $this->addElement('textarea', 'content', array(
            'label'      => 'Your Contact:',
            'required'   => true,
            'rows'=>'8',
            'cols'=>'70',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty',true, array("messages"=>array('isEmpty'=>'please enter your contact ')))
                )
        ));
        
        
        
        
          
        $this->addElement('textarea', 'body', array(
            'label'      => 'Message:',
            'required'   => true,
            'rows'=>'8',
            'cols'=>'70',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty',true, array("messages"=>array('isEmpty'=>'please enter a message ')))
                )
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
