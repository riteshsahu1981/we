<?php
class Application_Model_BookUser {

    protected $_id;
    protected $_bookId;
    protected $_userId;
    protected $_issueDate;
    protected $_returnDate;
    protected $_estimatedReturnDate;
    protected $_issuedByUserId;
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
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified '.$method );
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
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
            $this->setMapper(new Application_Model_BookUserMapper());
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

   public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setBookId($bookId)
    {
        $this->_bookId = (int) $bookId;
        return $this;
    }

    public function getBookId()
    {
        return $this->_bookId;
    }
    
    public function setIssueDate($issueDate)
    {
        $this->_issueDate = (string) $issueDate;
        return $this;
    }

    public function getIssueDate()
    {
        return $this->_issueDate;
    }
    
    public function setReturnDate($returnDate)
    {
        $this->_returnDate = (string) $returnDate;
        return $this;
    }

    public function getReturnDate()
    {
        return $this->_returnDate;
    }
    
    public function setEstimatedReturnDate($estimatedReturnDate)
    {
        $this->_estimatedReturnDate = (string) $estimatedReturnDate;
        return $this;
    }

    public function getEstimatedReturnDate()
    {
        return $this->_estimatedReturnDate;
    }
    public function getIssuedByUserId()
    {
        return $this->_issuedByUserId;
    }

    public function setIssuedByUserId($issuedByUserId)
    {
        $this->_issuedByUserId = (int) $issuedByUserId;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }

    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }

    public function getUpdatedon()
    {
        return $this->_updatedon;
    }

    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
        return $this;
    }

    
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	
    		
            $model = new Application_Model_BookUser();
            $model->setId($row->id)
                  	->setBookId($row->book_id)
                        ->setUserId($row->user_id)
                        ->setIssueDate($row->issue_date)
                        ->setReturnDate($row->return_date)
                        ->setEstimatedReturnDate($row->estimated_return_date)
                	->setIssuedByUserId($row->issued_by_user_id)
                        ->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                                
                	;

             return $model;
    }
    
    
    
    
    
    public function save()
    {
        $data = array(
            'book_id'   => $this->getBookId(),
            'user_id'      => $this->getUserId(),
            'issue_date'      => $this->getIssueDate(),
            'return_date'   => $this->getReturnDate(),
            'estimated_return_date' =>$this->getEstimatedReturnDate(),
            'issued_by_user_id' =>$this->getIssuedByUserId()
            );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
           return $this->getMapper()->getDbTable()->insert($data);
        } else {
            $data['updatedon']=time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
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