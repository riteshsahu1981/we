<?php
class Application_Form_Album extends Zend_Form
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
            	
        $this->setName('frmAlbum');
		
       

	   
           
	   $this->addElement('text', 'title', array(
            'label'      => 'Title:',
        	
        	'class' =>'text-input medium-input',
        	
                'required'   => true,
         	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter album title'))),
                	
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
        
        
        $this->addElement('file', 'coverImage', array(
            'class' =>'text-input medium-input',
            'label'      => 'Cover Image:',
            'required'   => false,
            'decorators' => $this->fileDecorators,
        ));
        $this->getElement('coverImage')->addValidator('Size', false, 1024*1024*7); //7 MB file is allowed
        $this->getElement('coverImage')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 5 MB.","fileSizeTooSmall"=>""));
        $this->getElement('coverImage')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
        $this->getElement('coverImage')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		
			 
        $this->addElement('select', 'status', array(    	
        'label'=>'Status:',
            'class' =>'text-input small-input',
         'required'   => true,
         'decorators' => $this->elementDecorators,
    	'MultiOptions'=>array(
        'publish'=>"Publish",
        'unpublish'=>"Unpublish",
		),
        'value'=>"publish"
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
