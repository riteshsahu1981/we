<?php
class Base_Http_Cookie{
	
	public function setCookie($key, $value, $expire=0,$path='/', $domain='', $secure=false, $httponly=false)
	{
		return setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);					
	}

	public function getCookie($key)
	{
		if(isset($_COOKIE[$key]))
			return $_COOKIE[$key];
		else
			return false;		
	}
	
	public function isExpired($key)
	{
		if(isset($_COOKIE[$key]) && $_COOKIE[$key]!="0")
			return false;
		else 
			return true;
	}
	
}
