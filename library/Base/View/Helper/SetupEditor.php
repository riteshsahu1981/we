<?php
class Zend_View_Helper_SetupEditor {

    function setupEditor( $textareaId, $customConfig=NULL ) 
	{
      
			if(!empty($customConfig))
			{
				return "<script type=\"text/javascript\">    
			CKEDITOR.replace( '". $textareaId ."',
			{
				customConfig : '{$customConfig}',
				filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
				filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
				filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			});
				</script>";
		}else{
			return "<script type=\"text/javascript\">    
			CKEDITOR.replace( '". $textareaId ."',
			{
				filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
				filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
				filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			});
				</script>";
		}
    
    //CKEDITOR.replace( '". $textareaId ."' );
	}
}
?>
