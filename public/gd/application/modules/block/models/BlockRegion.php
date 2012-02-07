<?php


class Block_Model_BlockRegion {
	
    protected $_id;
    
    
    protected $_title;
    
    protected $_alias;
    
 
    
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

  	public function setAlias($alias)
    {
        $this->_alias = (string) $alias;
        return $this;
    }

    public function getAlias()
    {
        return $this->_alias;
    }
  
         
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Block_Model_BlockRegionMapper());
        }
        return $this->_mapper;
    }

        
    private function setModel($row)
    {
    	$model=new Block_Model_BlockRegion();
    	$model->setId($row->id)
             ->setTitle($row->title)
             ->setAlias($row->alias)
            ;
            
            return $model;
    }
    
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save()
    {
    
        $data = array(
            'title'   => $this->getTitle(),
            'alias'   => $this->getAlias()
        );
        
        if (null === ($id = $this->getId())) {
            return $this->getMapper()->getDbTable()->insert($data);
        } 
        else 
        {
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
    
 	public function getBlockRegion($option=null)
    {
    	 $obj=new Block_Model_BlockRegion();
         $entries=$obj->fetchAll();
         $arrCountry=array();
         if(!is_null($option))
         $arrCountry['']=$option;
         foreach($entries as $entry)
         {         
         	$arrCountry[$entry->getId()] = ucfirst( strtolower($entry->getTitle()));	
         }
         return $arrCountry;
    }
    
}

?>