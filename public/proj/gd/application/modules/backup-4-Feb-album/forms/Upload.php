<?php

class Album_Form_Upload extends Zend_Form
{
    // DIRECOTRY HAVE TO BE WRITABLE
    const DIR_TMP = '/images/album/default/';
    const MAX_FILE_SIZE = 10485760;
    
    public function init() {
        //echo PUBLIC_PATH . self::DIR_TMP;
        $this->setMethod('post');
        $this->setAction('');
        $this->setEnctype('multipart/form-data');
        $this->setAttrib('accept-charset', 'UTF-8');
        
        //$file = new Zend_Form_Element_File('file');
        $file = new Base_Form_Element_File('file');
        $file->setOptions(array(
            'required' => true, 
            'label' => 'Add Photos to album'
        ))
        ->setDestination(realpath(PUBLIC_PATH . self::DIR_TMP))
        ->addValidators(array(array('Count', true, 1), 
                        array('Size', true, self::MAX_FILE_SIZE),
                        array( 'Extension', true, array( 'jpg','jpeg','gif','png' ))
            
        ))->addPrefixPath('Base_Form_Decorator', 'Base/Form/Decorator/', 'decorator')->setDecorators(array(
            'File', 
            'Description', 
            'Label', 
            array('Uploadify', array('text' => 'Upload')), 
            array('Errors', array('placement' => 'prepend'))
        ))->create('popup');
        $this->addElement($file);
    }
}