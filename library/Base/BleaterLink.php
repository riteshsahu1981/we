<?php
class Base_BleaterLink
{
	function FollowUnfollowButton($spanId, $loggedInUserId="", $loggedInBleaterId="", $BleatBleaterId="", $Relation )
	{
		
	$siteurl = Zend_Registry::get('siteurl');	
	$string = "";
		
	$string .= "<span class='{$spanId}'>";
   if($loggedInUserId == ""){
   	$url	=	$siteurl."/user/index/login";
	//$string .= "<a href=".Zend_View::url ( array ('controller' => 'index', 'action' => 'login', 'module'=>'user' ),'default', true )." class='follow'>Follow</a>";
	$string	.=	"<a href=".$url." class='follow'>Follow</a>";	
	}else{
		 if($loggedInBleaterId == ""){
		 	$url	=	$siteurl."/user/profile/bleater";	
			//$string .= "<a href=".Zend_View::url ( array ('controller' => 'profile', 'action' => 'bleater', 'module'=>'user' ),'default', true )." class='follow'>Follow</a>";
			$string .=	"<a href=".$url." class='follow'>Follow</a>";
		 }else{
			if($loggedInBleaterId != $BleatBleaterId){
				if($Relation	==	0){					
					$onclick = "return followBleater({$loggedInBleaterId},{$BleatBleaterId},'{$spanId}', '{$siteurl}/bleater/bleat/followbleater')";
					$string .= 	"<a href='javascript:void(0);' onclick=\"{$onclick}\" class='follow' >Follow</a>";
				}else{
					$Relation	=	0;
					$onclick = "return unFollowBleater({$loggedInBleaterId},{$BleatBleaterId},'{$spanId}', '{$siteurl}/bleater/bleat/unfollowbleater')";
					$string .= 	"<a href='javascript:void(0);' onclick=\"{$onclick}\" class='unfollow' >UnFollow</a>";
				}
			}
	 	}
	 }	
	$string .= "</span>";

	return $string;
	
	}
}