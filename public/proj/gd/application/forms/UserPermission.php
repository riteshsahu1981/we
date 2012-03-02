<?php

class Application_Form_UserPermission extends Zend_Form
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
        $this->setMethod('post');        
     	$userNs		=	new Zend_Session_Namespace('members');
		$userId		=	$userNs->userId;
		$where		=	"user_id='{$userId}' AND permission_id NOT IN(1)";
		
		$user_permission	=	new Application_Model_UserPermission();
		$user_permission	=	$user_permission->fetchAll($where);
		
        if(count($user_permission)>0){
	         
	        $group				= new Application_Model_FriendGroup();
			$friendGroupArray	= $group->getFriendGroup('--select--',null);
			
			//create permission array for Travel Wall Journals permission
			//$friendGroupJournalArray = array (""=>"--select--", "5"=>"Public", "4"=>"Just Me (private, hidden from everyone)");
			
			foreach($user_permission as $_permission)
			{
		        /*if($_permission->getPermissionId()==4)
				{
					$friendGroupArray = $friendGroupJournalArray;
				}
				else
				{
					$friendGroupArray = $friendGroupNewArray;
				}*/	
				$this->addElement('select', "friend_group_id_".$_permission->getPermissionId(),array(
		            'label'      => $_permission->getPermissionName()." : ",
		        	'class' =>'form',
		        	'TABINDEX'=>'6',
		            
		         	'required'   => true,
		        	'validators' => array(
		                	array('NotEmpty', true, array('messages'=>array('isEmpty'=>'Please select group')))
		            	),
		        	'decorators' => $this->elementDecorators,
		            'filters'    => array('StringTrim'),
		        	'MultiOptions'=>$friendGroupArray,
		        	'value'=>$_permission->getFriendGroupId()
		        ));
			}
	     
	        
	      $this->addElement('submit', 'submit', array(
	            'required' => false,
	      		'class' =>'signup',
	      
		      	'TABINDEX'=>'20',
	            'ignore'   => true,
	            'label'    => 'Save',
	        'decorators' => $this->buttonDecorators,
	        ));
        }
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
