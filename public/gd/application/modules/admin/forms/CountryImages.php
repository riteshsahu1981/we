<?php
class Admin_Form_CountryImages extends Zend_Form
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
	   
	   $this->addElement('file', 'countryImage', array(
            'label'      => 'Upload Image:',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload the image.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('countryImage')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('countryImage')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('countryImage')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('countryImage')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		$this->addElement('text', 'slideTitle', array(
            'label'      => 'Caption:',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the caption.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
	  /*	
	   $this->addElement('text', 'slideTitle', array(
            'label'      => 'Slide Title:',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('radio', 'slideType', array(    	
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
        $this->getElement('slideType')->setSeparator('');
		
        $this->addElement('textarea', 'slideText', array(
            'label'		=> 'Slide Text/HTML:',
			'required'   => false,
			'class'		=> 'title-input-box',
			'cols'		=> '80',
			'rows'		=> '5',
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		
		$this->addElement('text', 'slideLinkLabel', array(
            'label'      => 'Link Title:',
			'class'		=> 'title-input-box',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the link title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		
		$this->addElement('text', 'slideLinkUrl', array(
            'label'      => 'Link URL:',
			'class'		=> 'title-input-box',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the link url.')))
   							),
        	'decorators' => $this->elementDecorators,
			'value'=>'http://'
        ));
		$this->getElement('slideLinkUrl')->addValidator('url', true, array());
		
        $this->addElement('radio', 'slideLinkTarget', array(
    	
    	'label'=>'Target:',
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
		$this->getElement('slideLinkTarget')->setSeparator('');
		
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
		*/
		
		$this->addElement('submit', 'btnSave', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Upload Image',
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
