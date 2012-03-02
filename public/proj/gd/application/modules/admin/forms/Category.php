<?php

class Admin_Form_Category extends Zend_Form
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
    public $fileDecorators =array( 
	    array('File'), 
	    array('Errors'),
	    array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
	    array('Label', array('tag' => 'td')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
	);
    
    
    public function init()
    {
		 $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
		 
	   $this->addElement('text', 'name', array(
            'label'      => 'Category Name :',
            'required'   => true,
			'class'		=> 'subtitle-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Category name')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('text', 'urlText', array(
            'label'      => 'URL Text:',
			'class'		=> 'title-input-box',
            'required'   => false,
			'maxlength'=>250,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the URL text')))
   							),
			'decorators' => $this->elementDecorators
        ));
		
		$this->addElement('text', 'urlLink', array(
            'label'      => 'URL Link:',
			'class'		=> 'title-input-box',
            'required'   => false,
			'value' => 'http://',
        	'decorators' => $this->elementDecorators
        ));
		$this->getElement('urlLink')->addValidator('url', true, array());
		
		$this->addElement('textarea', 'description', array(
            'label'      => 'Description:',
			'class'		=> 'title-input-box',
        	'rows'=>'10',
        	'cols'=>'60',
            'required'   => false,
        	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page content')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
		$this->addElement('radio', 'status', array(
    	'label'=>'Status : ',
         'required'   => true,
         'value'=>'published',
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the status.')))
   							),
    	'multiOptions'=>array(
        'published'=>"Publish",
        'unpublished'=>"Unpublish",
      	),
      	'decorators' => $this->elementDecorators,
  		));
		$this->getElement('status')->setSeparator("");
		
        $this->addElement('file', 'image', array(
            'class'		=>"input-browse",
        	'label'      => 'Image',
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('image')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('image')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('image')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('image')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		$orderArr = "";
		for($order=1; $order<=50; $order++)
		{
			$orderArr[$order] = $order;
		}
		$this->addElement('select', 'weight',array(
            'label'      => 'Order:',
        	'style'=>'width: 50px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select order.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$orderArr        	
        ));
        
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
