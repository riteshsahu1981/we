<?php
class Base_View_Helper_Language extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function language($identifire)
	{
		//language array
		$language = array("like_singular"=>"member likes this",
						"like_plural"=>"members like this",
						"like_you"=>"You like this"
					);
					
		$label_str = "";
		
		if(isset($language[$identifire]))
		{
			$label_str = $language[$identifire];
		}	
		return $label_str;
	}
	
	public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
	
}
