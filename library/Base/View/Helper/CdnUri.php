<?php
class Base_View_Helper_CdnUri extends Zend_View_Helper_Abstract
{
	
	public function cdnUri($uri='')
	{
		if($uri=="")
		{
			$uri=Zend_Registry::get('cdn_uri');
		}
		return $uri;
	}
}