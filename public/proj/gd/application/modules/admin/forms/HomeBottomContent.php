<?php
class Admin_Form_HomeBottomContent extends Zend_Form
{
	public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    );
    public $fileDecorators =array( 
    array('File'), 
    array('Errors'),
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
	    $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
		$this->addElement('file', 'backgroundImage', array(
            'label'      => 'Background Image:',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload background image.')))
								,array('Size',false,1024, array('messages'=>array('size'=>'Size can not be greater than 100KB.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('backgroundImage')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('backgroundImage')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('backgroundImage')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('backgroundImage')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		$this->addElement('text', 'leftTitle', array(
            'label'      => 'Left Content Title:',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the left content title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('textarea', 'leftText', array(
            'label'		=> 'Left Content:',
			'cols'		=> '80',
			'rows'		=> '5',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the left content text.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		 
		$this->addElement('text', 'rightTitle', array(
            'label'      => 'Right Content Title:',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the right content title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('textarea', 'rightText', array(
            'label'		=> 'Right Content:',
			'cols'		=> '80',
			'rows'		=> '5',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the right content text.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));        
        
		/*$this->addElement('radio', 'status', array(    	
    	'label'=>'Status:',
         'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the status.')))
   							),
    	'multiOptions'=>array(
        '1'=>"Publish",
		'0'=>"Unpublish"
        ),
      	'decorators' => $this->elementDecorators,
  		));
		*/
		
        $this->addElement('submit', 'cmdSubmit', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
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
