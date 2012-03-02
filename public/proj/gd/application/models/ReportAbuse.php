<?php
class Application_Model_ReportAbuse
{
    protected $_id;
    protected $_itemId;
    protected $_itemType;
	protected $_userId;
	protected $_comment;
	protected $_status;    
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
            throw new Exception('Invalid Report Abuse property');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Report Abuse property');
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
            $this->setMapper(new Application_Model_ReportAbuseMapper());
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
	
	public function setItemId($itemId)
    {
        $this->_itemId = (int) $itemId;
        return $this;
    }
    public function getItemId()
    {
        return $this->_itemId;
    }
    
	public function setItemType($itemType)
    {
        $this->_itemType = (string) $itemType;
        return $this;
    }
    public function getItemType()
    {
        return $this->_itemType;
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
	
    public function setStatus($status)
    {
        $this->_status= (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }    
    
	public function setComment($comment)
    {
        $this->_comment = (string) $comment;
        return $this;
    }
    public function getComment()
    {
        return $this->_comment;
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
    
	//Data Manupulation functions
	
    private function setModel($row)
    {
    	$model = new Application_Model_ReportAbuse();
        $model->setId($row->id)
              ->setItemId($row->item_id)
			  ->setItemType($row->item_type)
              ->setUserId($row->user_id)
			  ->setComment($row->comment)
              ->setStatus($row->status)              
			  ->setAddedon($row->addedon)              
              ->setUpdatedon($row->updatedon)              
              ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
            'item_id'	=> $this->getItemId(),
			'item_type'	=> $this->getItemType(),
			'user_id' 	=> $this->getUserId(),
  	  		'comment' 	=> $this->getComment(),
  	  		'status'   	=> $this->getStatus()        	
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

