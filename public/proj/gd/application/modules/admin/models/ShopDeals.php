<?php
class Admin_Model_ShopDeals {
	
	protected $_id;
    protected $_userId;
	protected $_dealAds1;    
    protected $_dealAds2;
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
     * @return Admin_Model_ShopDeals
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
     * @return Admin_Model_ShopDeals
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
     * Set userId
     * 
     * @param  int $userId 
     * @return Admin_Model_ShopDeals
     */
    public function setUserId($userId)
    {
        $this->_userId = (int) $userId;
        return $this;
    }

    /**
     * Retrieve entry userId
     * 
     * @return null|int
     */
    public function getUserId()
    {
        return $this->_userId;
    }


    /**
     * Set dealAds1
     * 
     * @param  string $dealAds1 
     * @return Admin_Model_ShopDeals
     */
    public function setDealAds1($dealAds1)
    {
        $this->_dealAds1 = (string) $dealAds1;
        return $this;
    }

 
    /**
     * Get dealAds1
     * 
     * @return null|string
     */
    public function getDealAds1()
    {
        return $this->_dealAds1;
    }
    
	/**
     * Set dealAds2
     * 
     * @param  string $dealAds2 
     * @return Admin_Model_ShopDeals
     */
    public function setDealAds2($dealAds2)
    {
        $this->_dealAds2 = (string) $dealAds2;
        return $this;
    }

 
    /**
     * Get dealAds2
     * 
     * @return null|string
     */
    public function getDealAds2()
    {
        return $this->_dealAds2;
    }

    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Admin_Model_ShopDeals
     */
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Lazy loads Admin_Model_ShopDealsMapper instance if no mapper registered.
     * 
     * @return Admin_Model_ShopDeals
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Admin_Model_ShopDealsMapper());
        }
        return $this->_mapper;
    }
        /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
         $model= new Admin_Model_ShopDeals();
         $model->setId($row->id)
               ->setUserId( $row->user_id)
               ->setDealAds1( $row->deal_ads1)
               ->setDealAds2( $row->deal_ads2)
               ;
             return $model;
    }
    
    public function save()
    {
    
     	$data = array(
            'user_id'   => $this->getUserId(),
        	'deal_ads1'   => $this->getDealAds1(),
        	'deal_ads2'   => $this->getDealAds2()        	
        );

        if (null === ($id = $this->getId()))
		{
           unset($data['id']);
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
}
