<?php

class Application_Model_UserLevel {
	
	 /**
     * @var int
     */
    protected $_id;
    
    /**
     * @var string
     */
    protected $_identifire;
    
    /**
     * @var string
     */
    protected $_label;
    
    /**
     * @var status
     */
    protected $_status;

     /**
     * @var int
     */
    protected $_addedon;
        

     /**
     * @var int
     */
    protected $_updatedon;
    
   protected $_mapper;

    /**
     * Constructor
     * 
     * @param  array|null $options 
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @param  mixed $value 
     * @return void
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }

    /**
     * Overloading: allow property access
     * 
     * @param  string $name 
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        return $this->$method();
    }

    /**
     * Set object state
     * 
     * @param  array $options 
     * @return Application_Model_User
     */
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
            $this->setMapper(new Application_Model_UserLevelMapper());
        }
        return $this->_mapper;
    }
    
 	/**
     * Set entry id
     * 
     * @param  int $id 
     * @return Application_Model_UserLevel
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    /**
     * Retrieve entry id
     * 
     * @return null|int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set identifire
     * 
     * @param  string $identifire 
     * @return Application_Model_UserLevel
     */
    public function setIdentifire($identifire)
    {
        $this->_identifire= (string) $identifire;
        return $this;
    }

 
    /**
     * Get identifire
     * 
     * @return null|string
     */
    public function getIdentifire()
    {
        return $this->_identifire;
    }
    
   /**
     * Get label
     * 
     * @return null|string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * Set label
     * 
     * @param  string $label 
     * @return Application_Model_UserLevel
     */
    public function setLabel($label)
    {
        $this->_label = (string) $label;
        return $this;
    }   

    
     
   	/**
     * Get status
     * 
     * @return null|string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Set status
     * 
     * @param  string $status 
     * @return Application_Model_UserLevel
     */
    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }
    

   	/**
     * Get addedon
     * 
     * @return null|int
     */
    public function getAddedon()
    {
        return $this->_addedon;
    }

    /**
     * Set addedon
     * 
     * @param  int $addedon 
     * @return Application_Model_UserLevel
     */
    public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    
 
   	/**
     * Get updated
     * 
     * @return null|int
     */
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
    /**
     * Set updatedon
     * 
     * @param  int $updatedon 
     * @return Application_Model_UserLevel
     */
    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
        return $this;
    }

	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
 			$model = new Application_Model_UserLevel();
            $model->setId($row->id)
                 ->setIdentifire($row->identifire)
                  ->setLabel($row->label)
                  ->setStatus($row->status)
                  ->setAddedon($row->addedon)
                  ->setUpdatedon($row->updatedon)
                  ;
    	
             return $model;
    }
    
    public function save()
    {
    	$data = array(
            'identifire'   => $this->getIdentifire(),
        	'label'   => $this->getLabel(),
        	'status'   => $this->getStatus(),
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            $data['addedon']=time();
            $this->getMapper()->getDbTable()->insert($data);
        } else {
        	
        	$data['updatedon']=time();
        	
            $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
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

    /*------Data utility functions------*/
    public function getUserLevel()
    {
    	$obj=new Application_Model_UserLevel();
         $entries=$obj->fetchAll("status='active'");
         $arrUserLevel=array();
         foreach($entries as $entry)
         { 	
         	$arrUserLevel[$entry->getId()]=$entry->getLabel();
         }
         return $arrUserLevel;	
    }
    /*------Data utility functions------*/
    
}

?>