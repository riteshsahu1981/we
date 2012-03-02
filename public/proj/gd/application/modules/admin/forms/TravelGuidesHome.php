<?php
class Admin_Form_TravelGuidesHome extends Zend_Form
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
		
		$this->addElement('text', 'title', array(
            'label'		=> 'Title: ',
            'required'	=> true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators'=> array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('text', 'subTitle', array(
            'label'      => 'Sub Title: ',
            'required'   => true,
			'maxlength'	=> '250',
			'class'		=> 'title-input-box',
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the sub title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
		
		/*$this->addElement('file', 'backgroundImage', array(
            'label'      => 'Background Image:',
            'required'   => false,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please upload background image.')))
								,array('Size',false,1024, array('messages'=>array('size'=>'Size can not be greater than 100KB.')))
   							),
        	'decorators' => $this->fileDecorators,
        ));*/
		
		$this->addElement('textarea', 'description', array(
            'label'		=> 'Description: ',
			'cols'		=> '80',
			'rows'		=> '5',
			'required'   => true,
			'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the description.')))
   							),
        	'decorators'=> $this->elementDecorators,
        	'filters'   => array('StringTrim')
        ));
		 $this->addElement('textarea', 'metaTitle', array(
            'label'      => 'Meta Title :',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the meta title.')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaKeyword', array(
            'label'      => 'Meta Keyword :',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the meta keyword.')))
   							),        	
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'metaDescription', array(
            'label'      => 'Meta Description :',
			'class'		=> 'title-input-box',
        	'cols'=>'50',
        	'rows'=>'3',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the meta description.')))
   							),        	
        	'decorators' => $this->elementDecorators,
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
