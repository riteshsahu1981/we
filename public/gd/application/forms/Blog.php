<?php

class Application_Form_Blog extends Zend_Form
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
	
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
		 $this->addElementPrefixPath('Base_Validate', 'Base/Validate/', 'validate');
      
        $arrWeight = array();
		$arrWeight[0] = "--Select--";
		for($i=1;$i<=50;$i++)
		{
		    $arrWeight[$i] = $i;	
		}	 
        // Add an email element
        $this->addElement('text', 'title', array(
            'label'      => 'Enter title',
            'required'   => true,
        	'class'=>"form",
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Post title can not be left blank.'))),
        	array('Alphachar', true, array('messages'=>array('alnumStringNotValid'=>'Please remove special characters.')))
        		
            )
        ));
		
        //default selected Status option as per permission settings		
		$userNs	=	new Zend_Session_Namespace('members');
		$userId	=	$userNs->userId;
		$where	=	"user_id='{$userId}' AND permission_id=4";
		
		$user_permission	=	new Application_Model_UserPermission();
		$user_permission	=	$user_permission->fetchRow($where);
		$savedUserPermission = $user_permission->getFriendGroupId();
		$selectedPermission = "public";
		if($savedUserPermission==4)
		{
			$selectedPermission = "private";
		}
		
		
        $arrStatus = Array("public"=>"Public", "private"=>"Just Me");
		
		//get user permission and create new dropdwon, added by Mahipal Adhikari on 28-Mar-2011
		$group		= new Application_Model_FriendGroup();
		$arrStatus	= $group->getFriendGroup('--select--',null);
		$selectedPermission = $savedUserPermission;
		
    	$this->addElement('select', 'status',array(
            'label'      => 'Permissions',
        	'class' =>'form',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select journal post permission.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
			'value'=> $selectedPermission,
        	'MultiOptions'=>$arrStatus
        ));
        
        
        //$arrStatus=Array("Public"=>"Public(Default)", "friends"=>"Friends and Family","travel"=>"Travel Mates","family"=>"Friends Family And Mates");
        
        $category=new Application_Model_Category();
        $arrCategory=$category->getCategory("-- Select Category --","blog");
        
    	$this->addElement('select', 'categoryId',array(
            'label'      => 'Choose post category',
        	'class' =>'form',
        	'required'   => true,
        	'validators' => array(
                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the category.')))
            	),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrCategory
        ));
        
         $this->addElement('text', 'location', array(
            'label'      => 'Enter destination',
			'class'=>"form",
            'required'   => true,
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
        	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Destination can not be left blank.')))
        		
            )
        ));
        
        $this->addElement('textarea', 'tags', array(
            'label'      => 'Tag your post',
            'required'   => false,
			'class' => 'blog_tag_textarea',
            'rows'=>'4',
            'cols'=>'40',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim')
         
        ));
        
        
         $this->addElement('textarea', 'content', array(
            'label'      => 'Edit your post',
            'required'   => true,
            'rows'=>'8',
            'cols'=>'80',
            'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('NotEmpty',true, array("messages"=>array('isEmpty'=>'Journal entry can not be left blank.')))
                )
        ));
        
         $this->addElement('radio', 'comment', array(    	
			'label'=>'Enable Comments ',
			'required'   => true,
			'validators' => array(
									array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please enable comment.')))
								),
			'multiOptions'=>array(
			'yes'=>"Yes",
			'no'=>"No",
			),
      	'separator'=>"  ",
      	'decorators' => $this->elementDecorators,
      	'value'=>'yes'
  		));
        
        
  
  		$this->addElement('radio', 'publish', array(
    	'label'=>'Publish Settings',
        'required'   => true,
        'multiOptions'=>array(
        'published'=>"Publish Live",
        'draft'=>"Save for Later",
      	),
      	'value'=>'published',
      	'separator'=>"  ",
      	'decorators' => $this->elementDecorators,
  		));
    
  		$this->addElement('select', 'weight',array(
            'label'      => 'Weight',
        	'class' 	 =>'form',
         	'required'   => true,
        	'validators' => array(
									array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select the status')))
							     ),
        	'decorators' => $this->elementDecorators,
            'filters'    => array('StringTrim'),
        	'MultiOptions'=>$arrWeight,
        ));
  		

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            /*'label'    => 'Submit post to my journal.',*/
			'label'    => 'Create Post',
        	'decorators'=>$this->buttonDecorators
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
