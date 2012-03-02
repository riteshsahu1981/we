<?php
class Application_Form_UserPrivilege extends Zend_Form
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
    public function init()
    {
        $this->setName('frmPrivilege');
        $model	=	new Application_Model_User();
        $arrUserId	=	$model->getIds();
	$this->addElement('select', 'userId',array(
            'label'      => 'User ID:',
			'id' => 'userId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user.')))
            	),
                'decorators' => $this->elementDecorators,
                'filtcoratoers'    => array('StringTrim'),
        	'MultiOptions'=>$arrUserId
        ));
       // $model	=	new Application_Model_Screen();
        //$arrScreenId	=	$model->getId();
	$this->addElement('select', 'screenId',array(
            'label'      => 'Screen ID:',
			'id' => 'screenId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select screen.')))
            	),
                'decorators' => $this->elementDecorators,
                'filtcoratoers'    => array('StringTrim'),
        	'MultiOptions'=>array("1"=>"Screen1","2"=>"Screen2")
        ));
         
         // $model	=	new Application_Model_Menu();
        //$arrMenuId	=	$model->getId();
	$this->addElement('select', 'menuId',array(
            'label'      => 'Menu ID:',
			'id' => 'menuId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select menu.')))
            	),
                'decorators' => $this->elementDecorators,
                'filtcoratoers'    => array('StringTrim'),
        	'MultiOptions'=>array("1"=>"Menu1","2"=>"Menu2")
        ));
        // $model	=	new Application_Model_Action();
        //$arrSActionId	=	$model->getId();
        $this->addElement('select', 'actionId',array(
            'label'      => 'Action ID:',
			'id' => 'actionId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select action.')))
            	),
                'decorators' => $this->elementDecorators,
                'filtcoratoers'    => array('StringTrim'),
        	'MultiOptions'=>array("1"=>"Screen1","2"=>"Screen2")
        ));
                  
	 $this->addElement('select', 'permissions',array(
            'label'      => 'Permissions:',
			'id' => 'permissions',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select permissions.')))
            	),
        	'decorators' => $this->elementDecorators,
                'filters'    => array('StringTrim'),
        	'MultiOptions'=>array("grant"=>"Grant","revoke"=>"Revoke permissions")
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

