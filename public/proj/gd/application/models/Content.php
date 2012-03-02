<?php
class Application_Model_Content
{
    protected $_id;    
    protected $_title;
    protected $_alias;
    protected $_body;
	protected $_status;
	protected $_weight;
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
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception('Invalid property specified');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || !method_exists($this, $method))
		{
            throw new Exception('Invalid property specified');
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
            $this->setMapper(new Application_Model_ContentMapper());
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
    
    public function setBody($body)
    {
        $this->_body = (string) $body;
        return $this;
    }
    public function getBody()
    {
        return $this->_body;
    }

    public function setStatus($status)
    {
        $this->_status = (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }	

    public function setWeight($weight)
    {
        $this->_weight= (int) $weight;
        return $this;
    }
    public function getWeight()
    {
        return $this->_weight;
    }
	
	public function setAddedon($addedon)
    {
        $this->_addedon= (int) $addedon;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }
     
    public function setUpdatedon($updatedon)
    {
        $this->_updatedon= (int) $updatedon;
        return $this;
    }
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
         
    private function setModel($row)
    {
    	$model=new Application_Model_Content();
    	$model->setId($row->id)
             ->setTitle($row->title)
             ->setAlias($row->alias)
             ->setBody($row->body)
             ->setStatus($row->status)
             ->setWeight($row->weight);
             return $model;
    }
    
    public function save()
    {
        $data = array(
            'title'   => $this->getTitle(),
            'alias'   => $this->getAlias(),
            'body'   => $this->getBody(),
            'status' => $this->getStatus(),
        	'weight' => $this->getWeight(),
        );
        
        if (null === ($id = $this->getId()))
		{
            $data['addedon']=time();
            return $this->getMapper()->getDbTable()->insert($data);
        } 
        else 
        {
        	$data['updatedon']=time();
            return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }        
    }


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
	
	public function getContentText($alias)
	{
		$content = "No data available.";
		if($alias!="")
		{
			$alias = trim($alias);
			$where = "alias='{$alias}' AND status=1";
			$contentRes = $this->fetchRow($where);
			if($contentRes)
			{
				$content = $contentRes->getBody();
			}
		}
		else
		{
			$content = "Alias parameter is missing..";
		}
		//echo "com=".$content;exit;
		return $content;	
	}
}//end class
?>
