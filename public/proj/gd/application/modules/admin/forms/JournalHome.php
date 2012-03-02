<?php
class Admin_Form_JournalHome extends Zend_Form
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
		$this->addElement('textarea', 'logoutText1', array(
            'label'      => 'Logout Text1:',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => true,
         	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page identifire')))
   							),
        	'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('textarea', 'logoutText2', array(
            'label'      => 'Logout Text2:',
        	'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => false,         	
        	'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('textarea', 'loginText1', array(
            'label'      => 'Login Text1:',
			'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
            'required'   => true,
        	'validators' => array(
  						  		array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter the page content')))
   							),
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
        ));
        
        $this->addElement('textarea', 'loginText2', array(
            'label'      => 'Login Text2:',
            'required'   => false,
			'cols'=>'50',
        	'rows'=>'3',
			'class'		=> 'title-input-box',
        	'decorators' => $this->elementDecorators,
        	'filters'    => array('StringTrim')
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
