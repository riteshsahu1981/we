<?php
class Application_Model_Test
{   protected $_id;
    protected $_name;
    protected $_class;
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
            throw new Exception('Invalid Blog property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Blog property');
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
            $this->setMapper(new Application_Model_BlogMapper());
        }
        return $this->_mapper;
    }
    
    
    
    public function setId($id)
    {$this->_id = (int) $id ;
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
    
    public function setClass($class)
    {
    
     $this->_class=(string) $class;
     return $this;
     
    }
    
    public function getClass()
    {
      return $this->_class;
    
    }
    
    
    
    
    
 private function setModel($row)
    {
    	//$user=$row->findParentRow('Application_Model_DbTable_User','User');
    	$model=new Application_Model_Test();
        $model->setName($row->name)
              ->setClass($row->class)
                 
                  ;
             return $model;
    }
    
    
    public function save()
    {
    
  	  	$data = array(
            'name'   => $this->getName(),
  	  		'class'	=> $this->getClass(),
  	  		
  	  		
        );
    
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