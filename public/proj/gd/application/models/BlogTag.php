<?php
class Application_Model_BlogTag
{
    protected $_id;
    protected $_tagId;
    protected $_blogId;
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
            throw new Exception('Invalid Blog Tag property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Blog Tag property');
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
            $this->setMapper(new Application_Model_BlogTagMapper());
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
    
    public function setTagId($tagId)
    {
        $this->_tagId = (int) $tagId;
        return $this;
    }

    public function getTagId()
    {
        return $this->_tagId;
    }
    
    public function setBlogId($blogId)
    {
        $this->_blogId = (int) $blogId;
        return $this;
    }

    public function getBlogId()
    {
        return $this->_blogId;
    }
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model=new Application_Model_BlogTag();
        $model->setId($row->id)
                  ->setTagId($row->tag_id)
                  ->setBlogId($row->blog_id)
                  
                  ;
             return $model;
    }
    
    public function save()
    {
    
  	  	$data = array(
            'tag_id'   => $this->getTagId(),
  	  		'blog_id'	=> $this->getBlogId()  	  		
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

