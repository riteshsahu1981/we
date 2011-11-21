<?php
class Application_Model_LeaveType {
    protected $_id;
    protected $_code;
    protected $_title;
    protected $_totalLeavesInYear;
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
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified' . $method);
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
            $this->setMapper(new Application_Model_LeaveTypeMapper());
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

    public function setCode($code)
    {
        $this->_code = (string) $code;
        return $this;
    }

    public function getCode()
    {
        return $this->_code;
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
    
    public function setTotalLeavesInYear($totalLeavesInYear)
    {
        $this->_totalLeavesInYear = (int) $totalLeavesInYear;
        return $this;
    }
	
    public function getTotalLeavesInYear()
    {
        return $this->_totalLeavesInYear;
       
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
      $model = new Application_Model_LeaveType();
			
      $model->setId($row->id)
            ->setCode($row->code)
            ->setTitle($row->title)
            ->setTotalLeavesInYear($row->total_leaves_in_year)
            ->setAddedon($row->addedon)
            ->setUpdatedon($row->updatedon)
						;
             return $model;
    }
    
    public function save()
    {
     	$data = array(
                'code'   => $this->getCode(),
     		'title'  => $this->getTitle(),
                'total_leaves_in_year'=>$this->getTotalLeavesInYear()
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
        	$data['updatedon']=time();
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
    
    public function isExist($where)
    {
    	$res=$this->fetchRow($where);

    	if($res===false)
       	{
            return false;
       	}
       	else 
       	{
            return true;
       	}
    }
    
    /*----Data Manupulation functions ----*/
    public function getLeaveTypeByCode($code)
    {
    	$model=new Application_Model_LeaveType();
    	$model=$model->fetchRow("code='{$code}'");
    	return $model;
    }
    
    public function getLeaveTypes()
    {
        $obj=new Application_Model_LeaveType();
        $entries=$obj->fetchAll();
        $arrUserLevel=array();
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getTitle()." [ ".$entry->getCode()." ]";
        }
        return $arrUserLevel;
    }
}
