<?php
class Base_View_Helper_Content extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function content($alias, $type="")
	{
		$content = "";
		if($alias!="")
		{
			$alias = trim($alias);
			$where = "alias='{$alias}' AND status=1";
			//create content class object and select body text
			$contentM	= new Application_Model_Content();
			$contentRes = $contentM->fetchRow($where);
			if($contentRes)
			{
				if($type=="title")
				{
					$content = $contentRes->getTitle();
				}
				else
				{
					$content = $contentRes->getBody();
				}	
			}
		}
		else
		{
			$content = "Alias parameter is missing..";
		}
		//echo "com=".$content;exit;
		return $content;
	}
	
	public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
	
}
