<?php
class Application_Model_TravelGuidesMetadata
{
    protected $_id;
    protected $_itemId;
	protected $_itemType;
	protected $_metaTitle;
	protected $_metaKeyword;
    protected $_metaDesc;
	protected $_addedon;
    protected $_updatedon;
    protected $_mapper;
    
    public function __construct(array $options = null)
    {
        if (is_array($options))
		{
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Setting invalid table property.');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Getting invalid table property'.$method);
        }
        return $this->$method();
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
            $this->setMapper(new Application_Model_TravelGuidesMetadataMapper());
        }
        return $this->_mapper;
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
	
	public function setMetaTitle($metaTitle)
    {
        $this->_metaTitle = (string) $metaTitle;
        return $this;
    }
    public function getMetaTitle()
    {
        return $this->_metaTitle;
    }
	
	public function setMetaKeyword($metaKeyword)
    {
        $this->_metaKeyword = (string) $metaKeyword;
        return $this;
    }
    public function getMetaKeyword()
    {
        return $this->_metaKeyword;
    }
    
    public function setMetaDesc($metaDesc)
    {
        $this->_metaDesc = (string) $metaDesc;
        return $this;
    }
    public function getMetaDesc()
    {
        return $this->_metaDesc;
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
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model = new Application_Model_TravelGuidesMetadata();
        $model->setId($row->id)
              ->setItemId($row->item_id)
			  ->setItemType($row->item_type)
              ->setMetaTitle($row->meta_title)
              ->setMetaKeyword($row->meta_keyword)
              ->setMetaDesc($row->meta_desc)
			  ->setAddedon($row->addedon)              
              ->setUpdatedon($row->updatedon)              
              ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
            'item_id'		=> $this->getItemId(),
			'item_type'	  	=> $this->getItemType(),
  	  		'meta_title' 	=> $this->getMetaTitle(),
  	  		'meta_keyword'  => $this->getMetaKeyword(),		
        	'meta_desc' 	=> $this->getMetaDesc(),
        );
		if (null === ($id = $this->getId()))
		{
			unset($data['id']);
			$data['addedon'] = date("Y-m-d H:i:s");
			return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
			$data['updatedon'] = date("Y-m-d H:i:s");
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
