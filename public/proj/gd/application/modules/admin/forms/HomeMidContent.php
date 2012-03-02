<?php
class Admin_Form_HomeMidContent extends Zend_Form
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
		
		$this->addElement('file', 'editorPic', array(
            'label'      => 'Editor Picture:',
            'required'   => false,
			'class'		=> 'subtitle-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload the image.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));
		$this->getElement('editorPic')->addValidator('Size', false, 1024*1024*2); //2 MB file is allowed
		$this->getElement('editorPic')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 2 MB.","fileSizeTooSmall"=>""));
		$this->getElement('editorPic')->addValidator('Extension', false, 'jpg,jpeg,png,gif');
		$this->getElement('editorPic')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload jpg,jpeg,png,gif file.","fileExtensionNotFound"=>""));
        
		$this->addElement('text', 'editorPicTitle', array(
            'label'      => 'Editor Title:',
            'required'   => true,
			'maxlength'	=>100,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the editor title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->addElement('textarea', 'editorPicText', array(
            'label'		=> 'Editor Text:',
			'cols'		=> '80',
			'rows'		=> '1',
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		
		$this->addElement('text', 'editorPicUrlLabel', array(
            'label'      => 'Editor Link Text:',
			'maxlength' =>100,
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the editor link text.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
        $this->addElement('text', 'editorPicUrlLink', array(
            'label'      => 'Editor Link URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the editor link url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('editorPicUrlLink')->addValidator('url', true, array());
		
		/*
        $this->addElement('radio', 'editorPicUrlTarget', array(
    	'label'=>'Editor Link URL Target:',
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
  		));*/
		
		$this->addElement('select', 'editorPicUrlTarget',array(
            'label'      => 'Editor Link URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		
		
		$this->addElement('text', 'title', array(
            'label'      => 'Title:',
			'maxlength'	=>250,
			'style'=>'width:400px;',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the title.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));

         $this->addElement('text', 'subTitle1', array(
            'label'      => 'Sub Title1:',
			'maxlength'	=>100,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the sub title1.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 /*************  Set 5 URL Text and Tragets for First tab START *********************************/
		 $this->addElement('text', 'sharedLink1Text', array(
            'label'      => 'Shared 1 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Shared 1 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 $this->addElement('text', 'sharedLink1Url', array(
            'label'      => 'Shared 1 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the shared 1 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('sharedLink1Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'sharedLink1Target',array(
            'label'      => 'Shared 1 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'sharedLink2Text', array(
            'label'      => 'Shared 2 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Shared 2 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'sharedLink2Url', array(
            'label'      => 'Shared 2 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the shared 2 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('sharedLink2Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'sharedLink2Target',array(
            'label'      => 'Shared 2 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'sharedLink3Text', array(
            'label'      => 'Shared 3 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Shared 3 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'sharedLink3Url', array(
            'label'      => 'Shared 3 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the shared 3 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('sharedLink3Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'sharedLink3Target',array(
            'label'      => 'Shared 3 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'sharedLink4Text', array(
            'label'      => 'Shared 4 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Shared 4 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'sharedLink4Url', array(
            'label'      => 'Shared 4 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the shared 4 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('sharedLink4Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'sharedLink4Target',array(
            'label'      => 'Shared 4 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		$this->addElement('text', 'sharedLink5Text', array(
            'label'      => 'Shared 5 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Shared 5 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'sharedLink5Url', array(
            'label'      => 'Shared 5 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the shared 5 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('sharedLink5Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'sharedLink5Target',array(
            'label'      => 'Shared 5 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		/*************  Set 5 URL Text and Tragets for First tab END *********************************/
	 
		 /*$this->addElement('textarea', 'subTitle1Text', array(
            'label'		=> 'Sub Title1 Text:',
			'cols'		=> '80',
			'rows'		=> '5',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the sub title1 text.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));*/
		 
		 $this->addElement('text', 'subTitle2', array(
            'label'      => 'Sub Title2:',
			'maxlength'	=>100,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the sub title2.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		/*************  Set 5 URL Text and Tragets for Second tab START *********************************/
		 $this->addElement('text', 'readLink1Text', array(
            'label'      => 'Read 1 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 1 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 $this->addElement('text', 'readLink1Url', array(
            'label'      => 'Read 1 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 1 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('readLink1Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'readLink1Target',array(
            'label'      => 'Read 1 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'readLink2Text', array(
            'label'      => 'Read 2 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 2 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'readLink2Url', array(
            'label'      => 'Read 2 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 2 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('readLink2Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'readLink2Target',array(
            'label'      => 'Read 2 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'readLink3Text', array(
            'label'      => 'Read 3 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 3 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'readLink3Url', array(
            'label'      => 'Read 3 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 3 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('readLink3Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'readLink3Target',array(
            'label'      => 'Read 3 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		 $this->addElement('text', 'readLink4Text', array(
            'label'      => 'Read 4 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 4 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'readLink4Url', array(
            'label'      => 'Read 4 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 4 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('readLink4Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'readLink4Target',array(
            'label'      => 'Read 4 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		 
		$this->addElement('text', 'readLink5Text', array(
            'label'      => 'Read 5 Text:',
			'maxlength'	=>250,
			'class'		=> 'subtitle-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 5 Text.')))
   							),
        	'decorators' => $this->elementDecorators,
         ));
		 
		 $this->addElement('text', 'readLink5Url', array(
            'label'      => 'Read 5 URL:',
			'class'		=> 'title-input-box',
			'maxlength' =>250,
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the Read 5 url.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		$this->getElement('readLink5Url')->addValidator('url', true, array());
		
		$this->addElement('select', 'readLink5Target',array(
            'label'      => 'Read 5 URL Target:',
        	'style'=>'width: 200px;',
        	'required'   => true,
			'value'	=>	'_self',
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must select the link target.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$linkUrltargetArr         	
        ));
		/*************  Set 5 URL Text and Tragets for Second tab END *********************************/
		
		/*$this->addElement('textarea', 'subTitle2Text', array(
            'label'		=> 'Sub Title2 Text:',
			'cols'		=> '80',
			'rows'		=> '5',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the sub title2 text.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));*/
        
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
