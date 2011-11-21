<?php
class Base_View_Helper_FormatDate extends Zend_View_Helper_Abstract
{
	
	public function formatDate($timestamp=null, $full=true)
	{
            if(is_null($timestamp))
            {
                $timestamp=time();
            }
            $date=new Base_Date();
            return $date->getSysDate($timestamp, $full);
           
	}
}