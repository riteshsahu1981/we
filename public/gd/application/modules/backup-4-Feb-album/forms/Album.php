<?php

class Album_Form_Album extends Zend_Form
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

       	$Name		=	new Zend_Form_Element_Text('name');      
        $Name		->	setLabel('Name of Album') 
        			->	setAttrib('class', 'form')
        			->	setAttrib('id', 'name_of_album')
        			-> 	setValue('Title of Album')
        			->	setRequired(true)
        			-> 	clearDecorators()
              		->	addDecorators($this->elementDecorators);
              		
        $Description	=	new Zend_Form_Element_Textarea('description');      
        $Description	->	setLabel('Description')
        				->	setAttrib('rows', 5)
        				->	setAttrib('cols', 33)
        				->	addFilter('StripTags')
        				->	addFilter('StringTrim')
        				->	setRequired(true)
        				-> 	clearDecorators()
              			->	addDecorators($this->elementDecorators); 

        $Location		=	new Zend_Form_Element_Text('address');      
        $Location		->	setLabel('Album Location') 
        				->	setAttrib('id','address')
        				->	setAttrib('class', 'form')
        				->	setRequired(true)
        				-> 	clearDecorators()
              			->	addDecorators($this->elementDecorators);
              			
        $LatLng		=	new Zend_Form_Element_Hidden('latlang');      
        $LatLng		->	setLabel('') 
        				->	setAttrib('id','latlang')
        				->	setAttrib('class', 'form')
        				-> 	clearDecorators()
              			->	addDecorators($this->elementDecorators);

          
        $objModelFriendGroup	=	new Application_Model_FriendGroup();
        $arrFriendGroup			=	$objModelFriendGroup->getPermissions();    			
              			
        $Permissions	=	new	Zend_Form_Element_Select('permissions');
    	$Permissions	->setAttrib('id','permissions')
    					->setAttrib('class','input')
    					->setRequired(true)
						->addMultiOptions($arrFriendGroup)
						->clearDecorators()
              			->addDecorators($this->elementDecorators)
              		;
              		
        $Tags	=	new Zend_Form_Element_Textarea('tags');      
        $Tags	->	setLabel('Album Tags')
        				->	setAttrib('rows', 5)
        				->	setAttrib('cols', 33)
        				->	setAttrib('class', 'form')
        				->	setAttrib('id', 'album_tags')
        				-> 	setValue("Seperate Tags by a comma. For example:Holiday,London,Travel")        				
        				->	addFilter('StripTags')
        				->	addFilter('StringTrim')
        				-> 	clearDecorators()
              			->	addDecorators($this->elementDecorators);

        $Upload		=	new Zend_Form_Element_Button('upload');
        $Upload		->	setAttrib('id', 'upload')        
        			->	setAttrib('class', 'button')
        			->	setLabel('UPLOAD PHOTOS')
        			-> 	clearDecorators()
        			->	addDecorators($this->buttonDecorators)
        			;  

        $Save		=	new Zend_Form_Element_Submit('save');
        $Save		->	setAttrib('id', 'save')        
        			->	setAttrib('class', 'button')
        			->	setLabel('CREATE & SAVE ALBUM')
        			-> 	clearDecorators()
        			->	addDecorators($this->buttonDecorators)
        			;  

        $this->addElements(array($Name, $Description, $Location, $LatLng, $Permissions, $Tags, $Upload, $Save)); 

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