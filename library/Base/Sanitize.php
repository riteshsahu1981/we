<?php
class Base_Sanitize
{
    public function sanitize($string)
    {
        $string = strtolower(preg_replace('/\s+/', '-', $string));
        $string = strtolower(preg_replace('/[:,]+/', '', $string));
        $string = str_replace("&", "and", $string);
        return $string;
    }
	
	public function clearInputs($string)
    {
        $string = trim($string);
		$string = str_replace("ç", "c", $string);
		$string = str_replace("&#231", "c", $string);
		$string = str_replace("Ã§", "c", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("\"", "", $string);
		$string = str_replace(",", "-", $string);
		$string = str_replace(":", "-", $string);
		$string = str_replace(";", "-", $string);
        //$string = str_replace("&", "and", $string);
		return $string;
    }
	
	public function reverseSanitize($string)
    {
        //$string = strtolower(preg_replace('-', ' ', $string));
		$string = str_replace("-", " ", $string);
        //$string = strtolower(preg_replace('', '/[:,]+/', $string));
        $string = str_replace("and", "&", $string);
        return $string;
    }
	
	public function blogIdentifire($string)
    {
        $string = strtolower(preg_replace('/\s+/', '-', $string));
        $string = strtolower(preg_replace('/[:,]+/', '', $string));
        $string = str_replace("&", "and", $string);
		$string = str_replace('@', "", $string);
		$string = str_replace(')', "-", $string);
		$string = str_replace('(', "-", $string);
		$string = str_replace("'", "-", $string);
		$string = str_replace('"', "-", $string);
		$string = str_replace("“", "-", $string);
		$string = str_replace("”", "-", $string);
		$string = str_replace('.', "-", $string);
		$string = str_replace(":", "-", $string);
		$string = str_replace('#', "-", $string);
		$string = str_replace('!', "-", $string);		
		$string = str_replace('?', "-", $string);
		$string = str_replace('$', "-", $string);
		$string = str_replace('%', "", $string);
		$string = str_replace('+', "-", $string);
		$string = str_replace('*', "-", $string);
		$string = str_replace('=', "-", $string);
		//$string = ereg_replace("[-]+", "-", $string);
		$string = preg_replace('/[-]+/', "-", $string); //remove more than one occurance of - character
		$string = trim($string, '-'); //remove - from last and first position of string
		//$string = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $string);
		return $string;
    }//end of function

}//end of class
?>
