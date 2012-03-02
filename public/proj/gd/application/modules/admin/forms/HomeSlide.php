<?php

class Admin_Form_HomeSlide extends Zend_Form
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
	   $this->addElement('file', 'widgetImage', array(
            'label'      => 'Slide Image:',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload the image.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('widgetImage')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('widgetImage')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('widgetImage')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('widgetImage')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		//$this->getElement('widgetImage')->addValidator('Extension', false, array('jpg', 'png'));
		//$this->getElement('widgetImage')->addValidator('ImageSize', false,array('minwidth' => 40,'maxwidth' => 80,'minheight' => 100,'maxheight' => 200));
		
	   $this->addElement('text', 'widgetTitle', array(
            'label'      => 'Slide Title:',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('radio', 'widgetType', array(
    	
    	'label'=>'Slide Type:',
         'required'   => true,
         'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the slide type.')))
   							),
    	'multiOptions'=>array(
        'image'=>"Image",
        'text'=>"Text / Html",
      	),
      	'decorators' => $this->elementDecorators,
  		));
        $this->getElement('widgetType')->setSeparator('');
		
        $this->addElement('textarea', 'widgetText', array(
            'label'		=> 'Slide Text/HTML:',
			'cols'		=> '80',
			'rows'		=> '5',
			'class'		=> 'title-input-box',
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		
		
		$this->addElement('text', 'widgetAltText', array(
            'label'      => 'ALT Text:',
            'required'   => false,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('textarea', 'widgetLinkLabel', array(
            'label'		=> 'Link Text:',
			'cols'		=> '80',
			'required'   => true,
			'rows'		=> '5',
			'class'		=> 'title-input-box',
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the link text.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		$this->getElement('widgetLinkLabel')->addValidator('StringLength', true, array("max"=>250)); //max 250 characters only
		$this->getElement('widgetLinkLabel')->getValidator('StringLength')->setMessages(array("stringLengthTooLong"=>"Maximum 250 characters are allowed.","stringLengthTooShort"=>""));
		
        $this->addElement('text', 'widgetLinkUrl', array(
            'label'      => 'Link Url:',
            'required'   => false,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the link url.')))
   							),
        	'decorators' => $this->elementDecorators,
			'value'=>'http://'
        ));
		$this->getElement('widgetLinkUrl')->addValidator('url', true, array());
		
		$this->addElement('radio', 'widgetLinkTarget', array(
    	
    	'label'=>'Link Target:',
         'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
   							),
    	'multiOptions'=>array(
        '_blank'=>"New Window (_blank)",
        '_top'=>"Topmost Window (_top)",
        '_self'=>"Same Window (_self)",
        '_parent'=>"Parent Window (_parent)"
      	),
      	'decorators' => $this->elementDecorators,
  		));
		$this->getElement('widgetLinkTarget')->setSeparator('');
		/*
  		$this->addElement('text', 'weight', array(
            'label'      => 'Weight:',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the weight.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));*/
		$orderArr = "";
		for($order=1; $order<=20; $order++)
		{
			$orderArr[$order] = $order;
		}
		$this->addElement('select', 'weight',array(
            'label'      => 'Order:',
        	'style'=>'width: 50px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select slide order.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$orderArr        	
        ));
		
	  $this->addElement('radio', 'status', array(    	
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
		$this->getElement('status')->setSeparator('');
		
		/*
		$this->addElement('textarea', 'widgetDesc', array(
            'label'     => 'Description:',
			'cols'		=> '80',
			'rows'		=> '5',
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));*/
		
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
