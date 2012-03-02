<?php
class Application_Model_JournalHome
{
    protected $_id;
    protected $_loginText1;
    protected $_loginText2;
	protected $_logoutText1;
	protected $_logoutText2;
	protected $_metaTitle;
    protected $_metaKeyword;
	protected $_metaDescription;
	protected $_status;    
    protected $_userId;
    protected $_addedon;
    protected $_updatedon;
    protected $_mapper;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Table Model property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Table Model property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value)
		{
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods))
			{
                $this->$method($value);
            }
        }
        return $this;
    }
	
 	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }    
    public function getMapper()
    {
        if (null === $this->_mapper)
		{
            $this->setMapper(new Application_Model_JournalHomeMapper());
        }
        return $this->_mapper;
    }
	
 	public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    
	public function setLoginText1($loginText1)
    {
        $this->_loginText1 = (string) $loginText1;
        return $this;
    }
    public function getLoginText1()
    {
        return $this->_loginText1;
    }
	
	public function setLoginText2($loginText2)
    {
        $this->_loginText2 = (string) $loginText2;
        return $this;
    }
    public function getLoginText2()
    {
        return $this->_loginText2;
    }
	
	public function setLogoutText1($logoutText1)
    {
        $this->_logoutText1 = (string) $logoutText1;
        return $this;
    }
    public function getLogoutText1()
    {
        return $this->_logoutText1;
    }
	
	public function setLogoutText2($logoutText2)
    {
        $this->_logoutText2 = (string) $logoutText2;
        return $this;
    }
    public function getLogoutText2()
    {
        return $this->_logoutText2;
    }
    
	public function setMetaTitle($metaTitle)
    {
        $this->_metaTitle = (string) $metaTitle;
        return $this;
    }
    public function getMetaTitle()
    {
        return $this->_metaTitle;
    }
    
	public function setMetaKeyword($metaKeyword)
    {
        $this->_metaKeyword= (string) $metaKeyword;
        return $this;
    }
    public function getMetaKeyword()
    {
        return $this->_metaKeyword;
    }
	
	public function setMetaDescription($metaDescription)
    {
        $this->_metaDescription = (string) $metaDescription;
        return $this;
    }
    public function getMetaDescription()
    {
        return $this->_metaDescription;
    }
	
	public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }
  
	public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }
    public function getUserId()
    {
        return $this->_userId;
    }
    
	public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }
	
	public function setUpdatedon($updatedon)
    {
        $this->_updatedon = (int) $updatedon;
        return $this;
    }
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
    /*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
    	$model=new Application_Model_JournalHome();
        $model->setId($row->id)
                  ->setLoginText1($row->login_text1)
				  ->setLoginText2($row->login_text2)
				  ->setLogoutText1($row->logout_text1)
				  ->setLogoutText2($row->logout_text2)
				  ->setMetaTitle($row->meta_title)
			      ->setMetaKeyword($row->meta_keyword)
				  ->setMetaDescription($row->meta_description)
                  ->setStatus($row->status)
                  ->setUserId($row->user_id)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ;
		return $model;
    }
    
    public function save()
    {
      	$data = array(
            'login_text1'	=> $this->getLoginText1(),
			'login_text2'	=> $this->getLoginText2(),
			'logout_text1'	=> $this->getLogoutText1(),
			'logout_text2'	=> $this->getLogoutText2(),
			'meta_title' 		=> $this->getMetaTitle(),
			'meta_keyword' 		=> $this->getMetaKeyword(),
			'meta_description' 	=> $this->getMetaDescription(),
  	  		'status'		=> $this->getStatus(),
  	  		'user_id'		=> $this->getUserId()  	  		
        );
		if (null === ($id = $this->getId()))
		{
            unset($data['id']);
            $data['addedon']	=	time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
        	$data['updatedon']	=	time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result))
		{
            return false;
        }
        
        $row = $result->current();
        $res=$this->setModel($row);
        return $res;
    }

    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
    	$resultSet = $this->getMapper()->getDbTable()->fetchAll($where, $order , $count , $offset);
        $entries   = array();
        foreach ($resultSet as $row) 
        {
            $res=$this->setModel($row);
            $entries[] = $res;
        }
        return $entries;        
    }
    
    public function fetchRow($where)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);
       	if(!empty($row))
       	{
 			$res=$this->setModel($row);
 			return $res;
       	}
       	else 
       	{
       		return false;
       	}
    }
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }  
    /*----Data Manupulation functions ----*/

}

