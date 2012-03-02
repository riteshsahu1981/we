<?php

class Base_Form_Element_File extends Base_Form_Element_Uploadify
{
    public function setup($arg = null)
    {
        $elementID = $this->getId();
        
        $options = array('uploader'     => '/uploadify/uploadify.swf',
            			 'cancelImg'    => '/uploadify/cancel.png',
        				 'buttonText'  => 'BROWSE',
        				 //'removeCompleted' => false,
        				 'fileDesc'    => 'Web Image Files (.JPG, .GIF, .PNG)',
        				 'displayData' => 'percentage', // 'speed'
        				 'expressInstall' => '/uploadify/expressInstall.swf', // The path to the expressInstall.swf file.
        				 'multi'       => true,
                         'onComplete'   => 'function(event, ID, fileObj, response, data) { captureData(event, ID, fileObj, response, data) }',
        				 'myShowUpload' => false
                   );
       if($arg == 'popup'){
       	$script	= "";
       	$script	= "<link href='/uploadify/uploadify.css' type='text/css' rel='stylesheet' />";
		$script	.= "<script type='text/javascript' src='/uploadify/swfobject.js'></script>";
		$script	.= "<script type='text/javascript' src='/uploadify/jquery.uploadify.v2.1.4.min.js'></script>";
		$script	.= "<script type='text/javascript'>".$this->getJavaScript($options)."</script>";
		print $script;
       }else{
        $this->getView()->headLink()->appendStylesheet('/uploadify/uploadify.css', 'screen');
        $this->getView()->headScript()->appendFile('/uploadify/jquery.uploadify.v2.1.4.min.js')
                                      ->appendFile('/uploadify/swfobject.js')
                                      ->appendScript($this->getJavaScript($options));
       }
       //$this->addFilter('rename', $this->getRandomFileName());
    }
}