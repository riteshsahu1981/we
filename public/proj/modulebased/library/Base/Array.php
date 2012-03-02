<?php
class Base_Array{
	
	public function __construct()
    {
    
    }
	
	public function orderBy(&$data, $field, $order='asc') 
   	{ 
   		if($order=="desc")
   			$code = "return strnatcmp(\$b['$field'], \$a['$field']);";
		else
   			$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
   			
   			usort($data, create_function('$a,$b', $code));
   	} 
    
 
}