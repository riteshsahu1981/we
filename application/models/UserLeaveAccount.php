<?php
class Application_Model_UserLeaveAccount {

    protected $_id;
    protected $_userId;
    protected $_transactionType;
    protected $_value;
    protected $_narration;
    protected $_leaveTypeId;
    //protected $_transactionDate;
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
            $this->setMapper(new Application_Model_UserLeaveAccountMapper());
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

    public function setTransactionType($transactionType)
    {
        $this->_transactionType = (string) $transactionType;
        return $this;
    }

    public function getTransactionType()
    {
        return $this->_transactionType;
    }
    public function setValue($value)
    {
        $this->_value = (float) $value;
        return $this;
    }

    public function getValue()
    {
        return $this->_value;
    }
    
    public function setNarration($narration)
    {
        $this->_narration = (string) $narration;
        return $this;
    }

    public function getNarration()
    {
        return $this->_narration;
    }
    public function setLeaveTypeId($leaveTypeId)
    {
        $this->_leaveTypeId = (int) $leaveTypeId;
        return $this;
    }

    public function getLeaveTypeId()
    {
        return $this->_leaveTypeId;
    }
    
//    public function setTransactionDate($transactionDate)
//    {
//        $this->_transactionDate = (string) $transactionDate;
//        return $this;
//    }
//
//    public function getTransactionDate()
//    {
//        return $this->_transactionDate;
//    }
    
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
    	
    		
            $model = new Application_Model_Designation();
            $model->setId($row->id)
                  	->setUserId($row->user_id)
                        ->setTransactionType($row->transaction_type)
                        ->setValue($row->value)
                        ->setNarration($row->narration)
                        ->setLeaveTypeId($row->leave_type_id)
                	->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                	;
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'user_id'   => $this->getUserId(),
            'transaction_type'   => $this->getTransactionType(),
            'value'   => $this->getValue(),
            'narration'   => $this->getNarration(),
            'leave_type_id' => $this->getLeaveTypeId()
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
    
    public function getBalanceLeave($leaveTypeId, $transactionTypeId, $userId)
    {
        $startTimestamp=mktime(0, 0, 0, 4, 1, date("Y")); //20011-04-01 00:00:00
        $endTimestamp=mktime(0, 0, 0, 3, 31, date("Y")+1); //2012-03-31 00:00:00
        $table=$this->getMapper()->getDbTable();
        $select = $table->select()->from('user_leave_account',"sum(value) as total")->where("addedon >= {$startTimestamp} and addedon <= {$endTimestamp} and user_id='{$userId}' and leave_type_id='{$leaveTypeId}' and transaction_type='{$transactionTypeId}' ");
        $total=$table->fetchRow($select)->total;
        if($total=="")
            $total=0;
        return $total;
        
    }
}

?>
