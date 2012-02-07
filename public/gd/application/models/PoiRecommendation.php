<?php
class Application_Model_PoiRecommendation{
    protected $_id;
    protected $_name;
    protected $_email;
    protected $_recommendation;
	protected $_countryId;
	protected $_userId;
    protected $_created;
	protected $_modified;
    protected $_mapper;
    protected $_status;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified 1'.$method);
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified 2'.$method);
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
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
        if (null === $this->_mapper) {
            $this->setMapper(new Application_Model_PoiRecommendationMapper());
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

	public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
	public function getName()
    {
        return $this->_name;
    }
	
	public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
	public function getEmail()
    {
        return $this->_email;
    }

    public function setRecommendation($recommendation)
    {
        $this->_recommendation = (string) $recommendation;
        return $this;
    }
    public function getRecommendation()
    {
        return $this->_recommendation;
    }
	
	public function setCountryId($countryId)
    {
        $this->_countryId = (int) $countryId;
        return $this;
    }
    public function getCountryId()
    {
        return $this->_countryId;
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
	
	public function getModified()
    {
        return $this->_modified;
    }
    public function setModified($modified)
    {
        $this->_modified = (int) $modified;
        return $this;
    }
    
    public function getCreated()
    {
        return $this->_created;
    }
    public function setCreated($created)
    {
        $this->_created = (int) $created;
        return $this;
    }
	
	public function setStatus($status)
    {
        $this->_status = (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }
   
	/*----Data Manupulation functions ----*/
    
    private function setModel($row)
    {
		$model = new Application_Model_PoiRecommendation();
		$model->setId($row->id)
				->setName($row->name)
				->setEmail($row->email)                                        
				->setRecommendation($row->recommendation)
				->setCountryId($row->country_id)
				->setUserId($row->user_id)
				->setCreated($row->created)
				->setModified($row->modified)
				->setStatus($row->status);
		 return $model;
    }
    
    public function save()
    {
     	$data = array(
            'name'   =>$this->getName(),
     		'email'	=>$this->getEmail(),
            'recommendation'=>$this->getRecommendation(),
     		'country_id'=>$this->getCountryId(),
     		'user_id' =>$this->getUserId(),
			'status' => $this->getStatus()
        );


        if (null === ($id = $this->getId()))
		{
            unset($data['id']);
            $data['created']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
            $data['modified']=time();
			$this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
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
    
    public function fetchRow($where = null, $order = null)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where, $order);

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
