<?php
class Application_Model_TravelGuidesHome
{
    protected $_id;
    protected $_title;
	protected $_subTitle;
	protected $_description;
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
        if (is_array($options))
		{
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Setting invalid table property.');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Getting invalid table property'.$method);
        }
        return $this->$method();
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
            $this->setMapper(new Application_Model_TravelGuidesHomeMapper());
        }
        return $this->_mapper;
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
	    
 	public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
    public function getTitle()
    {
        return $this->_title;
    }
	
	public function setSubTitle($subTitle)
    {
        $this->_subTitle = (string) $subTitle;
        return $this;
    }
    public function getSubTitle()
    {
        return $this->_subTitle;
    }
	
	public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->_description;
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
        $this->_status= (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }    
    
	public function setUserId($userId)
    {
        $this->_userId= (int) $userId;
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
    	$model = new Application_Model_TravelGuidesHome();
        $model->setId($row->id)
              ->setTitle($row->title)
			  ->setSubTitle($row->sub_title)
              ->setDescription($row->description)
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
            'title'				=> $this->getTitle(),
			'sub_title'	  		=> $this->getSubTitle(),
  	  		'description' 		=> $this->getDescription(),
			'meta_title' 		=> $this->getMetaTitle(),
			'meta_keyword' 		=> $this->getMetaKeyword(),
			'meta_description' 	=> $this->getMetaDescription(),
  	  		'status'   			=> $this->getStatus(),		
        	'user_id' 			=> $this->getUserId(),
        );
		if (null === ($id = $this->getId()))
		{
			unset($data['id']);
			$data['addedon'] = time();
			return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
			$data['updatedon'] = time();
			return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }        
    }//end function


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
}
