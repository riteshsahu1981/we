<?php
class Application_Model_Job {

    protected $_id;
    protected $_title;
    protected $_description;
    protected $_status;
    protected $_noOfOpenings;
    protected $_postedById;
    protected $_departmentId;
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
            $this->setMapper(new Application_Model_JobMapper());
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

   public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setDescription($description)
    {
        $this->_description= (string) $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }
    public function setStatus($status)
    {
        $this->_status= (string) $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setNoOfOpenings($noOfOpenings)
    {
        $this->_noOfOpenings= (int) $noOfOpenings;
        return $this;
    }

    public function getNoOfOpenings()
    {
        return $this->_noOfOpenings;
    }
    public function setPostedById($postedById)
    {
        $this->_postedById= (int) $postedById;
        return $this;
    }

    public function getPostedById()
    {
        return $this->_postedById;
    }
    
    public function setDepartmentId($departmentId)
    {
        $this->_departmentId= (int) $departmentId;
        return $this;
    }

    public function getDepartmentId()
    {
        return $this->_departmentId;
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
    	
    		
            $model = new Application_Model_Job();
            $model->setId($row->id)
                  	->setTitle($row->title)
                        ->setDescription($row->description)
                        ->setStatus($row->status)
                        ->setNoOfOpenings($row->no_of_openings)
                        ->setPostedById($row->posted_by_id)
                        ->setDepartmentId($row->department_id)
                	->setAddedon($row->addedon)
                        ->setUpdatedon($row->updatedon)
                	;
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'title'   => $this->getTitle(),
            'description' => $this->getDescription(),
            'status'    => $this->getStatus(),
            'no_of_openings' => $this->getNoOfOpenings(),
            'posted_by_id' => $this->getPostedById(),
            'department_id' => $this->getDepartmentId()
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
 /*------Data utility functions------*/
    public function getDesignation()
    {
        $obj=new Application_Model_Designation();
        $entries=$obj->fetchAll();
        $arrUserLevel=array();
        foreach($entries as $entry)
        { 	
            $arrUserLevel[$entry->getId()]=$entry->getTitle();
        }
        return $arrUserLevel;	
    }
    /*------Data utility functions------*/
    
    
    
}