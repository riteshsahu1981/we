<?php
/**
 * User model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * user entry.
 * ->getMapper()->getDbTable()
 * @uses       Admin_Model_GlobalSettings
 * @package    Default
 * @subpackage Model
 */

class Admin_Model_GlobalSettings {
	
	 /**
     * @var int
     */
    protected $_id;
    
    /**
     * @var string
     */
    protected $_label;
    
    /**
     * @var string
     */
    protected $_identifire;
    
    /**
     * @var string
     */
    protected $_value;

    /**
     * @var Admin_Model_GlobalSettingsMapper
     */
    
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
     * @return Admin_Model_GlobalSettings
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

 	/**
     * Set entry id
     * 
     * @param  int $id 
     * @return Admin_Model_GlobalSettings
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
     * Set label
     * 
     * @param  string $label 
     * @return Admin_Model_GlobalSettings
     */
    public function setLabel($label)
    {
        $this->_label= (string) $label;
        return $this;
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
     * Set identifire
     * 
     * @param  string $identifire 
     * @return Admin_Model_GlobalSettings
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
     * Set value
     * 
     * @param  string $value 
     * @return Admin_Model_GlobalSettings
     */
    public function setValue($value)
    {
        $this->_value= (string) $value;
        return $this;
    }

 
    /**
     * Get value
     * 
     * @return null|string
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    
    
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Admin_Model_GlobalSettings
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Lazy loads Admin_Model_GlobalSettingsMapper instance if no mapper registered.
     * 
     * @return Admin_Model_GlobalSettings
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Admin_Model_GlobalSettingsMapper());
        }
        return $this->_mapper;
    }
	/*----Data Manupulation functions ----*/
    private function setModel($row)
    {
         $model= new Admin_Model_GlobalSettings();
         $model->setId($row->id)
               ->setLabel( $row->label)
               ->setIdentifire( $row->identifire)
               ->setValue( $row->value)
               ;
             return $model;
    }
    
    public function save()
    {
    	$data = array(
            'identifire'   => $this->getIdentifire(),
        	'label'   => $this->getLabel(),
        	'value'   => $this->getValue(),
        );

        if (null === ($id = $this->getId())) {
            unset($data['id']);
            return $this->getMapper()->getDbTable()->insert($data);
        } else {
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
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
    
    public function settingValue($identifire){
    
    	$res=$this->fetchRow("identifire='{$identifire}'");
    	
    	return $res->getValue();	
    }
    
    
    
}

?>