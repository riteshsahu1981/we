<?php

class Base_Auth_Auth extends Zend_Auth  
{
	
	public function __construct(){
		
	}
	
	public function getAuthAdapter(array $params, $identityColumn)
    {
		$auth       = Zend_Auth::getInstance();
		$registry    = Zend_Registry::getInstance(); 
		$db = $registry['db']; 
	    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
	    $password=md5($params['password']);
		if(isset($params['md5']) && $params['md5']=="false")
			$password=$params['password'];
	    
		
	    $authAdapter	->setTableName("user") 
	        	       	->setIdentityColumn($identityColumn) 
	    	           	->setCredentialColumn("password")  
		           	  	->setIdentity($params['email'])
						->setCredential($password);
						 
    	return $authAdapter;
    }
    
    public function doLogin($options,$identityColumn="email")
    {
        
        $adapter = $this->getAuthAdapter($options, $identityColumn);
        $auth    = $this->getInstance();
        $result  = $auth->authenticate($adapter);
        if($result->isValid() && $this->checkUserActiveStatus($options, $identityColumn)) 
        {
			return true;
        }
        else
        {
        	return false;
        }
	        
    }
    
    

    
	public function checkUserActiveStatus($options,$identityColumn)
	{
		
		$usersNs = new Zend_Session_Namespace("members");
		$user= new Application_Model_User();
    	$RES=$user->fetchRow("{$identityColumn}='{$options['email']}' and status ='active'");
    	
    	if($RES!=false) // if user is not blocked
    	{
    		$usersNs->userObj=serialize($RES);
    		
    		$usersNs->userId=$RES->getId();
    		$usersNs->userEmail=$RES->getEmail();
    		$usersNs->userFullName=$RES->getFirstName()." ".$RES->getLastName();
    		$usersNs->userFirstName=$RES->getFirstName();
    		$usersNs->userUsername=$RES->getUsername();
			//$usersNs->setExpirationSeconds(15);
		//setcookie("userName", $RES->getUsername(), time()+3600);  /* expire in 1 hour */
    		
			/*--------- START CHECK USER PERSONAL IMAGE DIRECTORY -----------*/					
					//$this->createUserDrectory($usersNs->userUsername);
			/*--------- END CHECK USER PERSONAL IMAGE DIRECTORY ------------*/
    		    		
    		$user_level=new Application_Model_UserLevel();
    		$user_level_res=$user_level->find($RES->getUserLevelId());
			
    		if($user_level_res->getStatus()<>"active")
    		{
    			Zend_Session::namespaceUnset("members");
    			$auth    = $this->getInstance();
        		$auth->clearIdentity();
        		return false;
    		}
    		
    		$usersNs->userType=$user_level_res->getIdentifire();
    		$usersNs->userTypeLabel=$user_level_res->getLabel();
    		return true;
    		
    	}
    	else
    	{
    		$this->doLogout();
        	return false;			
    	}
	}
	
	public function recoverPassword(Application_Model_User $user)
	{		
		$new_password=$this->passwordGenerator();
		
		$user->setPassword(md5($new_password));
		
		$user->save();
		$options['email']=$user->getEmail();
		$options['password']=$new_password;
		$options['firstName']=$user->getFirstName();
		$options['lastName']=$user->getLastName();

		$Mail=new Base_Mail();
		$Mail->sendForgotMail($options);
		
	}
	
	public function recoverUsername(Application_Model_User $user)
	{		
		
		$options['email']=$user->getEmail();
		$options['username']=$user->getUsername();
		$options['firstName']=$user->getFirstName();
		$options['lastName']=$user->getLastName();

		$Mail=new Base_Mail();
		$Mail->sendForgotUsernameMail($options);
		
	}
	
	public function passwordGenerator()
	{
		$password=$this->makeToken(8);
		return $password; 
	}
	
	public function doLogout()
	{
 		$this->clearIdentity();
		Zend_Session::namespaceUnset("members");
                //Zend_Session::namespaceUnset("app");
	}
	
	
	public function checkUserLoginStatus()
	{
		if (Zend_Auth::getInstance()->hasIdentity())
		{
			$email=Zend_Auth::getInstance()->getIdentity();
			return $this->checkUserActiveStatus($email);
		}
		else
		{
			return false;
		}
	}	
     
	public function remeberMe($remberMe=true, $params){
		if($remberMe==true)
		{
			$expires =time()+(60*60*24*15);
			$cookie=new Base_Http_Cookie();
			$array=base64_encode(serialize(array('email'=>$params['email'],'password'=> $params['password'])));
			$cookie->setCookie('rememberMe',$array,$expires);
		}
		
	}
	
	public function forgotMe($key)
	{
		$cookie=new Base_Http_Cookie();
		if(!$cookie->isExpired($key))
		{
			$cookie->setCookie($key, '0', time()-1);
		}
	}
	
