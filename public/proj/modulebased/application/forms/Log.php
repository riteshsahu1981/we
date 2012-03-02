<?php
class Application_Form_Log extends Zend_Form
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
        $this->setName('frmConfiguration');
        $model	=	new Application_Model_Log();
        $arrlogs1=array(0 => 'Select Parent Config id');
        $arrLogs=$model->getLogs();
        $result=array_merge($arrlogs1,$arrLogs);
     
	$this->addElement('select', 'parentConfigId',array(
            'label'      => 'Parent Config Id:',
			'id' => 'parentConfigId',
			'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select user group.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            	'MultiOptions'=>$result
        ));
	   
	   $this->addElement('text', 'configName', array(
            'label'      => 'Config Name:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',

            'required'   => true,
            'validators' => array(
            array('NotEmpty', true, array('messages'=>array('isEmpty'=>'You must enter Configuration Name'))),
           /* array('Db_NoRecordExists', true, array(
            'table' => 'config',
            'field' => 'config_name',
            'messages'=>'Config Name already exists'
            ))*/
            ),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
            $this->addElement('textarea', 'configDesc', array(
            'rowss'=>'10',
            'label'      => 'Config Desc:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
                'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please Enter Config Description.')))
            	),
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
             $this->addElement('text', 'param1', array(
            'label'      => 'Param1:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
              $this->addElement('text', 'param2', array(
            'label'      => 'Param2:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
               $this->addElement('text', 'param3', array(
            'label'      => 'Param3:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
                $this->addElement('text', 'param4', array(
            'label'      => 'Param4:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
        ));
            $this->addElement('text', 'param5', array(
            'label'      => 'Param5:',
            'autocomplete'=>"off",
            'class' =>'text-input medium-input',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
               
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
