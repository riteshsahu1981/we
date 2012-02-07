<?php
class Admin_Form_Content extends Zend_Form
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
		
		$linkUrltargetArr = array("_blank"	=> "New Window (_blank)",
								  "_top"	=> "Topmost Window (_top)",
								  "_self"	=> "Same Window (_self)",
								  "_parent"	=> "Parent Window (_parent)"
								  );
		
		$this->addElement('file', 'weekPhoto', array(
            'label'      => 'Photo of The Week:',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload image.')))
								,array('Size',false,1024, array('messages'=>array('size'=>'Size can not be greater than 100KB.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('weekPhoto')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('weekPhoto')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('weekPhoto')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('weekPhoto')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
		
		$this->addElement('text', 'title', array(
            'label'      => 'Content Title: ',
            'required'   => true,
			'maxlength' =>100,
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the content title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));

        $this->addElement('text', 'alias', array(
            'label'      => 'Alias: ',
            'required'   => true,
			'maxlength' =>100,
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the alias.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
        $this->addElement('textarea', 'body', array(
            'label'      => 'Description: ',
         	'rows'=>'5',
         	'cols'=>'60',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the body text.')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
		
		//create new element as per module structure
		 $this->addElement('text', 'whereText', array(
            'label'      => 'Where I Am Text:',
			'maxlength'	=>250,
			'style'=>'width:400px;',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 $this->addElement('text', 'whereUrl', array(
            'label'      => 'Where I Am Link:',
			'style'=>'width:400px;',
			'maxlength' =>300,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('whereUrl')->addValidator('url', true, array());
		
		$this->addElement('select', 'whereUrlTarget',array(
            'label'      => 'Where I Am Link Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		
		$this->addElement('text', 'whereBodyText', array(
            'label'      => 'Body Text:',
			'maxlength'	=>250,
			'style'=>'width:400px;',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 $this->addElement('text', 'whereBodyUrl', array(
            'label'      => 'Body Text Link:',
			'style'=>'width:400px;',
			'maxlength' =>300,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('whereBodyUrl')->addValidator('url', true, array());
		
		$this->addElement('select', 'whereBodyUrlTarget',array(
            'label'      => 'Body Text Link Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
        
        $this->addElement('radio', 'status', array(
			'label'=>'Staus: ',
			'required'   => true,
			'value'=>'1',
			'validators' => array(
									array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the status.')))
								),
			'multiOptions'=>array(
			'1'=>"Publish",
			'0'=>"Unpublish",
			),
			'decorators' => $this->elementDecorators,
  		));        
  		$this->getElement('status')->setSeparator('');
		
  		/*
		$this->addElement('text', 'weight', array(
            'label'      => 'Weight: ',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the weight.')))
   							),
   			'value'=>'0',
        	'decorators' => $this->elementDecorators,
        ));*/
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