    public function makeToken( $length = 16 )
    {
      	if ($length < 8 || $length > 44) return false;
   
      	// collecting info about the length
      	$length_odd = (($length % 2) != 0);
      	$length_has_root = ( strpos( sqrt($length), '.' ) === false);
      
      	/*
       	*  Let's make an offset based on oddity
       	*    to mess things up a bit.  Feel free to go crazy here,
       	*    but for the purpose of this tutorial I'll keep it simple.
       	*/
   
      	$offset = $length_odd ? 1 : 0;
      	/*
       	*    Mapping keys to positions that they will occupy.
       	*    Since arrays are zero-based, we're subtracting 1 from each.
       	*    Also we're adding offset to each.
       	*    For convenience, let's gather our keys into string too.
       	*    We will need it for hashing.
       	*/
   
      	$key_str = '';
   		$keys=array();
      	$key_str .= $keys[ (0 + $offset)                 ] = $this->randAlphanumeric();
      	$key_str .= $keys[ (($length / 4) - 1 + $offset) ] = $this->randAlphanumeric();
      	$key_str .= $keys[ (($length / 2) - 1 + $offset) ] = $this->randAlphanumeric();
      	$key_str .= $keys[ (($length - 2) + $offset)     ] = $this->randAlphanumeric();
      
      	/*
       	*    Building the "answer" to the key string.
       	*    We'll do it by hashing the string in weird ways.
       	*    We'll choose a hashing sequence based on whether the length has root.
       	*
       	*/
   
      	$hashed_keys = $length_has_root ? sha1(md5($key_str)) : sha1(sha1($key_str));
      
     	/*
       	*    Once again, it's easy to go crazy here, but
       	*    for the purpose of this tutorial, we're going to simply
       	*    fill up all remaining positions with the hashed_keys string
       	*    as far as we have space
       	*
       	*/
   
		$hash_enum = 0;
	    for ($i = 0; $i < $length; $i++) 
		{
	      	if ( !isset($keys[$i]) ) 
	      	{
	        	$keys[$i] = $hashed_keys[$hash_enum];
	        	$hash_enum++;
			}
	    }
      
      
     	ksort($keys);
      	return implode($keys, '');
     } // and we're done
     
     
	function verifyToken ( $str ) 
	{
    	$length = strlen($str);
    	$keys = str_split($str);


    	// we're simply using the same algorithm
	    // to find key positions based on length
	    // as well as find which hashes must be used

    	$length_odd = (($length % 2) != 0);
    	$length_has_root = ( strpos( sqrt($length), '.' ) === false);

    	$offset = $length_odd ? 1 : 0;

	    // Only this time we're extracting the keys instead of
	    // generating them.  And while we're at it, let's remember the positions.

    	$key_str = '';

    	$key_str .= $keys[ $pos1 = (int)(0 + $offset)                 ];
    	$key_str .= $keys[ $pos2 = (int)(($length / 4) - 1 + $offset) ];
    	$key_str .= $keys[ $pos3 = (int)(($length / 2) - 1 + $offset) ];
    	$key_str .= $keys[ $pos4 = (int)(($length - 2) + $offset)     ];

	    $hashed_keys = $length_has_root ? sha1(md5($key_str)) : sha1(sha1($key_str));

	    $hash_string = '';

    	// we've already extracted the keys above, so here we should skip them,
	    // and instead extract everything else

    	for ($i = 0; $i < $length; $i++) 
    	{
     		if ( $i != $pos1 &&	$i != $pos2 && $i != $pos3 && $i != $pos4 ) 
        	{
      			$hash_string .= $keys[$i];
     		}
    	}

    	$hash_length = $length - 4;

	    // returning the comparison of question to the answer;
	    // if they're equal - the key is valid
    	return ( $hash_string == substr($hashed_keys, 0, $hash_length) );
   }
   
 	public function randAlphanumeric() 
 	{
	      $subsets[0] = array('min' => 48, 'max' => 57); // ascii digits
	      $subsets[1] = array('min' => 65, 'max' => 90); // ascii lowercase English letters
	      $subsets[2] = array('min' => 97, 'max' => 122); // ascii uppercase English letters
	   
	      // random choice between lowercase, uppercase, and digits
	      $s = rand(0, 2);
	      $ascii_code = rand($subsets[$s]['min'], $subsets[$s]['max']);
	   
	      return chr( $ascii_code );
    }
	
	public function createUserDrectory($uname)
	{				   
		 $uploaddir1 = PUBLIC_PATH."/images/userfiles/".$uname;			 
	   
			if(is_dir($uploaddir1))			   
			{			   
				 return true;
			}else{			  
				mkdir($uploaddir1, 0777);
				
				return true;
			}
					
	}
}