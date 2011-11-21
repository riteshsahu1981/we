<?php
class Application_Form_Attendance extends Zend_Form
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
        $this->setName('frmAttendance');
	   $month['']="Month";
        for($i=1;$i<=12;$i++)
        {
            if($i<10)
                $i="0".$i;
            $month[$i] = date("M", mktime (null, null, null, $i, 1, date("Y")));
        }
	$this->addElement('select', 'month',array(
                'label'      => 'Month:',
                'id' => 'month',
                'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select month.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$month
        ));
        
        $year['']="Year";
        for($i=date("Y")-1;$i<=date("Y")+1;$i++)
            $year[$i] = $i;
        
	$this->addElement('select', 'year',array(
                'label'      => 'Year:',
                'id' => 'year',
                'style' => 'width:193px',
        	'class' =>'text-input small-input',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select year.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$year
        ));
        
         $this->addElement('file', 'attendanceSheet', array(
            'class' =>'text-input medium-input',
            'label'      => 'Attendance Sheet:',
            'required'   => true,
             
            'decorators' => $this->fileDecorators,
        ));
        $this->getElement('attendanceSheet')->addValidator('Size', false, 1024*1024*20); //2 MB file is allowed
        $this->getElement('attendanceSheet')->getValidator('Size')->setMessages(array("fileSizeTooBig"=>"Maximum allowed file size is 20 MB.","fileSizeTooSmall"=>""));
        $this->getElement('attendanceSheet')->addValidator('Extension', false, 'xls,xlsx');
        $this->getElement('attendanceSheet')->getValidator('Extension')->setMessages(array("fileExtensionFalse"=>"Please upload xls or xlsx file only.","fileExtensionNotFound"=>""));
		
	
		
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
