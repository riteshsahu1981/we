<?php
class Application_Form_EmployeeImport extends Zend_Form
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
         $this->addElement('file', 'employeeSheet', array(
            'class' =>'text-input medium-input',
            'label'      => 'Employee Sheet:',
            'required'   => true,
             
            'decorators' => $this->fileDecorators,
        ));
        $this->getElement('employeeSheet')->addValidator('Size', false, 1024*1024*20); //2 MB file is allowed
        $this->getElement('employeeSheet')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 20 MB.","fileSizeTooSmall"=>""));
        $this->getElement('employeeSheet')->addValidator('Extension', false, 'xls,xlsx');
        $this->getElement('employeeSheet')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload xls or xlsx file only.","fileExtensionNotFound"=>""));
		
	
		
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
